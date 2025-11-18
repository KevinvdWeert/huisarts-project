# Installation Guide

## Prerequisites

Before installing the Medical Practice Management System, ensure you have the following:

- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher / MariaDB 10.3+
- **Web Server**: Apache, Nginx, or Laragon
- **Composer**: For dependency management (optional)

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/KevinvdWeert/huisarts-project.git
cd huisarts-project
```

### 2. Database Setup

#### Option A: Using phpMyAdmin
1. Open phpMyAdmin
2. Create a new database named `huisarts`
3. Import the SQL file: `database/huisarts.sql`

#### Option B: Using MySQL Command Line
```bash
mysql -u root -p
CREATE DATABASE huisarts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE huisarts;
SOURCE database/huisarts.sql;
EXIT;
```

### 3. Configure Database Connection

Edit `config/config.php` with your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
define('DB_CHARSET', 'utf8mb4');
```

### 4. Configure Web Server

#### For Laragon
1. Place the project folder in `C:\laragon\www\`
2. Access via: `http://localhost/huisarts-project/`

#### For Apache
Add to your `httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    ServerName huisarts.local
    DocumentRoot "C:/path/to/huisarts-project"
    <Directory "C:/path/to/huisarts-project">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add to your hosts file (`C:\Windows\System32\drivers\etc\hosts`):
```
127.0.0.1  huisarts.local
```

#### For Nginx
```nginx
server {
    listen 80;
    server_name huisarts.local;
    root /path/to/huisarts-project;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 5. Set Permissions

Ensure proper permissions for uploads and cache directories:

```bash
# Linux/Mac
chmod -R 755 .
chmod -R 777 uploads/ cache/

# Windows (PowerShell as Admin)
icacls . /grant Everyone:(OI)(CI)F /T
```

### 6. Access the Application

Navigate to your configured URL:
- Local: `http://localhost/huisarts-project/`
- Custom domain: `http://huisarts.local/`

### 7. Default Login Credentials

**Admin Account:**
- Username: `admin`
- Password: `admin123`

**⚠️ Important:** Change the default password immediately after first login!

## Verification

After installation, verify the setup:

1. ✅ Homepage loads without errors
2. ✅ Login page is accessible
3. ✅ Can log in with default credentials
4. ✅ Dashboard displays correctly
5. ✅ Can add/edit/delete patients
6. ✅ SVG icons render properly (no crosses)

## Troubleshooting

### Database Connection Error
- Verify database credentials in `config/config.php`
- Ensure MySQL service is running
- Check database exists and is accessible

### 404 Errors
- Enable `mod_rewrite` for Apache
- Check `.htaccess` file exists
- Verify document root path

### Permission Errors
- Set appropriate file permissions
- Check web server user has access
- Verify PHP has write permissions for sessions

### SVG Icons Show as Crosses
- Run the SVG fix command (see [SVG Rendering Bug](SVG-Rendering-Bug))
- Clear browser cache

## Next Steps

- [Configuration](Configuration) - Configure application settings
- [Quick Start](Quick-Start) - Learn basic operations
- [Dashboard](Dashboard) - Understand the dashboard interface
