# Quick Start Guide

Get up and running with the Huisarts Project in minutes!

## ⚡ Fast Track Installation

### 1. Download & Extract

```bash
git clone https://github.com/KevinvdWeert/huisarts-project.git
cd huisarts-project
```

Or download ZIP and extract to your web directory.

### 2. Create Database

```bash
mysql -u root -p
```

```sql
CREATE DATABASE huisarts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'huisarts_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON huisarts.* TO 'huisarts_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Import Database Schema

```bash
mysql -u huisarts_user -p huisarts < database/huisarts.sql
```

### 4. Configure Application

Edit `config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'huisarts');
define('DB_USER', 'huisarts_user');
define('DB_PASS', 'your_password');
define('APP_URL', 'http://localhost/huisarts-project');
```

### 5. Set Permissions (Linux/Mac)

```bash
sudo chown -R www-data:www-data /var/www/html/huisarts-project
sudo chmod -R 755 /var/www/html/huisarts-project
```

### 6. Access Application

Open browser and navigate to:
- `http://localhost/huisarts-project` (local development)
- `http://yourdomain.com` (production)

### 7. Login

**Default credentials**:
- Username: `admin`
- Password: `password`

⚠️ **Change password immediately!**

## 🎉 You're Done!

Now you can:
- Add patients
- Create medical notes
- Search and filter records
- Explore the dashboard

## 📚 Next Steps

1. **Read the [User Guide](User-Guide)** to learn all features
2. **Review [Security Guidelines](Security-Guidelines)** before production deployment
3. **Check [Configuration Guide](Configuration-Guide)** for advanced settings

## 🚨 Troubleshooting

### Can't connect to database?
- Check credentials in `config/config.php`
- Verify MySQL is running: `sudo systemctl status mysql`

### Blank page?
- Check PHP error logs
- Enable error display in `config/config.php`

### 404 errors?
- Enable mod_rewrite: `sudo a2enmod rewrite`
- Check .htaccess file exists

See [Troubleshooting Guide](Troubleshooting) for more help.

---

**Need detailed instructions?** Check the [Installation Guide](Installation-Guide).
