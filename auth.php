<?php
// Don't start session here - let it be handled by the calling script
require_once __DIR__ . '/database/connection.php';

// Ensure session is started (safe check)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Require login - redirect to login page if not authenticated
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Get current user info
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT user_id, username, role FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error getting current user: " . $e->getMessage());
        return null;
    }
}

// Login function
function login($pdo, $username, $password) {    
    // Get rate limiter and audit logger
    $rateLimiter = getRateLimiter($pdo);
    $auditLogger = getAuditLogger($pdo);
    $clientIp = RateLimiter::getClientIdentifier();
    
    // Check rate limit
    $rateCheck = $rateLimiter->checkLimit($clientIp, 'login', 5, 300, 900);
    if (!$rateCheck['allowed']) {
        $auditLogger->log(AuditLogger::EVENT_RATE_LIMIT_EXCEEDED, [
            'severity' => AuditLogger::SEVERITY_WARNING,
            'username' => $username,
            'details' => [
                'action' => 'login',
                'retry_after' => $rateCheck['retryAfter']
            ],
            'success' => false
        ]);
        return false;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            // Generate session fingerprint for added security
            $_SESSION['fingerprint'] = hash('sha256', 
                $_SERVER['HTTP_USER_AGENT'] . 
                $clientIp . 
                session_id()
            );
            
            // Reset rate limit on successful login
            $rateLimiter->reset($clientIp, 'login');
            
            // Log successful login
            $auditLogger->log(AuditLogger::EVENT_LOGIN_SUCCESS, [
                'severity' => AuditLogger::SEVERITY_INFO,
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'details' => ['role' => $user['role']]
            ]);
            
            // Update last login time if you want to track it
            // $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
            // $stmt->execute([$user['user_id']]);
            
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            
            return true;
        }
        
        // Log failed login attempt
        $auditLogger->log(AuditLogger::EVENT_LOGIN_FAILURE, [
            'severity' => AuditLogger::SEVERITY_WARNING,
            'username' => $username,
            'details' => ['reason' => 'Invalid credentials'],
            'success' => false
        ]);
        
        return false;
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        
        // Log error
        $auditLogger->log(AuditLogger::EVENT_LOGIN_FAILURE, [
            'severity' => AuditLogger::SEVERITY_ERROR,
            'username' => $username,
            'details' => ['error' => 'Database error'],
            'success' => false
        ]);
        
        return false;
    }
}

// Logout function
function logout() {
    // Log logout event before clearing session
    if (isLoggedIn()) {
        try {
            $pdo = getDbConnection();
            $auditLogger = getAuditLogger($pdo);
            $auditLogger->log(AuditLogger::EVENT_LOGOUT, [
                'severity' => AuditLogger::SEVERITY_INFO
            ]);
        } catch (Exception $e) {
            error_log("Error logging logout: " . $e->getMessage());
        }
    }
    
    // Clear all session variables
    $_SESSION = array();
    
    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
}

// Check if admin
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// Check session timeout
function checkSessionTimeout() {
    if (isLoggedIn() && isset($_SESSION['login_time'])) {
        if ((time() - $_SESSION['login_time']) > SESSION_LIFETIME) {
            logout();
            header('Location: login.php?timeout=1');
            exit;
        }
    }
}

// Call this on every protected page to check session
function checkSession() {
    // Validate session fingerprint
    if (isLoggedIn() && isset($_SESSION['fingerprint'])) {
        $clientIp = RateLimiter::getClientIdentifier();
        $currentFingerprint = hash('sha256', 
            $_SERVER['HTTP_USER_AGENT'] . 
            $clientIp . 
            session_id()
        );
        
        // If fingerprint doesn't match, potential session hijacking
        if (!hash_equals($_SESSION['fingerprint'], $currentFingerprint)) {
            try {
                $pdo = getDbConnection();
                $auditLogger = getAuditLogger($pdo);
                $auditLogger->log(AuditLogger::EVENT_ACCESS_DENIED, [
                    'severity' => AuditLogger::SEVERITY_CRITICAL,
                    'details' => ['reason' => 'Session fingerprint mismatch'],
                    'success' => false
                ]);
            } catch (Exception $e) {
                error_log("Error logging fingerprint mismatch: " . $e->getMessage());
            }
            
            logout();
            header('Location: login.php?error=session_invalid');
            exit;
        }
    }
    
    checkSessionTimeout();
    requireLogin();
}
?>