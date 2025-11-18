<?php
/**
 * Security Headers Configuration
 * Implements modern security headers to protect against common web vulnerabilities
 */

/**
 * Set all security headers
 */
function setSecurityHeaders() {
    // Only set headers if they haven't been sent yet
    if (headers_sent()) {
        return;
    }
    
    // Determine if we're on HTTPS
    $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    
    // HTTP Strict Transport Security (HSTS)
    // Forces browsers to use HTTPS for all requests
    if ($isHttps) {
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    }
    
    // Content Security Policy (CSP)
    // Prevents XSS attacks by controlling which resources can be loaded
    $csp = implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com",
        "style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data: https:",
        "connect-src 'self'",
        "frame-ancestors 'none'",
        "base-uri 'self'",
        "form-action 'self'"
    ]);
    header("Content-Security-Policy: " . $csp);
    
    // X-Frame-Options
    // Prevents clickjacking attacks
    header("X-Frame-Options: DENY");
    
    // X-Content-Type-Options
    // Prevents MIME type sniffing
    header("X-Content-Type-Options: nosniff");
    
    // X-XSS-Protection
    // Legacy XSS protection (for older browsers)
    header("X-XSS-Protection: 1; mode=block");
    
    // Referrer-Policy
    // Controls how much referrer information is sent
    header("Referrer-Policy: strict-origin-when-cross-origin");
    
    // Permissions-Policy (formerly Feature-Policy)
    // Controls which browser features can be used
    $permissions = implode(', ', [
        "geolocation=()",
        "microphone=()",
        "camera=()",
        "payment=()",
        "usb=()",
        "magnetometer=()",
        "gyroscope=()",
        "speaker=()"
    ]);
    header("Permissions-Policy: " . $permissions);
    
    // Remove server information
    header_remove("X-Powered-By");
    
    // Cache control for sensitive pages
    if (isAuthenticatedPage()) {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}

/**
 * Check if current page requires authentication
 * 
 * @return bool
 */
function isAuthenticatedPage() {
    $authenticatedPages = ['dashboard.php', 'add_patient.php', 'edit_patient.php', 'patient_notes.php', 'delete_patient.php'];
    $currentScript = basename($_SERVER['PHP_SELF']);
    return in_array($currentScript, $authenticatedPages);
}

/**
 * Force HTTPS redirect
 */
function enforceHttps() {
    $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    
    if (!$isHttps && php_sapi_name() !== 'cli') {
        // Only redirect if not already on HTTPS
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

/**
 * Check if request is from a modern browser
 * 
 * @return bool
 */
function isModernBrowser() {
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    // Check for modern browser versions
    $modernBrowsers = [
        'Chrome/([89]\d|[1-9]\d{2,})',  // Chrome 80+
        'Firefox/([7-9]\d|[1-9]\d{2,})', // Firefox 70+
        'Safari/([6-9]\d{2}|[1-9]\d{3,})', // Safari 600+
        'Edge/([8-9]\d|[1-9]\d{2,})',   // Edge 80+
    ];
    
    foreach ($modernBrowsers as $pattern) {
        if (preg_match('/' . $pattern . '/', $userAgent)) {
            return true;
        }
    }
    
    return false;
}

// Automatically set headers when file is included
setSecurityHeaders();
?>
