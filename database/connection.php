<?php
// Include configuration
require_once __DIR__ . '/../config/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", 
        DB_USER, 
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
} catch (PDOException $e) {
    // Log error instead of displaying it
    error_log("Database Connection Error: " . $e->getMessage());
    
    // Display generic error message to user
    die("Er is een technische fout opgetreden. Probeer het later opnieuw.");
}
?>