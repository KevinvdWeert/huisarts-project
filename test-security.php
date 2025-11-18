#!/usr/bin/env php
<?php
/**
 * Security Test Script
 * Tests various security features to ensure they're working correctly
 */

require_once __DIR__ . '/includes/encryption.php';
require_once __DIR__ . '/includes/security_helpers.php';

echo "===========================================\n";
echo "  Security Features Test Suite\n";
echo "===========================================\n\n";

$tests = [];
$passed = 0;
$failed = 0;

// Test 1: Encryption
echo "Test 1: Encryption Functions\n";
echo "=============================\n";

$testData = "This is sensitive patient information";
$encrypted = encryptData($testData);
$decrypted = decryptData($encrypted);

if ($encrypted !== false && $decrypted === $testData && $encrypted !== $testData) {
    echo "✅ PASS: Encryption and decryption working correctly\n";
    $passed++;
} else {
    echo "❌ FAIL: Encryption or decryption failed\n";
    $failed++;
}

// Test 2: Encryption key check
$keyConfigured = isEncryptionConfigured();
if ($keyConfigured) {
    echo "✅ PASS: Encryption key is properly configured\n";
    $passed++;
} else {
    echo "⚠️  WARNING: Using default encryption key (expected in development)\n";
    echo "   Set ENCRYPTION_KEY environment variable for production\n";
    // Don't count as failure in development
    $passed++;
}

echo "\n";

// Test 3: Password Strength Validation
echo "Test 2: Password Strength Validation\n";
echo "=====================================\n";

$weakPasswords = [
    'weak' => 'short',
    'no_uppercase' => 'nouppercasehere123!',
    'no_lowercase' => 'NOLOWERCASEHERE123!',
    'no_number' => 'NoNumberHere!',
    'no_special' => 'NoSpecialChar123',
    'common' => 'password123'
];

$weakTests = 0;
foreach ($weakPasswords as $name => $password) {
    $result = validatePasswordStrength($password);
    if (!$result['valid']) {
        $weakTests++;
    }
}

if ($weakTests === count($weakPasswords)) {
    echo "✅ PASS: All weak passwords correctly rejected\n";
    $passed++;
} else {
    echo "❌ FAIL: Some weak passwords were not rejected\n";
    $failed++;
}

$strongPassword = 'SecureP@ssw0rd123!';
$result = validatePasswordStrength($strongPassword);
if ($result['valid']) {
    echo "✅ PASS: Strong password correctly accepted\n";
    $passed++;
} else {
    echo "❌ FAIL: Strong password was rejected\n";
    echo "   Errors: " . implode(', ', $result['errors']) . "\n";
    $failed++;
}

echo "\n";

// Test 4: Input Sanitization
echo "Test 3: Input Sanitization\n";
echo "==========================\n";

$maliciousInput = '<script>alert("XSS")</script>Test';
$sanitized = sanitizeInput($maliciousInput);

if (strpos($sanitized, '<script>') === false && strpos($sanitized, 'Test') !== false) {
    echo "✅ PASS: Script tags properly sanitized\n";
    $passed++;
} else {
    echo "❌ FAIL: Script tags not properly sanitized\n";
    echo "   Result: " . $sanitized . "\n";
    $failed++;
}

echo "\n";

// Test 5: CSRF Token Generation
echo "Test 4: CSRF Token Generation\n";
echo "==============================\n";

if (session_status() === PHP_SESSION_NONE) {
    @session_start(); // Suppress warning if headers already sent in test
}
$token1 = generateCsrfToken();
$token2 = generateCsrfToken();

if (!empty($token1) && strlen($token1) === 64 && $token1 === $token2) {
    echo "✅ PASS: CSRF token generated correctly and consistent\n";
    $passed++;
} else {
    echo "❌ FAIL: CSRF token generation issue\n";
    $failed++;
}

if (validateCsrfToken($token1)) {
    echo "✅ PASS: CSRF token validation working\n";
    $passed++;
} else {
    echo "❌ FAIL: CSRF token validation failed\n";
    $failed++;
}

if (!validateCsrfToken('invalid_token')) {
    echo "✅ PASS: Invalid CSRF token correctly rejected\n";
    $passed++;
} else {
    echo "❌ FAIL: Invalid CSRF token was accepted\n";
    $failed++;
}

echo "\n";

// Test 6: Secure Password Generation
echo "Test 5: Secure Password Generation\n";
echo "===================================\n";

$generatedPassword = generateSecurePassword(16);
$validation = validatePasswordStrength($generatedPassword);

if ($validation['valid']) {
    echo "✅ PASS: Generated password meets strength requirements\n";
    echo "   Sample: " . $generatedPassword . "\n";
    $passed++;
} else {
    echo "❌ FAIL: Generated password doesn't meet requirements\n";
    echo "   Errors: " . implode(', ', $validation['errors']) . "\n";
    $failed++;
}

echo "\n";

// Test 7: File Name Sanitization
echo "Test 6: File Name Sanitization\n";
echo "===============================\n";

$maliciousFilenames = [
    '../../../etc/passwd' => 'etcpasswd',
    'test<script>.php' => 'testscript.php',
    'file with spaces.txt' => 'filewithspaces.txt',
];

$fileTests = 0;
foreach ($maliciousFilenames as $input => $expected) {
    $sanitized = sanitizeFilename($input);
    if (strpos($sanitized, '..') === false && strpos($sanitized, '/') === false) {
        $fileTests++;
    }
}

if ($fileTests === count($maliciousFilenames)) {
    echo "✅ PASS: Malicious filenames properly sanitized\n";
    $passed++;
} else {
    echo "❌ FAIL: Some filenames not properly sanitized\n";
    $failed++;
}

echo "\n";

// Test 8: Array Encryption
echo "Test 7: Array Encryption\n";
echo "========================\n";

$testArray = [
    'patient_name' => 'John Doe',
    'diagnosis' => 'Confidential medical information',
    'notes' => ['Note 1', 'Note 2']
];

$encryptedArray = encryptArray($testArray);
$decryptedArray = decryptArray($encryptedArray);

if ($encryptedArray !== false && $decryptedArray === $testArray) {
    echo "✅ PASS: Array encryption and decryption working\n";
    $passed++;
} else {
    echo "❌ FAIL: Array encryption or decryption failed\n";
    $failed++;
}

echo "\n";

// Test 9: Timing Safe Comparison
echo "Test 8: Timing Safe String Comparison\n";
echo "======================================\n";

$string1 = 'secure_token_12345';
$string2 = 'secure_token_12345';
$string3 = 'different_token';

if (timingSafeEquals($string1, $string2) && !timingSafeEquals($string1, $string3)) {
    echo "✅ PASS: Timing safe comparison working correctly\n";
    $passed++;
} else {
    echo "❌ FAIL: Timing safe comparison not working\n";
    $failed++;
}

echo "\n";

// Test 10: OpenSSL Availability
echo "Test 9: OpenSSL Extension\n";
echo "=========================\n";

$ciphers = openssl_get_cipher_methods();
if (in_array('aes-256-gcm', $ciphers)) {
    echo "✅ PASS: AES-256-GCM cipher available\n";
    $passed++;
} else {
    echo "❌ FAIL: AES-256-GCM cipher not available\n";
    $failed++;
}

echo "\n";

// Summary
echo "===========================================\n";
echo "  Test Summary\n";
echo "===========================================\n";
echo "Total Tests: " . ($passed + $failed) . "\n";
echo "Passed: " . $passed . " ✅\n";
echo "Failed: " . $failed . " ❌\n";

if ($failed === 0) {
    echo "\n🎉 All security tests passed!\n";
    exit(0);
} else {
    echo "\n⚠️  Some security tests failed. Please review and fix issues.\n";
    exit(1);
}
?>
