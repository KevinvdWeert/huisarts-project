# FAQ (Frequently Asked Questions)

Common questions and answers about the Huisarts Project.

## 📋 General Questions

### What is the Huisarts Project?

The Huisarts Project is a comprehensive medical practice management system built with PHP and MySQL. It helps healthcare professionals manage patient records, medical notes, and appointments efficiently through a modern, responsive web interface.

### Who is this system designed for?

- General practitioners (huisartsen)
- Medical practices and clinics
- Healthcare administrators
- Small to medium-sized medical facilities

### What are the main features?

- ✅ Patient record management (CRUD operations)
- ✅ Medical notes system with full history
- ✅ Secure user authentication with role-based access
- ✅ Advanced search and filtering
- ✅ Responsive design for all devices
- ✅ Dashboard with statistics
- ✅ Modern, user-friendly interface

### Is it free to use?

Yes, this is an open-source project available on GitHub. Check the license terms for specific usage rights.

## 🔧 Installation & Setup

### What are the system requirements?

**Minimum Requirements**:
- PHP 7.4 or higher
- MySQL 8.0+ or MariaDB 10.3+
- Apache 2.4+ or Nginx 1.18+
- 512MB RAM
- 1GB disk space

**Recommended**:
- PHP 8.1+
- MySQL 8.0+
- 1GB RAM
- 5GB disk space
- SSL certificate for HTTPS

### Can I install this on shared hosting?

Yes, if your shared hosting meets the requirements:
- PHP 7.4+ support
- MySQL database access
- Ability to modify .htaccess (for Apache)
- At least 512MB RAM allocated

Most modern shared hosting providers support these requirements.

### How do I install the Huisarts Project?

See the complete [Installation Guide](Installation-Guide) for step-by-step instructions.

Quick overview:
1. Clone or download the repository
2. Create MySQL database
3. Import database schema
4. Configure database credentials
5. Set file permissions
6. Access via browser

### Can I use this with Nginx instead of Apache?

Yes! The system works with both Apache and Nginx. See the [Installation Guide](Installation-Guide#for-nginx) for Nginx-specific configuration.

### Do I need to use XAMPP/WAMP/MAMP?

No, but these tools make local development easier for beginners. You can use:
- Native LAMP/LEMP stack
- Docker containers
- Any PHP-capable web server

## 🔐 Security & Authentication

### What are the default login credentials?

**Default accounts** (⚠️ Change immediately after installation!):

- **Admin**: username `admin`, password `password`
- **Doctor**: username `doctor`, password `password`

See [Security Guidelines](Security-Guidelines) for password change instructions.

### How secure is the system?

The system implements several security measures:
- Password hashing with bcrypt
- Prepared statements (SQL injection protection)
- Session security
- XSS protection
- CSRF token support (if implemented)
- Secure headers

However, security depends on:
- Proper configuration
- Using HTTPS
- Strong passwords
- Regular updates
- Following security best practices

### How do I enable HTTPS?

1. Obtain SSL certificate (Let's Encrypt is free)
2. Configure your web server for SSL
3. Update `config.php`:
   ```php
   define('APP_URL', 'https://yourdomain.com');
   ini_set('session.cookie_secure', 1);
   ```
4. Redirect HTTP to HTTPS in `.htaccess`

### Can I integrate two-factor authentication (2FA)?

2FA is not built-in but can be added. Consider:
- Google Authenticator integration
- SMS verification
- Email verification codes

Check the [Development Guide](Development-Guide) for custom feature implementation.

## 👥 User Management

### How do I create new user accounts?

Currently, new users must be created directly in the database:

```sql
-- Generate password hash first using PHP
-- <?php echo password_hash('newpassword', PASSWORD_DEFAULT); ?>

INSERT INTO users (username, password_hash, role) 
VALUES ('newdoctor', '$2y$10$...', 'doctor');
```

Or implement a user management interface (see [Development Guide](Development-Guide)).

### What user roles are available?

- **Admin**: Full access, user management
- **Doctor**: Patient and notes management

### Can I add custom user roles?

Yes, by modifying the database and authentication logic:
1. Add new role to users table
2. Update permission checks in PHP code
3. Implement role-specific features

### How do I reset a forgotten password?

**Option 1: Database Update**
```sql
-- Generate new hash: password_hash('newpassword', PASSWORD_DEFAULT)
UPDATE users 
SET password_hash = '$2y$10$...' 
WHERE username = 'username';
```

**Option 2: Implement Password Reset**
Create a password reset feature with email verification.

## 📊 Patient Management

### How many patients can the system handle?

The system includes sample data for 1000 patients and can handle significantly more (10,000+) depending on your server resources.

Database performance is optimized with indexes.

### Can I import existing patient data?

Yes! You can:

**Option 1: CSV Import**
```sql
LOAD DATA INFILE 'patients.csv'
INTO TABLE patients
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

**Option 2: SQL Insert**
Create INSERT statements from your existing data.

**Option 3: Custom Import Script**
Write a PHP script to process your data format.

### How do I export patient data?

**From Database**:
```bash
mysqldump -u username -p huisarts patients > patients_export.sql
```

**As CSV**:
```sql
SELECT * FROM patients
INTO OUTFILE '/tmp/patients.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';
```

**Via phpMyAdmin**: Export table in various formats.

### Can patients have multiple email addresses?

Not by default. The database has one email field per patient. To support multiple emails:
1. Create a new `patient_emails` table
2. Link with patient_id foreign key
3. Update forms and display logic

## 📝 Notes System

### What types of notes can I create?

The notes system is flexible and can handle:
- Consultation notes
- Treatment plans
- Test results
- Follow-up notes
- Administrative notes
- Any medical documentation

### Are notes time-stamped?

Yes, each note has:
- `created_at`: When the note was created
- `updated_at`: When the note was last modified
- `note_date`: The date of the consultation/event

### Can I attach files to notes?

Not in the current version. To add file attachments:
1. Create upload directory
2. Add file upload field
3. Store file path in database
4. Implement download/view functionality

### How do I print patient notes?

Use your browser's print function (Ctrl+P / Cmd+P). The system has print-friendly styles.

## 🔍 Searching & Filtering

### What can I search for?

The search function covers:
- Patient first name
- Patient last name
- Email address
- Phone number
- City
- Postal code

### Does search support partial matches?

Yes! Searching "John" will find:
- John Smith
- Johnny Doe
- Johnson

### Can I search notes content?

Not in the default interface, but you can add full-text search:

```sql
-- Add full-text index
ALTER TABLE notes ADD FULLTEXT(subject, text);

-- Search notes
SELECT * FROM notes 
WHERE MATCH(subject, text) AGAINST('search terms');
```

### How do I filter by date range?

This feature can be added. See [Development Guide](Development-Guide) for custom features.

## 🎨 Customization

### Can I change the look and feel?

Yes! The system uses Tailwind CSS. You can:
- Modify `assets/css/style.css`
- Change color schemes
- Update layouts
- Add custom styles

### Can I change the language?

Currently, the interface is primarily in English with some Dutch elements. To add full internationalization:
1. Create language files
2. Implement translation system
3. Update all text strings

### Can I add a logo?

Yes! Add your logo image to `assets/img/` and update the header:

```php
// In includes/header.php
<img src="assets/img/logo.png" alt="Practice Logo">
```

### Can I customize the dashboard?

Yes! Edit `dashboard.php` to:
- Add/remove widgets
- Change statistics
- Modify layout
- Add custom charts

## 🐛 Troubleshooting

### Database connection failed

**Check**:
1. Database credentials in `config/config.php`
2. MySQL service is running: `sudo systemctl status mysql`
3. Database exists: `mysql -u root -p -e "SHOW DATABASES;"`
4. User has proper permissions

See [Troubleshooting](Troubleshooting#database-connection-issues) for details.

### 404 errors on all pages

**Cause**: mod_rewrite not enabled (Apache) or routing issues.

**Fix**:
```bash
# Enable mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Check `.htaccess` is present and readable.

### Session not working / keeps logging out

**Check**:
1. Session save path is writable
2. PHP session configuration
3. Session timeout settings
4. Browser cookies enabled

### Blank white page

**Cause**: PHP error with display_errors off.

**Fix**: Check error logs:
```bash
tail -f /var/log/apache2/error.log
# or
tail -f /var/log/php/error.log
```

Enable errors temporarily:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Permission denied errors

**Fix file permissions**:
```bash
sudo chown -R www-data:www-data /var/www/html/huisarts-project
sudo chmod -R 755 /var/www/html/huisarts-project
```

## 📱 Mobile & Compatibility

### Is it mobile-friendly?

Yes! The interface is fully responsive and works on:
- Smartphones (iOS, Android)
- Tablets (iPad, Android tablets)
- Desktop computers
- Any modern web browser

### Which browsers are supported?

**Fully Supported**:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

**Limited Support**:
- Internet Explorer 11 (basic functionality only)

### Can I access it from my phone?

Yes! Simply navigate to your installation URL from any mobile browser. The interface automatically adapts to smaller screens.

## 🔄 Updates & Maintenance

### How do I update the system?

1. **Backup** everything first!
2. Pull latest changes: `git pull origin main`
3. Check for database migrations
4. Clear cache if applicable
5. Test thoroughly

### How often should I update?

- **Security updates**: Immediately
- **Feature updates**: As needed
- **PHP/MySQL**: Keep reasonably current

### How do I backup the system?

**Database**:
```bash
mysqldump -u username -p huisarts > backup_$(date +%Y%m%d).sql
```

**Files**:
```bash
tar -czf huisarts_backup_$(date +%Y%m%d).tar.gz /var/www/html/huisarts-project
```

Automate with cron jobs for regular backups.

### Where are error logs stored?

Check these locations:
- Apache: `/var/log/apache2/error.log`
- Nginx: `/var/log/nginx/error.log`
- PHP: `/var/log/php/error.log` or as configured
- Application: `logs/error.log` (if configured)

## 💻 Development

### Can I contribute to the project?

Yes! Contributions are welcome. See the [Development Guide](Development-Guide) for:
- Setting up development environment
- Code style guidelines
- Submitting pull requests

### Is there an API?

Not currently, but can be implemented. The database structure supports API development.

### Can I use this as a base for my own project?

Yes! The code is open source. Check the license for specific terms.

### How do I add new features?

See the [Development Guide](Development-Guide) for:
- Code structure
- Adding new pages
- Database modifications
- Best practices

## 🆘 Getting More Help

### Where can I get support?

1. Check this FAQ
2. Review [Troubleshooting](Troubleshooting) guide
3. Search [GitHub Issues](https://github.com/KevinvdWeert/huisarts-project/issues)
4. Create a new issue on GitHub
5. Consult documentation pages

### How do I report a bug?

1. Check if bug already reported
2. Create detailed issue on GitHub:
   - Description of problem
   - Steps to reproduce
   - Expected vs actual behavior
   - Error messages/logs
   - System information

### Where is the documentation?

All documentation is in this wiki:
- [Home](Home) - Overview
- [Installation Guide](Installation-Guide)
- [User Guide](User-Guide)
- [Configuration Guide](Configuration-Guide)
- [Security Guidelines](Security-Guidelines)
- [Database Schema](Database-Schema)
- [Development Guide](Development-Guide)

## 📚 Additional Questions?

If your question isn't answered here:

1. Check other documentation pages
2. Search [GitHub repository](https://github.com/KevinvdWeert/huisarts-project)
3. Create an issue for new questions

---

**Can't find what you need?** Contact support or create a GitHub issue!
