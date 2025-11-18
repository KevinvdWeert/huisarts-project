# Security Configuration Guide

## Overview
This document provides comprehensive security configuration guidelines for the Huisarts (Medical Practice) Management System. The system now includes enhanced security features including encryption, audit logging, rate limiting, and security headers.

## Table of Contents
1. [Encryption Setup](#encryption-setup)
2. [HTTPS Configuration](#https-configuration)
3. [Session Security](#session-security)
4. [Rate Limiting](#rate-limiting)
5. [Audit Logging](#audit-logging)
6. [Password Policies](#password-policies)
7. [Security Headers](#security-headers)
8. [Database Security](#database-security)
9. [Backup and Recovery](#backup-and-recovery)
10. [Compliance Considerations](#compliance-considerations)

---

## 1. Encryption Setup

### Generating Encryption Key

The system uses AES-256-GCM encryption for sensitive patient data. You **must** generate a secure encryption key:

```bash
# Generate a secure random key
php -r "echo base64_encode(openssl_random_pseudo_bytes(32)) . PHP_EOL;"
```

### Setting the Encryption Key

**Option 1: Environment Variable (Recommended for Production)**

```bash
# Linux/Mac
export ENCRYPTION_KEY='your-generated-key-here'

# Windows
set ENCRYPTION_KEY=your-generated-key-here
```

**Option 2: Configuration File (Development Only)**

Edit `config/config.php` and add:

```php
define('ENCRYPTION_KEY', 'your-generated-key-here');
```

⚠️ **WARNING**: Never commit the encryption key to version control!

### Key Management Best Practices

1. **Store keys separately** from the application code
2. **Use a Key Management Service (KMS)** in production (AWS KMS, Azure Key Vault, etc.)
3. **Rotate keys periodically** (at least annually)
4. **Backup keys securely** in an encrypted vault
5. **Limit key access** to authorized personnel only

### Encrypting Existing Data

If you have existing unencrypted patient data, use the migration script:

```php
// Create: scripts/encrypt_existing_data.php
<?php
require_once '../config/config.php';
require_once '../database/connection.php';
require_once '../includes/encryption.php';

$pdo = getDbConnection();

// Encrypt sensitive fields in notes table
$stmt = $pdo->query("SELECT note_id, text FROM notes WHERE text IS NOT NULL");
while ($row = $stmt->fetch()) {
    $encrypted = encryptData($row['text']);
    if ($encrypted !== false) {
        $update = $pdo->prepare("UPDATE notes SET text = ? WHERE note_id = ?");
        $update->execute([$encrypted, $row['note_id']]);
    }
}

echo "Encryption complete\n";
?>
```

---

## 2. HTTPS Configuration

### Why HTTPS is Critical

- Protects data in transit
- Prevents man-in-the-middle attacks
- Required for GDPR and HIPAA compliance
- Improves SEO rankings

### Obtaining SSL Certificate

**Option 1: Let's Encrypt (Free)**

```bash
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
```

**Option 2: Commercial Certificate**
- Purchase from a trusted CA (DigiCert, Comodo, GlobalSign)
- Follow provider's installation instructions

### Apache Configuration

```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /var/www/huisarts-project
    
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/yourdomain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/yourdomain.com/privkey.pem
    
    # Strong SSL/TLS Configuration
    SSLProtocol -all +TLSv1.2 +TLSv1.3
    SSLCipherSuite HIGH:!aNULL:!MD5:!RC4
    SSLHonorCipherOrder on
    
    # HSTS Header (also set by PHP)
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
</VirtualHost>

# Redirect HTTP to HTTPS
<VirtualHost *:80>
    ServerName yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>
```

### Nginx Configuration

```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /var/www/huisarts-project;
    
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    
    # Strong SSL/TLS Configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5:!RC4;
    ssl_prefer_server_ciphers on;
    
    # HSTS Header
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}
```

### Testing SSL Configuration

Use [SSL Labs](https://www.ssllabs.com/ssltest/) to test your SSL configuration. Aim for an A+ rating.

---

## 3. Session Security

### Current Configuration

Sessions are configured with security best practices:

```php
// In config/config.php
ini_set('session.cookie_httponly', 1);  // Prevents JavaScript access
ini_set('session.use_only_cookies', 1);  // Only use cookies for sessions
ini_set('session.cookie_secure', 1);     // Only transmit over HTTPS (set to 0 for development)
ini_set('session.cookie_samesite', 'Strict');  // CSRF protection
ini_set('session.gc_maxlifetime', 3600);  // 1 hour session lifetime
```

### Production Recommendations

1. **Store sessions in database** (not filesystem):

```php
// Add to config/config.php for production
session_set_save_handler(
    'session_open',
    'session_close',
    'session_read',
    'session_write',
    'session_destroy',
    'session_gc'
);
```

2. **Use Redis for session storage** (high-performance option):

```bash
sudo apt-get install php-redis
```

```php
// config/config.php
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379');
```

### Session Monitoring

Sessions include fingerprinting to detect hijacking attempts. Monitor audit logs for:
- `event_type = 'access_denied'`
- `details` containing 'Session fingerprint mismatch'

---

## 4. Rate Limiting

### Default Configuration

The system implements rate limiting on:
- **Login attempts**: 5 attempts per 5 minutes, 15-minute lockout
- **API calls**: Configurable per endpoint

### Adjusting Rate Limits

Edit rate limiter calls in `auth.php`:

```php
// Adjust login rate limit
$rateCheck = $rateLimiter->checkLimit(
    $clientIp, 
    'login', 
    5,      // max attempts
    300,    // time window (seconds)
    900     // lockout duration (seconds)
);
```

### Monitoring Rate Limits

Check the `rate_limits` table for active limits:

```sql
SELECT identifier, action, attempts, locked_until 
FROM rate_limits 
WHERE locked_until > NOW();
```

### Whitelisting IP Addresses

For trusted IPs (e.g., administrative access), add to `rate_limiter.php`:

```php
private $whitelistedIps = [
    '192.168.1.100',  // Admin office
    '10.0.0.50',      // Internal network
];

public function checkLimit($identifier, $action, ...) {
    if (in_array($identifier, $this->whitelistedIps)) {
        return ['allowed' => true];
    }
    // ... rest of code
}
```

---

## 5. Audit Logging

### What is Logged

The system automatically logs:
- Authentication events (login, logout, failures)
- Patient data access (view, create, update, delete)
- Note access and modifications
- Security events (rate limits, access denied)

### Viewing Audit Logs

```php
$auditLogger = getAuditLogger($pdo);

// Get all login failures in the last 24 hours
$logs = $auditLogger->query([
    'event_type' => AuditLogger::EVENT_LOGIN_FAILURE,
    'start_date' => date('Y-m-d H:i:s', strtotime('-24 hours'))
]);

// Get all patient access by a specific user
$logs = $auditLogger->query([
    'user_id' => 1,
    'resource_type' => 'patient',
    'limit' => 100
]);
```

### Log Retention

By default, logs are retained for 365 days. Adjust retention:

```php
// Run periodically (daily cron job recommended)
$auditLogger = getAuditLogger($pdo);
$deleted = $auditLogger->cleanup(730); // Keep 2 years
```

### GDPR Compliance

Audit logs contain personal data. Ensure:
1. Logs are encrypted at rest
2. Access is restricted to authorized personnel
3. Logs are included in data deletion requests (right to be forgotten)
4. Log access is itself logged

---

## 6. Password Policies

### Current Requirements

Passwords must meet these criteria:
- Minimum 12 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special character
- Not in common password list

### Implementing Password Expiration

Add to `config/config.php`:

```php
define('PASSWORD_EXPIRY_DAYS', 90);
```

Add to `users` table:

```sql
ALTER TABLE users ADD COLUMN password_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP;
```

Check expiration in `auth.php`:

```php
function checkPasswordExpiry($user) {
    if (!defined('PASSWORD_EXPIRY_DAYS')) return true;
    
    $changedAt = strtotime($user['password_changed_at']);
    $expiryDate = $changedAt + (PASSWORD_EXPIRY_DAYS * 86400);
    
    if (time() > $expiryDate) {
        $_SESSION['password_expired'] = true;
        header('Location: change_password.php?expired=1');
        exit;
    }
}
```

### Password Reset Tokens

For secure password reset:

```php
function generatePasswordResetToken($userId, $email) {
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        INSERT INTO password_resets (user_id, email, token, expires_at)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$userId, $email, hash('sha256', $token), $expires]);
    
    return $token; // Send this in email
}
```

---

## 7. Security Headers

Security headers are automatically set by `includes/security_headers.php`.

### Testing Security Headers

Use [Security Headers](https://securityheaders.com/) to test your deployment.

### Current Headers

- **Strict-Transport-Security**: Forces HTTPS
- **Content-Security-Policy**: Prevents XSS
- **X-Frame-Options**: Prevents clickjacking
- **X-Content-Type-Options**: Prevents MIME sniffing
- **Referrer-Policy**: Controls referrer information
- **Permissions-Policy**: Controls browser features

### Customizing CSP

If you add external resources, update CSP in `security_headers.php`:

```php
$csp = implode('; ', [
    "default-src 'self'",
    "script-src 'self' https://trusted-cdn.com",
    "style-src 'self' https://trusted-cdn.com",
    // ... etc
]);
```

---

## 8. Database Security

### Connection Security

1. **Use SSL/TLS for database connections**:

```php
// In database/connection.php
$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_SSL_CA => '/path/to/ca-cert.pem',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true
    ]
);
```

2. **Use dedicated database user** with minimal permissions:

```sql
-- Create dedicated user
CREATE USER 'huisarts_app'@'localhost' IDENTIFIED BY 'strong-password';

-- Grant only necessary permissions
GRANT SELECT, INSERT, UPDATE, DELETE ON huisarts.patients TO 'huisarts_app'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON huisarts.notes TO 'huisarts_app'@'localhost';
GRANT SELECT ON huisarts.users TO 'huisarts_app'@'localhost';

-- No DROP, ALTER, or administrative privileges
FLUSH PRIVILEGES;
```

3. **Store database credentials securely**:

```bash
# Use environment variables
export DB_HOST='localhost'
export DB_NAME='huisarts'
export DB_USER='huisarts_app'
export DB_PASS='strong-password'
```

Update `config/config.php`:

```php
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'huisarts');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
```

### Database Encryption

Enable MySQL encryption at rest:

```ini
# my.cnf
[mysqld]
innodb_encrypt_tables = ON
innodb_encrypt_log = ON
innodb_encryption_threads = 4
```

### Regular Security Audits

```sql
-- Check for users with excessive privileges
SELECT user, host, Select_priv, Insert_priv, Update_priv, Delete_priv 
FROM mysql.user 
WHERE Drop_priv = 'Y' OR Grant_priv = 'Y';

-- Check for users without passwords
SELECT user, host FROM mysql.user WHERE authentication_string = '';
```

---

## 9. Backup and Recovery

### Automated Backups

Create daily backup script:

```bash
#!/bin/bash
# /usr/local/bin/backup-huisarts.sh

BACKUP_DIR="/var/backups/huisarts"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="huisarts"

# Database backup (encrypted)
mysqldump --single-transaction $DB_NAME | \
    gzip | \
    openssl enc -aes-256-cbc -salt -pbkdf2 \
    -out "$BACKUP_DIR/db_${DATE}.sql.gz.enc"

# File backup
tar czf "$BACKUP_DIR/files_${DATE}.tar.gz" /var/www/huisarts-project

# Keep only last 30 days
find $BACKUP_DIR -type f -mtime +30 -delete

# Upload to secure offsite storage
aws s3 cp $BACKUP_DIR/ s3://your-backup-bucket/huisarts/ --recursive
```

Schedule with cron:

```bash
# Run daily at 2 AM
0 2 * * * /usr/local/bin/backup-huisarts.sh
```

### Restore Procedure

```bash
# Decrypt and restore database
openssl enc -aes-256-cbc -d -pbkdf2 \
    -in db_20240101_020000.sql.gz.enc | \
    gunzip | \
    mysql huisarts

# Restore files
tar xzf files_20240101_020000.tar.gz -C /
```

### Testing Backups

Regularly test backup restoration in a separate environment.

---

## 10. Compliance Considerations

### GDPR (General Data Protection Regulation)

The system includes features for GDPR compliance:

1. **Data Encryption**: Patient data is encrypted at rest
2. **Audit Logging**: All access to personal data is logged
3. **Data Portability**: Export patient data in structured format
4. **Right to be Forgotten**: Delete patient data completely

Implement data export:

```php
function exportPatientData($patientId) {
    $pdo = getDbConnection();
    
    // Get patient data
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->execute([$patientId]);
    $patient = $stmt->fetch();
    
    // Get notes
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE patient_id = ?");
    $stmt->execute([$patientId]);
    $notes = $stmt->fetchAll();
    
    // Decrypt sensitive data before export
    foreach ($notes as &$note) {
        if (!empty($note['text'])) {
            $note['text'] = decryptData($note['text']);
        }
    }
    
    return json_encode([
        'patient' => $patient,
        'notes' => $notes,
        'exported_at' => date('c')
    ], JSON_PRETTY_PRINT);
}
```

### HIPAA (Health Insurance Portability and Accountability Act)

For US healthcare providers:

1. **Access Controls**: Implemented via authentication
2. **Audit Controls**: Comprehensive audit logging
3. **Encryption**: Data encrypted in transit (HTTPS) and at rest
4. **Automatic Logoff**: Session timeout implemented
5. **Unique User IDs**: Each user has unique login

Additional requirements:
- Signed Business Associate Agreements (BAAs)
- Regular security risk assessments
- Employee training programs
- Disaster recovery plan

### NEN 7510 (Dutch Healthcare Standard)

For Netherlands healthcare providers:

1. **Authentication**: Strong password policies
2. **Authorization**: Role-based access control
3. **Logging**: Comprehensive audit trail
4. **Encryption**: TLS and data encryption
5. **Availability**: Backup and recovery procedures

---

## Security Checklist

### Pre-Production

- [ ] Generate and securely store encryption key
- [ ] Configure HTTPS with valid certificate
- [ ] Set `session.cookie_secure` to `1`
- [ ] Change default database credentials
- [ ] Restrict database user permissions
- [ ] Set up automated backups
- [ ] Configure firewall rules
- [ ] Update all dependencies
- [ ] Remove development files (.git, README with sensitive info)
- [ ] Set `error_reporting` to `0` in production
- [ ] Configure error logging to secure location

### Post-Production

- [ ] Monitor audit logs regularly
- [ ] Review rate limit violations
- [ ] Test backup restoration monthly
- [ ] Update SSL certificates before expiry
- [ ] Rotate encryption keys annually
- [ ] Review and update user access quarterly
- [ ] Conduct security audits annually
- [ ] Keep software updated (PHP, MySQL, dependencies)

### Monitoring

Set up monitoring for:
- Failed login attempts (threshold: 5 in 5 minutes)
- Session hijacking attempts (fingerprint mismatches)
- Database errors
- Backup failures
- Certificate expiration
- Disk space usage

---

## Support and Questions

For security issues or questions:
- Review audit logs first
- Check error logs: `/var/log/apache2/error.log` or `/var/log/nginx/error.log`
- Test configuration: [SSL Labs](https://www.ssllabs.com/ssltest/), [Security Headers](https://securityheaders.com/)

### Reporting Security Vulnerabilities

If you discover a security vulnerability:
1. Do NOT open a public issue
2. Email the security team privately
3. Include detailed description and reproduction steps
4. Allow reasonable time for fix before disclosure

---

*Last Updated: November 2024*
*Version: 1.0*
