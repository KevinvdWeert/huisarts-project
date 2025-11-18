<?php
/**
 * Central Initialization File
 * Handles all common setup for the application
 */

// Start with config
require_once __DIR__ . '/../config/config.php';

// Load security components
require_once __DIR__ . '/security_headers.php';
require_once __DIR__ . '/security_helpers.php';
require_once __DIR__ . '/encryption.php';
require_once __DIR__ . '/rate_limiter.php';
require_once __DIR__ . '/audit_logger.php';

// Load authentication
require_once __DIR__ . '/../auth.php';

// Get database connection function
require_once __DIR__ . '/../database/connection.php';

// Define page configuration
$pageConfig = [
    'title' => 'Medical Practice',
    'description' => 'Professional healthcare services for you and your family',
    'bodyClass' => 'bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen',
    'showHeader' => true,
    'showFooter' => true,
    'requireAuth' => false
];

// Helper function to set page config
function setPageConfig($config) {
    global $pageConfig;
    $pageConfig = array_merge($pageConfig, $config);
}

// Helper function to get page config
function getPageConfig($key = null) {
    global $pageConfig;
    return $key ? ($pageConfig[$key] ?? null) : $pageConfig;
}
?>
