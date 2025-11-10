<?php
// contact_handler.php - Contact form handler
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    // Validate required fields
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    if (empty($errors)) {
        // In a real application, you would send an email or save to database
        // For now, we'll just set a success message
        
        $_SESSION['form_success'] = "Thank you for your message! We will contact you within 24 hours.";
        
        // Optionally, you could save to database here
        /*
        try {
            include_once 'database/connection.php';
            
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $_SESSION['form_error'] = "A technical error occurred. Please try again later.";
        }
        */
        
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