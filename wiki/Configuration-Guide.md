# Configuration Guide

This guide covers all configuration options available in the Huisarts Project.

## 📁 Configuration Files

### Main Configuration File

Location: `config/config.php`

This is the primary configuration file containing database settings, application settings, and session configuration.

## 🔧 Database Configuration

### Basic Database Settings

```php
<?php
// Database Configuration
define('DB_HOST', 'localhost');        // Database host
define('DB_NAME', 'huisarts');         // Database name
define('DB_USER', 'huisarts_user');    // Database username
define('DB_PASS', 'your_password');    // Database password
define('DB_CHARSET', 'utf8mb4');       // Character set
```

### Connection Parameters

The database connection is established in `database/connection.php`:

```php
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed. Please contact administrator.");
    }
}
```

### Advanced Database Settings

For production environments, you may want to add:

```php
// Enable persistent connections (improves performance)
define('DB_PERSISTENT', true);

// Connection timeout
define('DB_TIMEOUT', 10);

// SSL Configuration (for secure connections)
define('DB_SSL_CA', '/path/to/ca-cert.pem');
define('DB_SSL_VERIFY', true);
```

## 🌐 Application Configuration

### Basic Application Settings

```php
// Application Configuration
define('APP_NAME', 'Huisarts Practice');
define('APP_URL', 'http://yourdomain.com');
define('APP_ENV', 'production'); // development, staging, production
define('APP_DEBUG', false);       // Set to true only in development

// Timezone
date_default_timezone_set('Europe/Amsterdam');

// Language
define('APP_LANGUAGE', 'en'); // en, nl, de, etc.
```

### Path Configuration

```php
// Path Configuration
define('BASE_PATH', dirname(__DIR__));
define('ASSETS_PATH', BASE_PATH . '/assets');
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('LOG_PATH', BASE_PATH . '/logs');

// URL Configuration
define('ASSETS_URL', APP_URL . '/assets');
define('UPLOAD_URL', APP_URL . '/uploads');
```

## 🔐 Session Configuration

### Session Settings

```php
// Session Configuration
ini_set('session.cookie_httponly', 1);    // Prevent JavaScript access
ini_set('session.use_only_cookies', 1);   // Use only cookies
ini_set('session.cookie_secure', 1);      // HTTPS only (set to 0 for HTTP)
ini_set('session.cookie_samesite', 'Lax'); // CSRF protection

// Session timeout (in seconds)
define('SESSION_TIMEOUT', 3600); // 1 hour

// Session name (customize for security)
session_name('HUISARTS_SESSION');
```

### Session Regeneration

Implement in `auth.php`:

```php
function startSecureSession() {
    session_start();
    
    // Regenerate session ID periodically
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } else if (time() - $_SESSION['last_regeneration'] > 300) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
```

## 🔒 Security Configuration

### Password Hashing

```php
// Password Configuration
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_REQUIRE_UPPERCASE', true);
define('PASSWORD_REQUIRE_LOWERCASE', true);
define('PASSWORD_REQUIRE_NUMBER', true);
define('PASSWORD_REQUIRE_SPECIAL', true);

// Password hashing algorithm
define('PASSWORD_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_COST', 12); // Higher = more secure but slower
```

### CSRF Protection

```php
// CSRF Configuration
define('CSRF_TOKEN_NAME', '_csrf_token');
define('CSRF_TOKEN_LENGTH', 32);
```

### Content Security Policy

Add to your header:

```php
// Content Security Policy
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' cdn.tailwindcss.com fonts.googleapis.com; font-src 'self' fonts.gstatic.com; img-src 'self' data:;");

// Additional security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
```

## 📧 Email Configuration

For contact form and notifications:

```php
// Email Configuration
define('MAIL_FROM', 'noreply@yourpractice.com');
define('MAIL_FROM_NAME', 'Huisarts Practice');
define('MAIL_ADMIN', 'admin@yourpractice.com');

// SMTP Settings (if using external SMTP)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_SECURE', 'tls'); // tls or ssl
```

## 📄 Pagination & Display

```php
// Pagination Configuration
define('DEFAULT_PER_PAGE', 25);
define('MAX_PER_PAGE', 100);
define('PER_PAGE_OPTIONS', [10, 25, 50, 100]);

// Date & Time Format
define('DATE_FORMAT', 'd-m-Y');
define('TIME_FORMAT', 'H:i:s');
define('DATETIME_FORMAT', 'd-m-Y H:i:s');
```

## 📁 File Upload Configuration

```php
// Upload Configuration
define('UPLOAD_MAX_SIZE', 5242880);        // 5MB in bytes
define('UPLOAD_ALLOWED_TYPES', [
    'image/jpeg',
    'image/png',
    'image/gif',
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);

// Upload directories
define('UPLOAD_PATIENT_DOCS', UPLOAD_PATH . '/patient_docs');
define('UPLOAD_PROFILE_PICS', UPLOAD_PATH . '/profiles');
```

## 🔍 Search Configuration

```php
// Search Configuration
define('SEARCH_MIN_LENGTH', 2);           // Minimum search query length
define('SEARCH_MAX_RESULTS', 100);        // Maximum search results
define('SEARCH_HIGHLIGHT', true);         // Highlight search terms
```

## 📊 Dashboard Configuration

```php
// Dashboard Configuration
define('DASHBOARD_RECENT_PATIENTS', 10);   // Number of recent patients to show
define('DASHBOARD_UPCOMING_APPOINTMENTS', 5); // Upcoming appointments
define('DASHBOARD_REFRESH_INTERVAL', 300); // Auto-refresh in seconds
```

## 🌍 Localization

Create `config/locales.php`:

```php
<?php
// Supported Languages
define('SUPPORTED_LOCALES', [
    'en' => 'English',
    'nl' => 'Nederlands',
    'de' => 'Deutsch',
    'fr' => 'Français'
]);

// Default locale
define('DEFAULT_LOCALE', 'en');

// Locale configuration
$locale_config = [
    'en' => [
        'date_format' => 'm/d/Y',
        'time_format' => 'h:i A',
        'currency' => 'USD',
        'currency_symbol' => '$'
    ],
    'nl' => [
        'date_format' => 'd-m-Y',
        'time_format' => 'H:i',
        'currency' => 'EUR',
        'currency_symbol' => '€'
    ]
];
```

## 🚨 Error Handling & Logging

```php
// Error Handling Configuration
define('LOG_ERRORS', true);
define('DISPLAY_ERRORS', false); // Set to true only in development
define('LOG_FILE', LOG_PATH . '/error.log');
define('LOG_LEVEL', 'error'); // debug, info, warning, error, critical

// Error reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', LOG_FILE);
}
```

## ⚡ Performance Configuration

```php
// Performance Configuration
define('ENABLE_CACHING', true);
define('CACHE_LIFETIME', 3600); // 1 hour
define('CACHE_DIR', BASE_PATH . '/cache');

// Output compression
ini_set('zlib.output_compression', 'On');
ini_set('zlib.output_compression_level', 6);

// Memory limit
ini_set('memory_limit', '256M');

// Max execution time
ini_set('max_execution_time', 30);
```

## 🔐 API Configuration

If you're implementing an API:

```php
// API Configuration
define('API_ENABLED', false);
define('API_VERSION', 'v1');
define('API_RATE_LIMIT', 100); // Requests per hour
define('API_KEY_LENGTH', 32);

// CORS Configuration
define('API_CORS_ENABLED', true);
define('API_CORS_ORIGINS', ['https://yourfrontend.com']);
define('API_CORS_METHODS', ['GET', 'POST', 'PUT', 'DELETE']);
```

## 🔄 Backup Configuration

```php
// Backup Configuration
define('BACKUP_ENABLED', true);
define('BACKUP_DIR', BASE_PATH . '/backups');
define('BACKUP_RETENTION_DAYS', 30); // Keep backups for 30 days
define('BACKUP_SCHEDULE', 'daily'); // daily, weekly, monthly
```

## 📱 Environment-Specific Configuration

### Development Environment

```php
// config/environment/development.php
define('APP_ENV', 'development');
define('APP_DEBUG', true);
define('DISPLAY_ERRORS', true);
define('DB_HOST', 'localhost');
define('APP_URL', 'http://localhost/huisarts-project');
```

### Production Environment

```php
// config/environment/production.php
define('APP_ENV', 'production');
define('APP_DEBUG', false);
define('DISPLAY_ERRORS', false);
define('DB_HOST', 'production-db-server');
define('APP_URL', 'https://yourpractice.com');
```

Load environment-specific config:

```php
// In config.php
$env = getenv('APP_ENV') ?: 'development';
require_once __DIR__ . '/environment/' . $env . '.php';
```

## ✅ Configuration Checklist

Before going to production:

- [ ] Update database credentials
- [ ] Set `APP_DEBUG` to `false`
- [ ] Enable `session.cookie_secure` (requires HTTPS)
- [ ] Configure proper error logging
- [ ] Set strong session security
- [ ] Configure email settings
- [ ] Review file upload limits
- [ ] Enable HTTPS
- [ ] Configure backups
- [ ] Set appropriate file permissions
- [ ] Remove or secure test accounts
- [ ] Configure rate limiting
- [ ] Review security headers

## 🔍 Testing Configuration

Always test your configuration:

```php
// Create config/test_config.php
<?php
require_once 'config.php';

echo "Configuration Test\n";
echo "==================\n\n";

// Test database connection
try {
    $pdo = getDbConnection();
    echo "✓ Database connection: OK\n";
} catch (Exception $e) {
    echo "✗ Database connection: FAILED\n";
    echo "  Error: " . $e->getMessage() . "\n";
}

// Test session
session_start();
echo "✓ Session: OK\n";

// Test timezone
echo "✓ Timezone: " . date_default_timezone_get() . "\n";

// Test paths
echo "✓ Base Path: " . BASE_PATH . "\n";
echo "✓ Upload Path: " . (is_writable(UPLOAD_PATH) ? "OK (writable)" : "FAILED (not writable)") . "\n";

echo "\nConfiguration test complete!\n";
```

Run: `php config/test_config.php`

## 📚 Related Documentation

- [Installation Guide](Installation-Guide) - Installing the application
- [Security Guidelines](Security-Guidelines) - Security best practices
- [Development Guide](Development-Guide) - Development setup

---

**Need Help?** Check the [FAQ](FAQ) or [Troubleshooting](Troubleshooting) guides.
