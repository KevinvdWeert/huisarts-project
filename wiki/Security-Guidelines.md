# Security Guidelines

Comprehensive security guidelines for deploying and maintaining the Huisarts Project.

## 🔒 Security Overview

Security is paramount when handling medical data. This guide covers essential security practices for the Huisarts Project.

## ⚠️ Critical Security Checklist

Before deploying to production:

- [ ] Change all default passwords
- [ ] Enable HTTPS/SSL
- [ ] Configure secure session settings
- [ ] Set proper file permissions
- [ ] Enable security headers
- [ ] Configure firewall rules
- [ ] Implement rate limiting
- [ ] Set up regular backups
- [ ] Enable error logging (disable display)
- [ ] Review and harden database security
- [ ] Implement CSRF protection
- [ ] Configure Content Security Policy
- [ ] Remove development tools and files
- [ ] Update all software to latest versions

## 🔐 Authentication & Authorization

### Password Security

#### Requirements

Enforce strong password policies:

```php
// Password Requirements
define('PASSWORD_MIN_LENGTH', 12);      // Minimum 12 characters
define('PASSWORD_REQUIRE_UPPERCASE', true);
define('PASSWORD_REQUIRE_LOWERCASE', true);
define('PASSWORD_REQUIRE_NUMBER', true);
define('PASSWORD_REQUIRE_SPECIAL', true);
```

#### Password Hashing

Always use PHP's `password_hash()`:

```php
// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

// Verify password
if (password_verify($input_password, $stored_hash)) {
    // Password correct
    
    // Check if rehashing is needed (algorithm updated)
    if (password_needs_rehash($stored_hash, PASSWORD_DEFAULT, ['cost' => 12])) {
        $new_hash = password_hash($input_password, PASSWORD_DEFAULT, ['cost' => 12]);
        // Update database with new hash
    }
}
```

**Never**:
- Store passwords in plain text
- Use MD5 or SHA1 for passwords
- Use custom encryption for passwords

### Session Security

#### Secure Session Configuration

```php
// Session security settings
ini_set('session.cookie_httponly', 1);     // Prevent JavaScript access
ini_set('session.use_only_cookies', 1);    // Only use cookies
ini_set('session.cookie_secure', 1);       // HTTPS only
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection
ini_set('session.use_strict_mode', 1);     // Reject uninitialized session IDs

// Custom session name
session_name('HUISARTS_SID');

// Session timeout
define('SESSION_LIFETIME', 3600); // 1 hour

session_start();
```

#### Session Regeneration

Regenerate session ID after login and periodically:

```php
// After successful login
session_regenerate_id(true);

// Periodic regeneration (every 30 minutes)
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
```

#### Session Validation

Validate session on each request:

```php
function validateSession() {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    // Validate IP address (optional, may cause issues with mobile)
    if (isset($_SESSION['ip']) && $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
        session_destroy();
        return false;
    }
    
    // Validate user agent
    if (isset($_SESSION['user_agent']) && 
        $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_destroy();
        return false;
    }
    
    // Check session timeout
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity']) > SESSION_LIFETIME) {
        session_destroy();
        return false;
    }
    
    $_SESSION['last_activity'] = time();
    return true;
}
```

### Access Control

Implement role-based access control:

```php
function requireRole($required_role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
        header('HTTP/1.1 403 Forbidden');
        die('Access denied');
    }
}

// Usage
requireRole('admin'); // Only admins can access
```

## 🛡️ Input Validation & Sanitization

### Always Validate Input

```php
// Validate and sanitize input
function validateInput($data, $type = 'string') {
    // Remove whitespace
    $data = trim($data);
    
    switch ($type) {
        case 'email':
            return filter_var($data, FILTER_VALIDATE_EMAIL);
            
        case 'int':
            return filter_var($data, FILTER_VALIDATE_INT);
            
        case 'string':
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            
        case 'url':
            return filter_var($data, FILTER_VALIDATE_URL);
            
        default:
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}

// Usage
$email = validateInput($_POST['email'], 'email');
$name = validateInput($_POST['name'], 'string');
```

### Prevent SQL Injection

**Always use prepared statements**:

```php
// Good: Prepared statement
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$patient_id]);
$patient = $stmt->fetch();

// Also good: Named parameters
$stmt = $pdo->prepare("SELECT * FROM patients WHERE email = :email");
$stmt->execute(['email' => $email]);
$patient = $stmt->fetch();

// BAD: Direct concatenation (DO NOT USE)
// $query = "SELECT * FROM patients WHERE patient_id = " . $patient_id;
```

### Prevent XSS (Cross-Site Scripting)

```php
// Always escape output
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');

// For displaying in HTML attributes
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');

// For JavaScript strings
echo json_encode($user_input, JSON_HEX_TAG | JSON_HEX_AMP);
```

### Prevent CSRF (Cross-Site Request Forgery)

#### Generate CSRF Token

```php
// Generate token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Add to forms
<input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
```

#### Validate CSRF Token

```php
// Validate token
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

// Usage in POST handlers
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    // Process form...
}
```

## 🌐 HTTP Security Headers

### Essential Security Headers

Add to `.htaccess` (Apache):

```apache
# Security Headers
<IfModule mod_headers.c>
    # Prevent XSS attacks
    Header set X-XSS-Protection "1; mode=block"
    
    # Prevent clickjacking
    Header set X-Frame-Options "DENY"
    
    # Prevent MIME type sniffing
    Header set X-Content-Type-Options "nosniff"
    
    # Content Security Policy
    Header set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' fonts.googleapis.com; font-src 'self' fonts.gstatic.com; img-src 'self' data:;"
    
    # Referrer Policy
    Header set Referrer-Policy "strict-origin-when-cross-origin"
    
    # HSTS (if using HTTPS)
    Header set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    
    # Permissions Policy
    Header set Permissions-Policy "geolocation=(), microphone=(), camera=()"
</IfModule>
```

Or add to PHP:

```php
// In includes/header.php or config
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

// If using HTTPS
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
```

## 🔥 Firewall & Network Security

### Database Security

```sql
-- Remove test databases
DROP DATABASE IF EXISTS test;

-- Remove anonymous users
DELETE FROM mysql.user WHERE User='';

-- Remove remote root access
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');

-- Flush privileges
FLUSH PRIVILEGES;
```

### Restrict Database Access

```sql
-- Create dedicated user with limited privileges
CREATE USER 'huisarts_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON huisarts.* TO 'huisarts_user'@'localhost';
FLUSH PRIVILEGES;

-- Do NOT grant FILE, SUPER, or other admin privileges
```

### Firewall Configuration

```bash
# UFW (Ubuntu/Debian)
sudo ufw allow 80/tcp     # HTTP
sudo ufw allow 443/tcp    # HTTPS
sudo ufw allow 22/tcp     # SSH (change port if possible)
sudo ufw deny 3306/tcp    # Block MySQL from external access
sudo ufw enable

# iptables
sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 3306 -j DROP
```

## 📁 File & Directory Security

### Proper File Permissions

```bash
# Set directory permissions (755)
find /var/www/html/huisarts-project -type d -exec chmod 755 {} \;

# Set file permissions (644)
find /var/www/html/huisarts-project -type f -exec chmod 644 {} \;

# Secure config file (600)
chmod 600 config/config.php

# Set ownership
chown -R www-data:www-data /var/www/html/huisarts-project
```

### Protect Sensitive Files

Create `.htaccess` in sensitive directories:

```apache
# In /config directory
<Files "config.php">
    Require all denied
</Files>

# In /database directory
<FilesMatch "\.(sql|csv)$">
    Require all denied
</FilesMatch>
```

### Disable Directory Listing

```apache
# In root .htaccess
Options -Indexes
```

## 🔍 Error Handling & Logging

### Production Error Settings

```php
// In production
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/huisarts/error.log');

// Custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Log error
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    
    // Display generic message to user
    if ($errno == E_ERROR || $errno == E_USER_ERROR) {
        die("An error occurred. Please contact support.");
    }
}

set_error_handler('customErrorHandler');
```

### Secure Logging

```php
// Log security events
function logSecurityEvent($event, $details = []) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'event' => $event,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'user_id' => $_SESSION['user_id'] ?? 'anonymous',
        'details' => $details
    ];
    
    error_log(json_encode($log_entry), 3, '/var/log/huisarts/security.log');
}

// Usage
logSecurityEvent('login_failed', ['username' => $username, 'reason' => 'invalid_password']);
logSecurityEvent('login_success', ['username' => $username]);
logSecurityEvent('unauthorized_access', ['url' => $_SERVER['REQUEST_URI']]);
```

## 🚫 Rate Limiting

Prevent brute force attacks:

```php
// Simple rate limiting for login
function checkRateLimit($identifier, $max_attempts = 5, $timeframe = 300) {
    $cache_file = sys_get_temp_dir() . '/rate_limit_' . md5($identifier);
    
    if (file_exists($cache_file)) {
        $data = json_decode(file_get_contents($cache_file), true);
        
        // Check if within timeframe
        if (time() - $data['first_attempt'] < $timeframe) {
            if ($data['attempts'] >= $max_attempts) {
                return false; // Rate limit exceeded
            }
            
            $data['attempts']++;
            file_put_contents($cache_file, json_encode($data));
        } else {
            // Reset counter
            file_put_contents($cache_file, json_encode([
                'attempts' => 1,
                'first_attempt' => time()
            ]));
        }
    } else {
        // First attempt
        file_put_contents($cache_file, json_encode([
            'attempts' => 1,
            'first_attempt' => time()
        ]));
    }
    
    return true;
}

// Usage
$identifier = $_SERVER['REMOTE_ADDR'];
if (!checkRateLimit($identifier)) {
    logSecurityEvent('rate_limit_exceeded', ['ip' => $identifier]);
    die('Too many attempts. Please try again later.');
}
```

## 🔄 Regular Security Maintenance

### Update Schedule

- **Weekly**: Check for security patches
- **Monthly**: Review logs for suspicious activity
- **Quarterly**: Security audit
- **Annually**: Penetration testing

### Security Checklist

```bash
# Update system packages
sudo apt update && sudo apt upgrade

# Update PHP
sudo apt install php8.1 # or latest version

# Check for rootkits
sudo rkhunter --check

# Check for malware
sudo clamscan -r /var/www/html/huisarts-project

# Review logs
sudo tail -f /var/log/huisarts/security.log
```

## 🆘 Security Incident Response

### If Compromised

1. **Immediate Actions**:
   - Take site offline
   - Change all passwords
   - Review logs
   - Identify breach point

2. **Investigation**:
   - Check file modifications
   - Review database for unauthorized changes
   - Analyze web server logs

3. **Recovery**:
   - Restore from clean backup
   - Apply security patches
   - Implement additional security measures

4. **Post-Incident**:
   - Document incident
   - Update security procedures
   - Notify affected parties if required

## 📚 Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
- [NIST Cybersecurity Framework](https://www.nist.gov/cyberframework)

---

**Security is ongoing**. Regularly review and update these guidelines.
