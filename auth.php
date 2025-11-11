<?php
session_start();
require_once 'database/connection.php';

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
    global $pdo;
    
    if (!isLoggedIn()) {
        return null;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT user_id, username, role FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error getting current user: " . $e->getMessage());
        return null;
    }
}

// Login function
function login($username, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            // Update last login time if you want to track it
            // $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
            // $stmt->execute([$user['user_id']]);
            
            return true;
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return false;
    }
}

// Logout function
function logout() {
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
    checkSessionTimeout();
    requireLogin();
}
?>