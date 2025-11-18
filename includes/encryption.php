<?php
/**
 * Encryption Helper Functions
 * Provides AES-256-GCM encryption for sensitive data (PHI - Protected Health Information)
 * 
 * IMPORTANT: Store ENCRYPTION_KEY in environment variable or secure key management system
 * Never commit the actual encryption key to version control
 */

// Load encryption key from environment or config
// In production, use environment variables: $_ENV['ENCRYPTION_KEY']
if (!defined('ENCRYPTION_KEY')) {
    // For development only - replace with secure key management in production
    define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: 'CHANGE_THIS_TO_SECURE_KEY_32CHARS_MIN');
}

/**
 * Encrypt sensitive data using AES-256-GCM
 * 
 * @param string $data The data to encrypt
 * @return string|false Base64 encoded encrypted data with nonce and tag, or false on failure
 */
function encryptData($data) {
    if (empty($data)) {
        return $data;
    }
    
    try {
        $cipher = "aes-256-gcm";
        
        // Derive a proper encryption key
        $key = hash('sha256', ENCRYPTION_KEY, true);
        
        // Generate a random nonce (96 bits for GCM)
        $nonce = openssl_random_pseudo_bytes(12);
        
        // Encrypt the data
        $tag = '';
        $ciphertext = openssl_encrypt(
            $data,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag,
            '',
            16
        );
        
        if ($ciphertext === false) {
            error_log("Encryption failed: " . openssl_error_string());
            return false;
        }
        
        // Combine nonce + ciphertext + tag and encode
        $encrypted = $nonce . $ciphertext . $tag;
        return base64_encode($encrypted);
        
    } catch (Exception $e) {
        error_log("Encryption error: " . $e->getMessage());
        return false;
    }
}

/**
 * Decrypt data encrypted with encryptData()
 * 
 * @param string $encryptedData Base64 encoded encrypted data
 * @return string|false Decrypted data or false on failure
 */
function decryptData($encryptedData) {
    if (empty($encryptedData)) {
        return $encryptedData;
    }
    
    try {
        $cipher = "aes-256-gcm";
        
        // Derive the encryption key
        $key = hash('sha256', ENCRYPTION_KEY, true);
        
        // Decode the base64 data
        $decoded = base64_decode($encryptedData, true);
        if ($decoded === false) {
            error_log("Invalid base64 data for decryption");
            return false;
        }
        
        // Extract nonce (12 bytes), ciphertext, and tag (16 bytes)
        $nonceLength = 12;
        $tagLength = 16;
        
        if (strlen($decoded) < $nonceLength + $tagLength) {
            error_log("Invalid encrypted data format");
            return false;
        }
        
        $nonce = substr($decoded, 0, $nonceLength);
        $ciphertext = substr($decoded, $nonceLength, -$tagLength);
        $tag = substr($decoded, -$tagLength);
        
        // Decrypt the data
        $plaintext = openssl_decrypt(
            $ciphertext,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag
        );
        
        if ($plaintext === false) {
            error_log("Decryption failed: " . openssl_error_string());
            return false;
        }
        
        return $plaintext;
        
    } catch (Exception $e) {
        error_log("Decryption error: " . $e->getMessage());
        return false;
    }
}

/**
 * Encrypt an array of data (useful for JSON storage)
 * 
 * @param array $data Array to encrypt
 * @return string|false Encrypted JSON data or false on failure
 */
function encryptArray($data) {
    $json = json_encode($data);
    if ($json === false) {
        error_log("Failed to encode array to JSON");
        return false;
    }
    return encryptData($json);
}

/**
 * Decrypt array data encrypted with encryptArray()
 * 
 * @param string $encryptedData Encrypted JSON data
 * @return array|false Decrypted array or false on failure
 */
function decryptArray($encryptedData) {
    $json = decryptData($encryptedData);
    if ($json === false) {
        return false;
    }
    $data = json_decode($json, true);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        error_log("Failed to decode JSON: " . json_last_error_msg());
        return false;
    }
    return $data;
}

/**
 * Hash sensitive search fields for encrypted data lookup
 * Uses HMAC for deterministic but secure hashing
 * 
 * @param string $data Data to hash
 * @return string Hashed data
 */
function hashForSearch($data) {
    return hash_hmac('sha256', strtolower(trim($data)), ENCRYPTION_KEY);
}

/**
 * Generate a secure random encryption key
 * Use this to generate a new ENCRYPTION_KEY
 * 
 * @return string Random key suitable for AES-256
 */
function generateEncryptionKey() {
    return base64_encode(openssl_random_pseudo_bytes(32));
}

/**
 * Check if encryption is properly configured
 * 
 * @return bool True if encryption is available and configured
 */
function isEncryptionConfigured() {
    if (!function_exists('openssl_encrypt')) {
        error_log("OpenSSL extension not available");
        return false;
    }
    
    if (ENCRYPTION_KEY === 'CHANGE_THIS_TO_SECURE_KEY_32CHARS_MIN') {
        error_log("WARNING: Using default encryption key. Set ENCRYPTION_KEY environment variable!");
        return false;
    }
    
    if (strlen(ENCRYPTION_KEY) < 32) {
        error_log("WARNING: Encryption key is too short. Use at least 32 characters.");
        return false;
    }
    
    return true;
}
?>
