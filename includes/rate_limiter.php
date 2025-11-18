<?php
/**
 * Rate Limiter
 * Prevents brute force attacks by limiting request rates
 */

class RateLimiter {
    private $pdo;
    private $tableName = 'rate_limits';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->createTableIfNotExists();
    }
    
    /**
     * Create rate_limits table if it doesn't exist
     */
    private function createTableIfNotExists() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS rate_limits (
                id INT AUTO_INCREMENT PRIMARY KEY,
                identifier VARCHAR(255) NOT NULL,
                action VARCHAR(100) NOT NULL,
                attempts INT DEFAULT 1,
                first_attempt DATETIME DEFAULT CURRENT_TIMESTAMP,
                last_attempt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                locked_until DATETIME NULL,
                INDEX idx_identifier_action (identifier, action),
                INDEX idx_locked_until (locked_until)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            error_log("Failed to create rate_limits table: " . $e->getMessage());
        }
    }
    
    /**
     * Check if action is allowed based on rate limit
     * 
     * @param string $identifier Unique identifier (IP, username, etc.)
     * @param string $action Action being performed (e.g., 'login', 'api_call')
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $windowSeconds Time window in seconds
     * @param int $lockoutSeconds Lockout duration after exceeding limit
     * @return array ['allowed' => bool, 'retryAfter' => int|null]
     */
    public function checkLimit($identifier, $action, $maxAttempts = 5, $windowSeconds = 300, $lockoutSeconds = 900) {
        try {
            // Clean up old records
            $this->cleanup($windowSeconds);
            
            // Check if currently locked out
            $stmt = $this->pdo->prepare("
                SELECT locked_until, attempts 
                FROM {$this->tableName} 
                WHERE identifier = ? AND action = ? AND locked_until > NOW()
            ");
            $stmt->execute([$identifier, $action]);
            $locked = $stmt->fetch();
            
            if ($locked) {
                $retryAfter = strtotime($locked['locked_until']) - time();
                return [
                    'allowed' => false,
                    'retryAfter' => max(0, $retryAfter),
                    'reason' => 'Account temporarily locked due to too many attempts'
                ];
            }
            
            // Check attempts in current window
            $stmt = $this->pdo->prepare("
                SELECT id, attempts, first_attempt 
                FROM {$this->tableName} 
                WHERE identifier = ? AND action = ? 
                    AND first_attempt > DATE_SUB(NOW(), INTERVAL ? SECOND)
                    AND (locked_until IS NULL OR locked_until <= NOW())
            ");
            $stmt->execute([$identifier, $action, $windowSeconds]);
            $record = $stmt->fetch();
            
            if ($record) {
                if ($record['attempts'] >= $maxAttempts) {
                    // Lock the account
                    $lockUntil = date('Y-m-d H:i:s', time() + $lockoutSeconds);
                    $stmt = $this->pdo->prepare("
                        UPDATE {$this->tableName} 
                        SET locked_until = ?, last_attempt = NOW()
                        WHERE id = ?
                    ");
                    $stmt->execute([$lockUntil, $record['id']]);
                    
                    return [
                        'allowed' => false,
                        'retryAfter' => $lockoutSeconds,
                        'reason' => 'Too many attempts. Account locked for ' . ceil($lockoutSeconds / 60) . ' minutes'
                    ];
                }
                
                // Increment attempts
                $stmt = $this->pdo->prepare("
                    UPDATE {$this->tableName} 
                    SET attempts = attempts + 1, last_attempt = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$record['id']]);
                
                return [
                    'allowed' => true,
                    'remaining' => $maxAttempts - $record['attempts'] - 1
                ];
            } else {
                // Create new record
                $stmt = $this->pdo->prepare("
                    INSERT INTO {$this->tableName} (identifier, action, attempts, first_attempt, last_attempt)
                    VALUES (?, ?, 1, NOW(), NOW())
                ");
                $stmt->execute([$identifier, $action]);
                
                return [
                    'allowed' => true,
                    'remaining' => $maxAttempts - 1
                ];
            }
            
        } catch (PDOException $e) {
            error_log("Rate limiter error: " . $e->getMessage());
            // On error, allow the action (fail open) but log it
            return ['allowed' => true, 'error' => true];
        }
    }
    
    /**
     * Reset rate limit for an identifier/action
     * 
     * @param string $identifier
     * @param string $action
     */
    public function reset($identifier, $action) {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM {$this->tableName} 
                WHERE identifier = ? AND action = ?
            ");
            $stmt->execute([$identifier, $action]);
        } catch (PDOException $e) {
            error_log("Rate limiter reset error: " . $e->getMessage());
        }
    }
    
    /**
     * Clean up old rate limit records
     * 
     * @param int $olderThanSeconds
     */
    private function cleanup($olderThanSeconds = 3600) {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM {$this->tableName} 
                WHERE first_attempt < DATE_SUB(NOW(), INTERVAL ? SECOND)
                    AND (locked_until IS NULL OR locked_until < NOW())
            ");
            $stmt->execute([$olderThanSeconds]);
        } catch (PDOException $e) {
            error_log("Rate limiter cleanup error: " . $e->getMessage());
        }
    }
    
    /**
     * Get client identifier (IP address)
     * 
     * @return string
     */
    public static function getClientIdentifier() {
        // Check for proxy headers
        $headers = [
            'HTTP_CF_CONNECTING_IP',  // Cloudflare
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'REMOTE_ADDR'
        ];
        
        foreach ($headers as $header) {
            if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                // Handle comma-separated IPs
                if (strpos($ip, ',') !== false) {
                    $ips = explode(',', $ip);
                    $ip = trim($ips[0]);
                }
                // Validate IP
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        
        return 'unknown';
    }
}

/**
 * Helper function to get rate limiter instance
 * 
 * @param PDO $pdo
 * @return RateLimiter
 */
function getRateLimiter($pdo) {
    static $rateLimiter = null;
    if ($rateLimiter === null) {
        $rateLimiter = new RateLimiter($pdo);
    }
    return $rateLimiter;
}
?>
