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

/**
 * Validate password strength
 * 
 * @param string $password Password to validate
 * @return array ['valid' => bool, 'errors' => array]
 */
function validatePasswordStrength($password) {
    $errors = [];
    
    // Minimum length
    if (strlen($password) < 12) {
        $errors[] = 'Password must be at least 12 characters long';
    }
    
    // Maximum length (prevent DoS)
    if (strlen($password) > 128) {
        $errors[] = 'Password must not exceed 128 characters';
    }
    
    // Must contain at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter';
    }
    
    // Must contain at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must contain at least one lowercase letter';
    }
    
    // Must contain at least one number
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number';
    }
    
    // Must contain at least one special character
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = 'Password must contain at least one special character (!@#$%^&*()_+-=[]{}|;:,.<>?)';
    }
    
    // Check against common passwords
    if (isCommonPassword($password)) {
        $errors[] = 'Password is too common. Please choose a more unique password';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Check if password is in common password list
 * 
 * @param string $password
 * @return bool
 */
function isCommonPassword($password) {
    $commonPasswords = [
        'password', 'password123', '12345678', 'qwerty123', 'abc123456',
        'password1', '12345678910', '1234567890', 'admin123', 'letmein',
        'welcome123', 'monkey123', 'dragon123', 'master123', 'sunshine',
        'princess', 'iloveyou', 'welcome', 'administrator'
    ];
    
    return in_array(strtolower($password), $commonPasswords);
}

/**
 * Generate a secure random password
 * 
 * @param int $length Password length
 * @return string
 */
function generateSecurePassword($length = 16) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    $password = '';
    $charsLength = strlen($chars);
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $charsLength - 1)];
    }
    
    // Ensure it meets complexity requirements
    if (!validatePasswordStrength($password)['valid']) {
        return generateSecurePassword($length);
    }
    
    return $password;
}

/**
 * Safely compare two strings in constant time
 * Prevents timing attacks
 * 
 * @param string $known Known string
 * @param string $user User-provided string
 * @return bool
 */
function timingSafeEquals($known, $user) {
    if (function_exists('hash_equals')) {
        return hash_equals($known, $user);
    }
    
    // Fallback implementation
    if (strlen($known) !== strlen($user)) {
        return false;
    }
    
    $result = 0;
    for ($i = 0; $i < strlen($known); $i++) {
        $result |= ord($known[$i]) ^ ord($user[$i]);
    }
    
    return $result === 0;
}

/**
 * Sanitize filename for safe file operations
 * 
 * @param string $filename
 * @return string
 */
function sanitizeFilename($filename) {
    // Remove path components
    $filename = basename($filename);
    
    // Remove special characters
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    
    // Prevent directory traversal
    $filename = str_replace(['..', './'], '', $filename);
    
    return $filename;
}
?>
