<?php
//Security Helper Functions
//CSRF protection, input validation, and security utilities


function generateCsrfToken() {
    // Generate a CSRF token and store it in the session
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token) {
    // Check if the CSRF token from the session matches the provided token
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function csrfField() {
    // Generate a hidden input field with CSRF token
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

function validateDutchPostalCode($postcode) {
    // Dutch postal code format: 1234 AB
    return preg_match('/^[1-9][0-9]{3}\s?[A-Z]{2}$/i', $postcode);
}

function validateDutchPhone($phone) {
    // Remove spaces, dashes, and parentheses
    $cleaned = preg_replace('/[\s\-\(\)]/', '', $phone);
    return preg_match('/^(\+31|0031|0)[1-9][0-9]{8}$/', $cleaned);
}

function sanitizeInput($input) {
    // Remove HTML tags and encode special characters
    return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
}
?>
