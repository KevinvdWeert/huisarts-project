<?php
// contact_handler.php - Contact form handler
require_once 'config/config.php';
require_once 'includes/security_helpers.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
        $_SESSION['form_errors'] = ['Invalid security token. Please try again.'];
        $_SESSION['form_data'] = $_POST;
        header('Location: contact.php');
        exit;
    }
    
    // Sanitize input data using new method
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    
    // Validate required fields
    $errors = [];
    
    if (empty($name) || strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters";
    }
    
    if (strlen($name) > 100) {
        $errors[] = "Name must be less than 100 characters";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required";
    }
    
    if (!empty($phone) && !validateDutchPhone($phone)) {
        $errors[] = "Please enter a valid Dutch phone number";
    }
    
    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Message must be at least 10 characters";
    }
    
    if (strlen($message) > 5000) {
        $errors[] = "Message must be less than 5000 characters";
    }
    
    if (empty($errors)) {
        // In a real application, you would send an email or save to database
        // For now, we'll just set a success message
        
        $_SESSION['form_success'] = "Thank you for your message! We will contact you within 24 hours.";
        
        // Redirect back to contact page
        header('Location: contact.php');
        exit;
        
    } else {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: contact.php');
        exit;
    }
} else {
    // If not POST request, redirect to contact page
    header('Location: contact.php');
    exit;
}
?>