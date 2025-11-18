# Troubleshooting Guide

Solutions to common problems and issues with the Huisarts Project.

## 🔍 Quick Diagnosis

Before diving into specific issues, try these general steps:

1. **Check Error Logs**
   - Apache: `/var/log/apache2/error.log`
   - Nginx: `/var/log/nginx/error.log`
   - PHP: `/var/log/php/error.log`
   - Application: Check custom log location

2. **Enable Debug Mode** (temporarily)
   ```php
   // In config/config.php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   define('APP_DEBUG', true);
   ```

3. **Check PHP Info**
   ```php
   // Create phpinfo.php (remove after checking!)
   <?php phpinfo(); ?>
   ```

4. **Verify File Permissions**
   ```bash
   ls -la /var/www/html/huisarts-project
   ```

## 🗄️ Database Connection Issues

### Problem: "Database connection failed"

**Symptoms**:
- Cannot connect to database
- Error messages about connection
- Blank page or timeout

**Solutions**:

1. **Verify Database Credentials**
   ```php
   // Check config/config.php
   define('DB_HOST', 'localhost');    // Correct host?
   define('DB_NAME', 'huisarts');     // Database exists?
   define('DB_USER', 'username');     // Correct username?
   define('DB_PASS', 'password');     // Correct password?
   ```

2. **Check MySQL Service**
   ```bash
   # Check if MySQL is running
   sudo systemctl status mysql
   # or
   sudo systemctl status mariadb
   
   # Start if stopped
   sudo systemctl start mysql
   ```

3. **Verify Database Exists**
   ```bash
   mysql -u root -p
   SHOW DATABASES;
   ```
   
   If missing:
   ```sql
   CREATE DATABASE huisarts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Check User Permissions**
   ```sql
   SHOW GRANTS FOR 'huisarts_user'@'localhost';
   ```
   
   If insufficient:
   ```sql
   GRANT ALL PRIVILEGES ON huisarts.* TO 'huisarts_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

5. **Test Connection**
   ```php
   // test_db.php
   <?php
   try {
       $pdo = new PDO("mysql:host=localhost;dbname=huisarts", "username", "password");
       echo "Connection successful!";
   } catch(PDOException $e) {
       echo "Connection failed: " . $e->getMessage();
   }
   ?>
   ```

### Problem: "Access denied for user"

**Solutions**:
1. Reset user password:
   ```sql
   ALTER USER 'huisarts_user'@'localhost' IDENTIFIED BY 'new_password';
   FLUSH PRIVILEGES;
   ```

2. Verify host is correct (`localhost` vs `127.0.0.1`)

3. Check MySQL bind address:
   ```bash
   # In /etc/mysql/my.cnf or /etc/mysql/mysql.conf.d/mysqld.cnf
   bind-address = 127.0.0.1
   ```

## 🌐 Web Server Issues

### Problem: 404 Error on all pages

**Symptoms**:
- Homepage works but other pages show 404
- Pretty URLs not working

**Solutions**:

**For Apache**:

1. **Enable mod_rewrite**
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. **Check .htaccess exists**
   ```bash
   ls -la /var/www/html/huisarts-project/.htaccess
   ```

3. **Verify AllowOverride**
   ```apache
   # In /etc/apache2/sites-available/000-default.conf
   <Directory /var/www/html/huisarts-project>
       AllowOverride All
       Require all granted
   </Directory>
   ```

4. **Create/Fix .htaccess**
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /
       
       # Redirect to HTTPS (if applicable)
       # RewriteCond %{HTTPS} off
       # RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   </IfModule>
   ```

**For Nginx**:

Check location blocks in configuration:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### Problem: 403 Forbidden Error

**Symptoms**:
- Permission denied
- Cannot access files

**Solutions**:

1. **Fix File Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/huisarts-project
   sudo chmod -R 755 /var/www/html/huisarts-project
   sudo chmod -R 644 /var/www/html/huisarts-project/*.php
   ```

2. **Check Directory Index**
   ```apache
   # In .htaccess or httpd.conf
   DirectoryIndex index.php index.html
   ```

3. **Verify SELinux** (if applicable)
   ```bash
   # Check SELinux status
   sestatus
   
   # If enforcing, set correct context
   sudo chcon -R -t httpd_sys_content_t /var/www/html/huisarts-project
   ```

### Problem: 500 Internal Server Error

**Symptoms**:
- Server error page
- No specific error message

**Solutions**:

1. **Check Error Logs** (most important!)
   ```bash
   tail -f /var/log/apache2/error.log
   ```

2. **Common Causes**:
   - Syntax error in .htaccess
   - PHP syntax error
   - Memory limit exceeded
   - Missing PHP extensions

3. **Test .htaccess**
   ```bash
   # Temporarily rename .htaccess
   mv .htaccess .htaccess.bak
   # If site works, error is in .htaccess
   ```

4. **Check PHP Syntax**
   ```bash
   php -l /var/www/html/huisarts-project/index.php
   ```

5. **Increase PHP Limits**
   ```php
   // In php.ini or .htaccess
   php_value memory_limit 256M
   php_value max_execution_time 300
   ```

## 🔐 Session & Authentication Issues

### Problem: Session not working / Keeps logging out

**Symptoms**:
- Login appears successful but redirects to login
- Session data not persisting
- Frequent automatic logouts

**Solutions**:

1. **Check Session Save Path**
   ```bash
   # Find session save path
   php -i | grep session.save_path
   
   # Ensure it's writable
   sudo chmod 777 /var/lib/php/sessions
   # or
   sudo chown -R www-data:www-data /var/lib/php/sessions
   ```

2. **Verify Session Configuration**
   ```php
   // Check in php.ini or add to config.php
   ini_set('session.save_handler', 'files');
   ini_set('session.save_path', '/tmp');
   ini_set('session.gc_maxlifetime', 1440);
   ```

3. **Check Cookie Settings**
   ```php
   // Ensure session cookies work
   ini_set('session.use_cookies', 1);
   ini_set('session.use_only_cookies', 1);
   
   // If using HTTPS, ensure:
   ini_set('session.cookie_secure', 0); // 0 for HTTP, 1 for HTTPS
   ```

4. **Clear Browser Cookies**
   - Delete cookies for your domain
   - Try in incognito/private browsing mode

5. **Check for session_start() Calls**
   ```bash
   # Search for multiple session_start() calls
   grep -r "session_start()" /var/www/html/huisarts-project
   ```

### Problem: "Cannot modify header information"

**Symptoms**:
- Warning about headers already sent
- session_start() fails

**Cause**: Output before header() or session_start()

**Solutions**:

1. **Check for Output Before PHP**
   - No whitespace before `<?php`
   - No echo/print before headers
   - Check for BOM in files

2. **Use Output Buffering**
   ```php
   // At the very start of script
   ob_start();
   
   // At the end
   ob_end_flush();
   ```

3. **Check File Encoding**
   - Save files as UTF-8 without BOM

### Problem: Login fails with correct password

**Solutions**:

1. **Verify Password Hash**
   ```php
   // Test password verification
   <?php
   $stored_hash = '$2y$10$...'; // from database
   $password = 'password'; // user input
   
   if (password_verify($password, $stored_hash)) {
       echo "Password correct!";
   } else {
       echo "Password incorrect!";
   }
   ?>
   ```

2. **Regenerate Password Hash**
   ```php
   $new_hash = password_hash('newpassword', PASSWORD_DEFAULT);
   // Update in database
   ```

3. **Check for Whitespace**
   - Trim username/password input
   - Check for hidden characters

## 📄 PHP Issues

### Problem: Blank White Page

**Symptoms**:
- Completely blank page
- No error messages
- No HTML output

**Solutions**:

1. **Enable Error Display**
   ```php
   // Add to top of file
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

2. **Check PHP Error Log**
   ```bash
   tail -f /var/log/php/error.log
   ```

3. **Common Causes**:
   - Fatal PHP error
   - Memory limit exceeded
   - Missing required file
   - Syntax error

4. **Test PHP**
   ```php
   // Create test.php
   <?php
   echo "PHP is working!";
   phpinfo();
   ?>
   ```

### Problem: Missing PHP Extensions

**Symptoms**:
- "Call to undefined function" errors
- Features not working

**Solutions**:

1. **Check Installed Extensions**
   ```bash
   php -m
   ```

2. **Install Required Extensions**
   ```bash
   # Ubuntu/Debian
   sudo apt install php-mysqli php-pdo php-mbstring php-json
   
   # CentOS/RHEL
   sudo yum install php-mysqli php-pdo php-mbstring php-json
   
   # Restart web server
   sudo systemctl restart apache2
   ```

3. **Verify Extension in php.ini**
   ```ini
   extension=mysqli
   extension=pdo_mysql
   ```

### Problem: Maximum execution time exceeded

**Solutions**:

1. **Increase Limit**
   ```php
   // In php.ini
   max_execution_time = 300
   
   // Or in .htaccess
   php_value max_execution_time 300
   
   // Or in PHP code
   set_time_limit(300);
   ```

2. **Optimize Queries**
   - Add database indexes
   - Limit result sets
   - Use pagination

## 🎨 Display Issues

### Problem: Broken Layout / Missing Styles

**Symptoms**:
- Page displays but looks unstyled
- Missing images or CSS

**Solutions**:

1. **Check Browser Console** (F12)
   - Look for 404 errors on assets
   - Check for CORS errors

2. **Verify Asset Paths**
   ```php
   // In includes/header.php, check:
   <link href="/assets/css/style.css" rel="stylesheet">
   // Should match your actual path
   ```

3. **Check .htaccess Rewrite Rules**
   ```apache
   # Ensure assets aren't being rewritten
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   ```

4. **Clear Browser Cache**
   - Ctrl+F5 (hard refresh)
   - Clear browser cache completely

5. **Check File Permissions**
   ```bash
   sudo chmod -R 644 /var/www/html/huisarts-project/assets/
   sudo chmod -R 755 /var/www/html/huisarts-project/assets/
   ```

### Problem: Mobile View Not Working

**Solutions**:

1. **Check Viewport Meta Tag**
   ```html
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   ```

2. **Verify Responsive CSS**
   - Ensure Tailwind CSS is loading
   - Check media queries

3. **Test in Browser DevTools**
   - Toggle device toolbar (Ctrl+Shift+M)
   - Test different screen sizes

## 🔍 Search & Data Issues

### Problem: Search Returns No Results

**Solutions**:

1. **Check Search Query**
   ```php
   // Debug search query
   var_dump($_GET['search']);
   ```

2. **Verify Database Connection**
   - Test query directly in MySQL

3. **Check SQL Syntax**
   ```php
   // Enable query logging
   $stmt = $pdo->prepare($sql);
   echo $stmt->queryString;
   ```

4. **Test Simple Query**
   ```sql
   SELECT * FROM patients WHERE last_name LIKE '%test%';
   ```

### Problem: Data Not Saving

**Solutions**:

1. **Check Form Submission**
   ```php
   // Debug POST data
   var_dump($_POST);
   ```

2. **Verify CSRF Token** (if implemented)
   - Ensure token is present and valid

3. **Check Validation**
   - Review validation rules
   - Check for required fields

4. **Test Database Insert**
   ```php
   try {
       $stmt = $pdo->prepare("INSERT INTO patients (first_name, last_name) VALUES (?, ?)");
       $stmt->execute(['Test', 'Patient']);
       echo "Insert successful!";
   } catch (PDOException $e) {
       echo "Error: " . $e->getMessage();
   }
   ```

5. **Check Database Permissions**
   ```sql
   SHOW GRANTS FOR 'huisarts_user'@'localhost';
   ```

## 📱 Performance Issues

### Problem: Slow Page Loading

**Solutions**:

1. **Enable Caching**
   ```apache
   # In .htaccess
   <IfModule mod_expires.c>
       ExpiresActive On
       ExpiresByType text/css "access plus 1 year"
       ExpiresByType application/javascript "access plus 1 year"
       ExpiresByType image/jpeg "access plus 1 year"
       ExpiresByType image/png "access plus 1 year"
   </IfModule>
   ```

2. **Optimize Database**
   ```sql
   OPTIMIZE TABLE patients, notes, users;
   ANALYZE TABLE patients, notes, users;
   ```

3. **Add Indexes**
   ```sql
   -- Check for missing indexes
   SHOW INDEX FROM patients;
   
   -- Add index if needed
   CREATE INDEX idx_email ON patients(email);
   ```

4. **Enable OpCache**
   ```ini
   ; In php.ini
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.max_accelerated_files=4000
   ```

5. **Optimize Images**
   - Compress images
   - Use appropriate formats (WebP)
   - Implement lazy loading

### Problem: High Server Load

**Solutions**:

1. **Monitor Processes**
   ```bash
   top
   htop
   ```

2. **Check Slow Queries**
   ```sql
   -- Enable slow query log
   SET GLOBAL slow_query_log = 'ON';
   SET GLOBAL long_query_time = 2;
   
   -- Check slow queries
   SELECT * FROM mysql.slow_log;
   ```

3. **Implement Rate Limiting**
   - Prevent abuse
   - Limit requests per IP

4. **Optimize PHP**
   ```ini
   memory_limit = 256M
   max_execution_time = 30
   max_input_time = 60
   ```

## 🆘 Still Need Help?

If your issue isn't covered here:

1. **Check Error Logs** thoroughly
2. **Review [FAQ](FAQ)** for related questions
3. **Search [GitHub Issues](https://github.com/KevinvdWeert/huisarts-project/issues)**
4. **Create detailed bug report** with:
   - Exact error message
   - Steps to reproduce
   - System information
   - Relevant log entries
   - What you've tried

## 📚 Related Documentation

- [Installation Guide](Installation-Guide)
- [Configuration Guide](Configuration-Guide)
- [Security Guidelines](Security-Guidelines)
- [FAQ](FAQ)

---

**Remember**: Always backup before making major changes!
