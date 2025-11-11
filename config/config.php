<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_NAME', 'Huisartspraktijk');
define('SITE_URL', 'http://localhost/huisarts-project');
define('ADMIN_EMAIL', 'admin@huisartspraktijk.nl');

// Security Settings
define('SESSION_LIFETIME', 3600); // 1 hour
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Europe/Amsterdam');
?>