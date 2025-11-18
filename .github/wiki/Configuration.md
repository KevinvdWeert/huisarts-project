# Configuration

## Overview

This guide covers all configuration options for the Medical Practice Management System.

## Database Configuration

### Primary Configuration File

Location: `config/config.php`

```php
<?php
// Database Configuration
define('DB_HOST', 'localhost');      // Database host
define('DB_NAME', 'huisarts');       // Database name
define('DB_USER', 'root');           // Database username
define('DB_PASS', '');               // Database password
define('DB_CHARSET', 'utf8mb4');     // Character set

// Application Settings
define('APP_NAME', 'Medical Practice Management');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development');    // development or production

// Session Configuration
define('SESSION_TIMEOUT', 3600);     // 1 hour in seconds

// Pagination
define('DEFAULT_PER_PAGE', 25);      // Default items per page
define('MAX_PER_PAGE', 100);         // Maximum items per page

// Security
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);

// Timezone
date_default_timezone_set('Europe/Amsterdam');

// Error Reporting (set to 0 in production)
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
```

## Environment-Specific Settings

### Development Environment

```php
define('APP_ENV', 'development');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');

// Enable error display
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Production Environment

```php
define('APP_ENV', 'production');
define('DB_HOST', 'production-db-host.com');
define('DB_USER', 'secure_username');
define('DB_PASS', 'strong_password_here');

// Disable error display
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
```

## Database Connection

The connection is established in `database/connection.php`:

```php
<?php
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        die("Database connection failed. Please check your configuration.");
    }
}
?>
```

## Session Configuration

### PHP Session Settings

In `config/config.php` or `php.ini`:

```php
// Session lifetime
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);

// Session cookie parameters
session_set_cookie_params([
    'lifetime' => SESSION_TIMEOUT,
    'path' => '/',
    'domain' => '',
    'secure' => true,      // Use HTTPS in production
    'httponly' => true,
    'samesite' => 'Strict'
]);
```

## Web Server Configuration

### Apache (.htaccess)

```apache
# Enable Rewrite Engine
RewriteEngine On

# Redirect HTTP to HTTPS (production)
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Prevent directory listing
Options -Indexes

# Protect sensitive files
<FilesMatch "^(config\.php|connection\.php)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# PHP security settings
php_flag display_errors Off
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/huisarts-project;
    index index.php index.html;

    # SSL Configuration (production)
    # listen 443 ssl http2;
    # ssl_certificate /path/to/cert.pem;
    # ssl_certificate_key /path/to/key.pem;

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to sensitive files
    location ~ /(config|database)/.*\.php$ {
        deny all;
    }

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
}
```

## PHP Configuration

### Recommended php.ini Settings

```ini
; Error handling
display_errors = Off          ; On for development
log_errors = On
error_log = /path/to/error.log

; Resource limits
memory_limit = 256M
max_execution_time = 300
max_input_time = 300

; Upload settings
upload_max_filesize = 10M
post_max_size = 10M

; Session settings
session.gc_maxlifetime = 3600
session.cookie_httponly = On
session.cookie_secure = On    ; For HTTPS
session.use_strict_mode = On

; Security
expose_php = Off
allow_url_fopen = Off
allow_url_include = Off
```

## Security Configuration

### Password Hashing

In `auth.php`:

```php
// Hash password (when creating user)
$hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

// Verify password (when logging in)
if (password_verify($input_password, $stored_hash)) {
    // Password is correct
}
```

### CSRF Protection (To Be Implemented)

```php
// Generate token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify token
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && 
           hash_equals($_SESSION['csrf_token'], $token);
}
```

## Email Configuration (Optional)

For contact forms and notifications:

```php
// config/config.php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_FROM', 'noreply@yourpractice.com');
define('SMTP_FROM_NAME', 'Medical Practice');
```

## Backup Configuration

### Automated Database Backups

```bash
#!/bin/bash
# backup.sh

TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/path/to/backups"
DB_NAME="huisarts"
DB_USER="root"
DB_PASS="password"

mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/backup_$TIMESTAMP.sql

# Keep only last 30 days of backups
find $BACKUP_DIR -name "backup_*.sql" -mtime +30 -delete
```

### Cron Job (Linux)

```bash
# Run daily at 2 AM
0 2 * * * /path/to/backup.sh
```

### Task Scheduler (Windows)

```powershell
# backup.ps1
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$backupPath = "C:\backups\backup_$timestamp.sql"

& "C:\laragon\bin\mysql\mysql-5.7\bin\mysqldump.exe" `
    -u root -p huisarts > $backupPath

# Keep only last 30 days
Get-ChildItem "C:\backups" -Filter "backup_*.sql" | 
    Where-Object { $_.LastWriteTime -lt (Get-Date).AddDays(-30) } | 
    Remove-Item
```

## Logging Configuration

### Application Logging

```php
// includes/logger.php
function logMessage($level, $message) {
    $timestamp = date('Y-m-d H:i:s');
    $logFile = __DIR__ . '/../logs/app.log';
    $logEntry = "[$timestamp] [$level] $message\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Usage
logMessage('INFO', 'User logged in: ' . $username);
logMessage('ERROR', 'Database connection failed');
```

## Performance Optimization

### Enable OPcache

```ini
; php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

### Database Optimization

```sql
-- Enable query cache (MySQL 5.7)
SET GLOBAL query_cache_size = 67108864;
SET GLOBAL query_cache_type = ON;

-- Optimize tables periodically
OPTIMIZE TABLE patients;
OPTIMIZE TABLE notes;
OPTIMIZE TABLE users;
```

## Troubleshooting

### Connection Issues

**Problem:** Cannot connect to database

**Solution:**
1. Verify credentials in `config/config.php`
2. Check MySQL service is running
3. Test connection: `mysql -u root -p`

### Session Issues

**Problem:** Users logged out unexpectedly

**Solution:**
1. Increase `SESSION_TIMEOUT`
2. Check session storage permissions
3. Verify `session.gc_maxlifetime` in php.ini

### Permission Issues

**Problem:** Cannot write to files/directories

**Solution:**
```bash
# Linux/Mac
chmod -R 755 /path/to/project
chmod -R 777 /path/to/project/logs

# Windows (PowerShell as Admin)
icacls "C:\laragon\www\project" /grant Everyone:(OI)(CI)F /T
```

## Environment Variables (Alternative Approach)

### Using .env File

Create `.env`:
```
DB_HOST=localhost
DB_NAME=huisarts
DB_USER=root
DB_PASS=
APP_ENV=development
```

Load in PHP:
```php
// Load .env file
$env = parse_ini_file(__DIR__ . '/.env');
define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
// ... etc
```

**Important:** Add `.env` to `.gitignore`!

## Related Documentation

- [Installation Guide](Installation-Guide) - Initial setup
- [Architecture](Architecture) - System architecture
- [Deployment](Deployment) - Production deployment
