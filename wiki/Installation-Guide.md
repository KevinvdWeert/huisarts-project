# Installation Guide

This guide will walk you through installing and setting up the Huisarts Project on your system.

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

### Required Software

- **PHP** 7.4 or higher
  - Required extensions: `mysqli`, `pdo`, `pdo_mysql`, `session`, `json`
- **MySQL** 8.0+ or **MariaDB** 10.3+
- **Web Server**:
  - Apache 2.4+ (recommended) with `mod_rewrite` enabled
  - OR Nginx 1.18+
- **Composer** (optional, for dependency management)

### Development Environment Options

You can use any of these:
- **XAMPP** (Windows, macOS, Linux) - Recommended for beginners
- **WAMP** (Windows)
- **MAMP** (macOS, Windows)
- **Laragon** (Windows)
- **Docker** (All platforms)
- Native LAMP/LEMP stack

## 🚀 Installation Steps

### Step 1: Clone the Repository

```bash
# Using HTTPS
git clone https://github.com/KevinvdWeert/huisarts-project.git

# OR using SSH
git clone git@github.com:KevinvdWeert/huisarts-project.git

# Navigate to the project directory
cd huisarts-project
```

### Step 2: Configure Web Server

#### For Apache

1. **Copy files to web root**:
   ```bash
   # Linux/macOS
   sudo cp -r huisarts-project /var/www/html/

   # Windows (XAMPP)
   # Copy to C:\xampp\htdocs\huisarts-project
   ```

2. **Enable mod_rewrite** (if not already enabled):
   ```bash
   # Linux
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

3. **Configure virtual host** (optional but recommended):
   
   Create `/etc/apache2/sites-available/huisarts.conf`:
   ```apache
   <VirtualHost *:80>
       ServerName huisarts.local
       DocumentRoot /var/www/html/huisarts-project
       
       <Directory /var/www/html/huisarts-project>
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/huisarts_error.log
       CustomLog ${APACHE_LOG_DIR}/huisarts_access.log combined
   </VirtualHost>
   ```
   
   Enable the site:
   ```bash
   sudo a2ensite huisarts
   sudo systemctl reload apache2
   ```

#### For Nginx

Create `/etc/nginx/sites-available/huisarts`:

```nginx
server {
    listen 80;
    server_name huisarts.local;
    root /var/www/html/huisarts-project;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/huisarts /etc/nginx/sites-enabled/
sudo systemctl reload nginx
```

### Step 3: Create Database

1. **Access MySQL**:
   ```bash
   mysql -u root -p
   ```

2. **Create database**:
   ```sql
   CREATE DATABASE huisarts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Create database user** (recommended for security):
   ```sql
   CREATE USER 'huisarts_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON huisarts.* TO 'huisarts_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

4. **Import database schema**:
   ```bash
   mysql -u huisarts_user -p huisarts < database/huisarts.sql
   ```

### Step 4: Configure the Application

1. **Edit configuration file**:
   ```bash
   nano config/config.php
   # OR use your preferred text editor
   ```

2. **Update database credentials**:
   ```php
   <?php
   // Database Configuration
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'huisarts');
   define('DB_USER', 'huisarts_user');
   define('DB_PASS', 'your_secure_password');
   define('DB_CHARSET', 'utf8mb4');
   
   // Application Configuration
   define('APP_URL', 'http://huisarts.local'); // Change to your URL
   define('APP_NAME', 'Huisarts Practice');
   
   // Session Configuration
   ini_set('session.cookie_httponly', 1);
   ini_set('session.use_only_cookies', 1);
   ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
   ```

### Step 5: Set Permissions

Ensure proper file permissions:

```bash
# Linux/macOS
cd /var/www/html/huisarts-project

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Set file permissions
sudo find . -type f -exec chmod 644 {} \;

# Make config writable (if needed)
sudo chmod 666 config/config.php

# Set ownership to web server user
sudo chown -R www-data:www-data .
# OR for Apache on some systems:
# sudo chown -R apache:apache .
```

### Step 6: Verify Installation

1. **Access the application**:
   - Open your browser and navigate to:
     - `http://localhost/huisarts-project` (if using default setup)
     - `http://huisarts.local` (if using virtual host)

2. **Test login**:
   - **Username**: `admin`
   - **Password**: `password` (default - **change immediately!**)
   
   OR
   
   - **Username**: `doctor`
   - **Password**: `password`

3. **Verify functionality**:
   - ✅ Login works
   - ✅ Dashboard displays
   - ✅ Patient list loads
   - ✅ Search functionality works
   - ✅ Can add/edit patients

## 🔒 Post-Installation Security

**IMPORTANT**: After installation, complete these security steps:

1. **Change default passwords**:
   ```sql
   mysql -u root -p huisarts
   
   -- Update admin password
   UPDATE users 
   SET password_hash = PASSWORD('your_new_secure_password') 
   WHERE username = 'admin';
   ```
   
   Or use PHP to generate a proper hash:
   ```php
   <?php
   echo password_hash('your_new_secure_password', PASSWORD_DEFAULT);
   ?>
   ```

2. **Secure config file**:
   ```bash
   chmod 644 config/config.php
   ```

3. **Remove installation files** (if any):
   ```bash
   rm -f install.php setup.php
   ```

4. **Enable HTTPS** (strongly recommended for production):
   - Obtain SSL certificate (Let's Encrypt, commercial CA)
   - Configure SSL in your web server
   - Update `session.cookie_secure` to `1` in config

5. **Review security settings** in [Security Guidelines](Security-Guidelines)

## 🐳 Docker Installation (Alternative)

If you prefer using Docker:

1. **Create docker-compose.yml**:
   ```yaml
   version: '3.8'
   
   services:
     web:
       image: php:7.4-apache
       ports:
         - "8080:80"
       volumes:
         - ./:/var/www/html
       depends_on:
         - db
     
     db:
       image: mysql:8.0
       environment:
         MYSQL_ROOT_PASSWORD: root
         MYSQL_DATABASE: huisarts
         MYSQL_USER: huisarts_user
         MYSQL_PASSWORD: huisarts_pass
       volumes:
         - db_data:/var/lib/mysql
         - ./database/huisarts.sql:/docker-entrypoint-initdb.d/init.sql
   
   volumes:
     db_data:
   ```

2. **Start containers**:
   ```bash
   docker-compose up -d
   ```

3. **Access application**:
   - Open `http://localhost:8080`

## 🔧 Troubleshooting

If you encounter issues during installation, see the [Troubleshooting Guide](Troubleshooting).

Common issues:
- **Database connection failed**: Check credentials in `config/config.php`
- **403 Forbidden**: Check file permissions and Apache configuration
- **404 errors**: Ensure `mod_rewrite` is enabled for Apache
- **PHP errors**: Check PHP error logs and verify required extensions

## ✅ Next Steps

After successful installation:

1. Read the **[Configuration Guide](Configuration-Guide)** for advanced settings
2. Review the **[User Guide](User-Guide)** to learn how to use the system
3. Check **[Security Guidelines](Security-Guidelines)** for production deployment
4. Explore the **[Patient Management](Patient-Management)** features

---

**Need Help?** Check the [FAQ](FAQ) or [Troubleshooting](Troubleshooting) guides.
