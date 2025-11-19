<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_NAME', 'Medical Practice');
define('SITE_URL', 'http://localhost/huisarts-project');
define('ADMIN_EMAIL', 'admin@huisartspraktijk.nl');

// Session Configuration - Only set if session is not active
if (session_status() === PHP_SESSION_NONE) {
    // Security Settings
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS
    ini_set('session.cookie_samesite', 'Strict');
    
    // Session lifetime
    ini_set('session.gc_maxlifetime', 3600); // 1 hour
    ini_set('session.cookie_lifetime', 3600);
}

// Define session lifetime constant for application use
define('SESSION_LIFETIME', 3600); // 1 hour

// Encryption Configuration for Patient Notes
// IMPORTANT: Change this key in production! Keep it secret and secure.
// Generate a new key using: base64_encode(openssl_random_pseudo_bytes(32))
define('ENCRYPTION_KEY', 'MzJjaGFyYWN0ZXJrZXlmb3JBRVMyNTZlbmNyeXB0'); // 32-byte key base64 encoded

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Europe/Amsterdam');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>