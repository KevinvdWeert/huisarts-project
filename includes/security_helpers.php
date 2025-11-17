<?php
/**
 * Security Helper Functions
 * CSRF protection, input validation, and security utilities
 */

/**
 * Generate CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token input field
 */
function csrfField() {
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

/**
 * Validate Dutch postal code
 */
function validateDutchPostalCode($postcode) {
    return preg_match('/^[1-9][0-9]{3}\s?[A-Z]{2}$/i', $postcode);
}

/**
 * Validate Dutch phone number
 */
function validateDutchPhone($phone) {
    // Remove spaces, dashes, and parentheses
    $cleaned = preg_replace('/[\s\-\(\)]/', '', $phone);
    // Check common Dutch formats
    return preg_match('/^(\+31|0031|0)[1-9][0-9]{8}$/', $cleaned);
}

/**
 * Sanitize input with proper method (replaces deprecated FILTER_SANITIZE_STRING)
 */
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
}
?>
