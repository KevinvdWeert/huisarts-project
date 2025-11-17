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

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Europe/Amsterdam');
?>