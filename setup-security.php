#!/usr/bin/env php
<?php
/**
 * Security Setup Wizard
 * Interactive script to help configure security settings
 */

echo "===========================================\n";
echo "  Medical Practice Security Setup Wizard\n";
echo "===========================================\n\n";

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    echo "❌ ERROR: PHP 7.4 or higher is required. Current version: " . PHP_VERSION . "\n";
    exit(1);
}

// Check OpenSSL
if (!extension_loaded('openssl')) {
    echo "❌ ERROR: OpenSSL extension is required but not loaded.\n";
    exit(1);
}

echo "✅ PHP version: " . PHP_VERSION . "\n";
echo "✅ OpenSSL extension: loaded\n\n";

// Step 1: Generate encryption key
echo "Step 1: Encryption Key Generation\n";
echo "==================================\n";
echo "Generating a secure encryption key...\n";

$encryptionKey = base64_encode(openssl_random_pseudo_bytes(32));
echo "✅ Generated encryption key: " . substr($encryptionKey, 0, 20) . "...\n\n";

// Step 2: Database credentials
echo "Step 2: Database Configuration\n";
echo "==============================\n";

echo "Enter database host [localhost]: ";
$dbHost = trim(fgets(STDIN));
$dbHost = $dbHost ?: 'localhost';

echo "Enter database name [huisarts]: ";
$dbName = trim(fgets(STDIN));
$dbName = $dbName ?: 'huisarts';

echo "Enter database username [huisarts_app]: ";
$dbUser = trim(fgets(STDIN));
$dbUser = $dbUser ?: 'huisarts_app';

echo "Enter database password: ";
$dbPass = trim(fgets(STDIN));

echo "\n";

// Step 3: Site configuration
echo "Step 3: Site Configuration\n";
echo "==========================\n";

echo "Enter site URL (e.g., https://yourdomain.com): ";
$siteUrl = trim(fgets(STDIN));

echo "Enter admin email: ";
$adminEmail = trim(fgets(STDIN));

echo "\n";

// Step 4: Create .env file
echo "Step 4: Creating .env File\n";
echo "===========================\n";

$envContent = <<<ENV
# Environment Configuration
# Generated on {date}

# Database Configuration
DB_HOST={$dbHost}
DB_NAME={$dbName}
DB_USER={$dbUser}
DB_PASS={$dbPass}

# Security Configuration
ENCRYPTION_KEY={$encryptionKey}

# Site Configuration
SITE_URL={$siteUrl}
ADMIN_EMAIL={$adminEmail}

# Session Configuration (seconds)
SESSION_LIFETIME=3600

# Environment
APP_ENV=production

# Error Reporting (0 for production, 1 for development)
DISPLAY_ERRORS=0

# HTTPS Enforcement
FORCE_HTTPS=1
ENV;

$envContent = str_replace('{date}', date('Y-m-d H:i:s'), $envContent);

$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    echo "⚠️  WARNING: .env file already exists.\n";
    echo "Overwrite existing .env file? (yes/no): ";
    $confirm = trim(fgets(STDIN));
    
    if (strtolower($confirm) !== 'yes') {
        echo "❌ Setup cancelled. Existing .env file preserved.\n";
        exit(0);
    }
    
    // Backup existing file
    $backupFile = $envFile . '.backup.' . date('YmdHis');
    copy($envFile, $backupFile);
    echo "✅ Backed up existing .env to: " . basename($backupFile) . "\n";
}

file_put_contents($envFile, $envContent);
chmod($envFile, 0600); // Restrict permissions

echo "✅ Created .env file with secure permissions (600)\n\n";

// Step 5: Test database connection
echo "Step 5: Testing Database Connection\n";
echo "====================================\n";

try {
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "✅ Database connection successful\n\n";
    
    // Check if tables exist
    $tables = ['users', 'patients', 'notes'];
    $missingTables = [];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '{$table}'");
        if ($stmt->rowCount() === 0) {
            $missingTables[] = $table;
        }
    }
    
    if (!empty($missingTables)) {
        echo "⚠️  WARNING: Missing database tables: " . implode(', ', $missingTables) . "\n";
        echo "You need to import the database schema from database/huisarts.sql\n\n";
    } else {
        echo "✅ All required database tables exist\n\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check your database credentials and try again.\n\n";
}

// Step 6: Security recommendations
echo "Step 6: Security Recommendations\n";
echo "=================================\n\n";

echo "📋 Next Steps:\n\n";

$httpsConfigured = strpos($siteUrl, 'https://') === 0;

if (!$httpsConfigured) {
    echo "❌ 1. Configure HTTPS with SSL/TLS certificate\n";
    echo "   - Use Let's Encrypt (free): sudo certbot --apache\n";
    echo "   - Or obtain a commercial certificate\n\n";
} else {
    echo "✅ 1. HTTPS configured in site URL\n";
    echo "   - Verify SSL certificate is installed and valid\n";
    echo "   - Test at: https://www.ssllabs.com/ssltest/\n\n";
}

echo "⚠️  2. Update PHP session settings for production:\n";
echo "   - Edit php.ini or .htaccess\n";
echo "   - Set: session.cookie_secure = 1 (requires HTTPS)\n\n";

echo "⚠️  3. Secure file permissions:\n";
echo "   - chmod 600 .env\n";
echo "   - chmod 644 *.php\n";
echo "   - chmod 755 directories\n\n";

echo "⚠️  4. Review and configure firewall:\n";
echo "   - Allow ports: 80 (HTTP), 443 (HTTPS), 22 (SSH)\n";
echo "   - Deny all other incoming traffic\n\n";

echo "⚠️  5. Set up automated backups:\n";
echo "   - Database: mysqldump with encryption\n";
echo "   - Files: regular tar backups\n";
echo "   - Store backups off-site\n\n";

echo "⚠️  6. Configure error logging:\n";
echo "   - Review error_log location in php.ini\n";
echo "   - Set display_errors = 0 in production\n";
echo "   - Monitor logs regularly\n\n";

echo "⚠️  7. Test security configuration:\n";
echo "   - SSL/TLS: https://www.ssllabs.com/ssltest/\n";
echo "   - Headers: https://securityheaders.com/\n";
echo "   - Try multiple failed logins to test rate limiting\n\n";

echo "📖 For detailed configuration, see SECURITY.md\n\n";

// Step 7: Summary
echo "Setup Summary\n";
echo "=============\n";
echo "✅ Encryption key generated and saved\n";
echo "✅ Database configuration saved\n";
echo "✅ .env file created with secure permissions\n";
echo "✅ Database connection tested\n\n";

echo "⚠️  IMPORTANT REMINDERS:\n";
echo "1. Never commit .env file to version control\n";
echo "2. Store encryption key backup in secure location\n";
echo "3. Review SECURITY.md for complete setup guide\n";
echo "4. Test all security features before production deployment\n";
echo "5. Set up monitoring for audit logs and security events\n\n";

echo "Setup complete! 🎉\n\n";
?>
