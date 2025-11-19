<?php
// Encryption and Decryption Functions for Patient Notes
function getEncryptionKey() {
    if (!defined('ENCRYPTION_KEY')) {
        throw new Exception("ENCRYPTION_KEY not defined in config");
    }
    return base64_decode(ENCRYPTION_KEY);
}

function encryptNote($plaintext) {
    // Return empty string if plaintext is empty
    if (empty($plaintext)) {
        return '';
    }
    
    $cipher = "aes-256-gcm";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $tag = '';
    
    $ciphertext = openssl_encrypt(
        $plaintext,
        $cipher,
        getEncryptionKey(),
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );
    
    if ($ciphertext === false) {
        error_log("Encryption failed: " . openssl_error_string());
        return false;
    }
    
    $encrypted = base64_encode($iv . $ciphertext . $tag);
    
    return $encrypted;
}

function decryptNote($encrypted) {
    // Return empty string if encrypted text is empty
    if (empty($encrypted)) {
        return '';
    }
    
    $cipher = "aes-256-gcm";
    $ivlen = openssl_cipher_iv_length($cipher);
    $taglen = 16;
    
    $data = base64_decode($encrypted);
    
    if ($data === false || strlen($data) < $ivlen + $taglen) {
        error_log("Decryption failed: Invalid data format");
        return false;
    }
    
    $iv = substr($data, 0, $ivlen);
    $tag = substr($data, -$taglen);
    $ciphertext = substr($data, $ivlen, -$taglen);
    
    $plaintext = openssl_decrypt(
        $ciphertext,
        $cipher,
        getEncryptionKey(),
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );
    
    if ($plaintext === false) {
        error_log("Decryption failed: " . openssl_error_string());
        return false;
    }
    
    return $plaintext;
}

function generateEncryptionKey() {
    // Generate a new random 32-byte key and return it base64 encoded
    $key = openssl_random_pseudo_bytes(32);
    return base64_encode($key);
}
?>
