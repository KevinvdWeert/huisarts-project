<?php
/**
 * Audit Logger
 * Logs security-sensitive operations for compliance and security monitoring
 */

class AuditLogger {
    private $pdo;
    private $tableName = 'audit_logs';
    
    // Event types
    const EVENT_LOGIN_SUCCESS = 'login_success';
    const EVENT_LOGIN_FAILURE = 'login_failure';
    const EVENT_LOGOUT = 'logout';
    const EVENT_PASSWORD_CHANGE = 'password_change';
    const EVENT_PATIENT_CREATE = 'patient_create';
    const EVENT_PATIENT_UPDATE = 'patient_update';
    const EVENT_PATIENT_DELETE = 'patient_delete';
    const EVENT_PATIENT_VIEW = 'patient_view';
    const EVENT_NOTE_CREATE = 'note_create';
    const EVENT_NOTE_UPDATE = 'note_update';
    const EVENT_NOTE_DELETE = 'note_delete';
    const EVENT_NOTE_VIEW = 'note_view';
    const EVENT_ACCESS_DENIED = 'access_denied';
    const EVENT_RATE_LIMIT_EXCEEDED = 'rate_limit_exceeded';
    
    // Severity levels
    const SEVERITY_INFO = 'info';
    const SEVERITY_WARNING = 'warning';
    const SEVERITY_ERROR = 'error';
    const SEVERITY_CRITICAL = 'critical';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->createTableIfNotExists();
    }
    
    /**
     * Create audit_logs table if it doesn't exist
     */
    private function createTableIfNotExists() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS audit_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                event_type VARCHAR(100) NOT NULL,
                severity VARCHAR(20) DEFAULT 'info',
                user_id INT NULL,
                username VARCHAR(100) NULL,
                ip_address VARCHAR(45) NOT NULL,
                user_agent TEXT NULL,
                resource_type VARCHAR(50) NULL,
                resource_id INT NULL,
                action_details TEXT NULL,
                success BOOLEAN DEFAULT TRUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_event_type (event_type),
                INDEX idx_user_id (user_id),
                INDEX idx_created_at (created_at),
                INDEX idx_resource (resource_type, resource_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            error_log("Failed to create audit_logs table: " . $e->getMessage());
        }
    }
    
    /**
     * Log an audit event
     * 
     * @param string $eventType Type of event (use class constants)
     * @param array $options Additional options:
     *   - severity: string (info, warning, error, critical)
     *   - user_id: int
     *   - username: string
     *   - resource_type: string (e.g., 'patient', 'note')
     *   - resource_id: int
     *   - details: array|string (will be JSON encoded if array)
     *   - success: bool
     * @return bool Success status
     */
    public function log($eventType, $options = []) {
        try {
            $defaults = [
                'severity' => self::SEVERITY_INFO,
                'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
                'username' => isset($_SESSION['username']) ? $_SESSION['username'] : null,
                'ip_address' => $this->getClientIp(),
                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                'resource_type' => null,
                'resource_id' => null,
                'details' => null,
                'success' => true
            ];
            
            $data = array_merge($defaults, $options);
            
            // JSON encode details if it's an array
            if (is_array($data['details'])) {
                $data['details'] = json_encode($data['details']);
            }
            
            $stmt = $this->pdo->prepare("
                INSERT INTO {$this->tableName} 
                (event_type, severity, user_id, username, ip_address, user_agent, 
                 resource_type, resource_id, action_details, success, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            return $stmt->execute([
                $eventType,
                $data['severity'],
                $data['user_id'],
                $data['username'],
                $data['ip_address'],
                $data['user_agent'],
                $data['resource_type'],
                $data['resource_id'],
                $data['details'],
                $data['success']
            ]);
            
        } catch (PDOException $e) {
            error_log("Audit log error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Query audit logs
     * 
     * @param array $filters Filters:
     *   - event_type: string
     *   - user_id: int
     *   - resource_type: string
     *   - resource_id: int
     *   - start_date: string (Y-m-d H:i:s)
     *   - end_date: string (Y-m-d H:i:s)
     *   - limit: int
     * @return array Audit log entries
     */
    public function query($filters = []) {
        try {
            $where = [];
            $params = [];
            
            if (isset($filters['event_type'])) {
                $where[] = "event_type = ?";
                $params[] = $filters['event_type'];
            }
            
            if (isset($filters['user_id'])) {
                $where[] = "user_id = ?";
                $params[] = $filters['user_id'];
            }
            
            if (isset($filters['resource_type'])) {
                $where[] = "resource_type = ?";
                $params[] = $filters['resource_type'];
            }
            
            if (isset($filters['resource_id'])) {
                $where[] = "resource_id = ?";
                $params[] = $filters['resource_id'];
            }
            
            if (isset($filters['start_date'])) {
                $where[] = "created_at >= ?";
                $params[] = $filters['start_date'];
            }
            
            if (isset($filters['end_date'])) {
                $where[] = "created_at <= ?";
                $params[] = $filters['end_date'];
            }
            
            $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
            $limit = isset($filters['limit']) ? intval($filters['limit']) : 100;
            
            $sql = "SELECT * FROM {$this->tableName} {$whereClause} ORDER BY created_at DESC LIMIT {$limit}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Audit query error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Clean up old audit logs
     * 
     * @param int $daysToKeep Number of days to retain logs
     * @return int Number of deleted records
     */
    public function cleanup($daysToKeep = 365) {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM {$this->tableName} 
                WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)
            ");
            $stmt->execute([$daysToKeep]);
            
            return $stmt->rowCount();
            
        } catch (PDOException $e) {
            error_log("Audit cleanup error: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get client IP address
     * 
     * @return string
     */
    private function getClientIp() {
        $headers = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'REMOTE_ADDR'
        ];
        
        foreach ($headers as $header) {
            if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                if (strpos($ip, ',') !== false) {
                    $ips = explode(',', $ip);
                    $ip = trim($ips[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        
        return 'unknown';
    }
}

/**
 * Helper function to get audit logger instance
 * 
 * @param PDO $pdo
 * @return AuditLogger
 */
function getAuditLogger($pdo) {
    static $auditLogger = null;
    if ($auditLogger === null) {
        $auditLogger = new AuditLogger($pdo);
    }
    return $auditLogger;
}
?>
