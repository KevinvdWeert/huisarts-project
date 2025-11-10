<?php
// contact_handler.php - Simple contact form handler
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
        $errors[] = "Naam is verplicht";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Geldig e-mailadres is verplicht";
    }
    
    if (empty($message)) {
        $errors[] = "Bericht is verplicht";
    }
    
    if (empty($errors)) {
        // In a real application, you would send an email or save to database
        // For now, we'll just set a success message
        
        $_SESSION['form_success'] = "Bedankt voor uw bericht! Wij nemen binnen 24 uur contact met u op.";
        
        // Optionally, you could save to database here
        /*
        try {
            include_once 'database/connection.php';
            
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $_SESSION['form_error'] = "Er is een technische fout opgetreden. Probeer het later opnieuw.";
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