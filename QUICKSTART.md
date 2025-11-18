# Security Quick Start Guide

This guide helps you quickly set up the security features of the Huisarts (Medical Practice) Management System.

## Prerequisites

- PHP 7.4 or higher
- MySQL/MariaDB 5.7 or higher
- OpenSSL extension enabled
- Apache or Nginx web server
- SSL certificate (Let's Encrypt recommended)

## Quick Setup (5 Minutes)

### 1. Run the Security Setup Wizard

```bash
cd /path/to/huisarts-project
php setup-security.php
```

Follow the interactive prompts to:
- Generate encryption key
- Configure database connection
- Set site URL and admin email
- Create `.env` file

### 2. Import Database Schema

If tables don't exist:

```bash
mysql -u root -p huisarts < database/huisarts.sql
```

### 3. Test Security Features

```bash
php test-security.php
```

All tests should pass ✅

### 4. Configure Web Server

**For Apache with HTTPS:**

```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /var/www/huisarts-project
    
    SSLEngine on
    SSLCertificateFile /path/to/cert.pem
    SSLCertificateKeyFile /path/to/key.pem
    
    <Directory /var/www/huisarts-project>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**For Nginx with HTTPS:**

```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /var/www/huisarts-project;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

### 5. Set File Permissions

```bash
# Secure .env file
chmod 600 .env

# Set appropriate permissions
find . -type f -name "*.php" -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Make web server owner
chown -R www-data:www-data /path/to/huisarts-project
```

### 6. Update PHP Configuration

Edit `php.ini` or create `.htaccess`:

```ini
# Production settings
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log

# Session security
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = Strict
session.gc_maxlifetime = 3600
```

## Verification Checklist

After setup, verify:

- [ ] ✅ Can access site via HTTPS
- [ ] ✅ HTTP redirects to HTTPS
- [ ] ✅ Can log in with demo accounts (admin/password or doctor/password)
- [ ] ✅ Session expires after 1 hour
- [ ] ✅ Rate limiting works (try 6+ failed logins)
- [ ] ✅ SSL rating A or higher at [SSL Labs](https://www.ssllabs.com/ssltest/)
- [ ] ✅ Security headers present at [Security Headers](https://securityheaders.com/)
- [ ] ✅ Audit logs recording events (check `audit_logs` table)
- [ ] ✅ No errors in PHP error log

## Test Security Features

### Test Rate Limiting

1. Try to log in with wrong password 6 times
2. Should be locked out for 15 minutes
3. Check `rate_limits` table to see the lock

```sql
SELECT * FROM rate_limits WHERE action = 'login';
```

### Test Audit Logging

1. Log in successfully
2. View a patient record
3. Log out
4. Check audit logs

```sql
SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 10;
```

### Test Encryption

```php
<?php
require_once 'includes/encryption.php';

$plaintext = "Sensitive patient data";
$encrypted = encryptData($plaintext);
$decrypted = decryptData($encrypted);

echo "Encrypted: " . $encrypted . "\n";
echo "Decrypted: " . $decrypted . "\n";
echo "Match: " . ($plaintext === $decrypted ? "YES" : "NO") . "\n";
?>
```

### Test Session Fingerprinting

1. Log in normally
2. Copy session cookie
3. Change User-Agent in browser
4. Try to access protected page with copied cookie
5. Should be logged out (fingerprint mismatch)

## Common Issues

### Issue: "Encryption key not configured"

**Solution:** Set ENCRYPTION_KEY in `.env` file or environment variable

```bash
export ENCRYPTION_KEY='your-generated-key-here'
```

### Issue: "Rate limiter table not found"

**Solution:** The table is created automatically, but you can create it manually:

```sql
CREATE TABLE rate_limits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifier VARCHAR(255) NOT NULL,
    action VARCHAR(100) NOT NULL,
    attempts INT DEFAULT 1,
    first_attempt DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_attempt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    locked_until DATETIME NULL,
    INDEX idx_identifier_action (identifier, action)
);
```

### Issue: "Session not working after enabling secure flag"

**Solution:** Ensure HTTPS is properly configured. If testing locally without HTTPS, set:

```php
// In config/config.php (development only!)
ini_set('session.cookie_secure', 0);
```

### Issue: "Headers already sent" error

**Solution:** Check for any output before `session_start()`. No whitespace or echo before PHP session start.

### Issue: "Cannot connect to database"

**Solution:** Verify credentials in `.env` and check MySQL is running:

```bash
mysql -u huisarts_app -p -e "USE huisarts; SHOW TABLES;"
```

## Security Best Practices

### DO ✅

- Use strong, unique encryption key (min 32 characters)
- Enable HTTPS in production (set `session.cookie_secure = 1`)
- Keep PHP and dependencies updated
- Monitor audit logs regularly
- Backup encryption key securely
- Use environment variables for secrets
- Set up automated backups
- Test backups regularly
- Review security headers
- Implement SSL certificate auto-renewal

### DON'T ❌

- Commit `.env` to version control
- Use default passwords in production
- Disable HTTPS in production
- Expose error messages to users
- Share encryption key in plain text
- Use short or weak passwords
- Ignore security warnings
- Skip security updates
- Use outdated PHP versions
- Store sensitive data unencrypted

## Next Steps

1. **Read [SECURITY.md](SECURITY.md)** for comprehensive configuration
2. **Set up monitoring** for audit logs and security events
3. **Configure backups** with encryption
4. **Review compliance** requirements (GDPR, HIPAA)
5. **Train staff** on security procedures
6. **Plan security audits** (quarterly recommended)
7. **Document procedures** for incident response

## Getting Help

### Documentation

- 📖 **Complete Guide**: [SECURITY.md](SECURITY.md)
- 📋 **README**: [README.md](README.md)
- 🔑 **Environment Template**: [.env.example](.env.example)

### Testing Tools

- 🛡️ SSL Configuration: https://www.ssllabs.com/ssltest/
- 🔒 Security Headers: https://securityheaders.com/
- 🔍 GDPR Compliance: https://gdpr.eu/checklist/

### Support

For security issues:
- **DO NOT** open public GitHub issues
- Email security team (see SECURITY.md)
- Include detailed description and steps to reproduce

For general questions:
- Open GitHub issue (non-security)
- Check existing documentation
- Review audit logs for clues

## Maintenance Schedule

### Daily
- Monitor audit logs for suspicious activity
- Check for failed login attempts
- Verify backups completed successfully

### Weekly
- Review rate limit violations
- Check disk space and logs
- Update staff on any security incidents

### Monthly
- Test backup restoration
- Review user access levels
- Check for software updates

### Quarterly
- Rotate encryption keys
- Conduct security audit
- Review and update security policies
- Test disaster recovery procedures

### Annually
- Full security assessment
- Update SSL certificates
- Review compliance requirements
- Staff security training

---

*Last Updated: November 2024*
*For detailed information, see [SECURITY.md](SECURITY.md)*
