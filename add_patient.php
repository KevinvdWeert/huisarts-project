<?php
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();
$success_message = '';
$error_message = '';
$form_errors = [];

// Process form submission
if ($_POST) {
    // Validate required fields
    $required_fields = ['first_name', 'last_name'];
    foreach ($required_fields as $field) {
        if (empty(trim($_POST[$field]))) {
            $form_errors[$field] = 'Dit veld is verplicht';
        }
    }
    
    // Validate email format
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $form_errors['email'] = 'Voer een geldig emailadres in';
    }
    
    // Validate date of birth
    if (!empty($_POST['date_of_birth'])) {
        $dob = DateTime::createFromFormat('Y-m-d', $_POST['date_of_birth']);
        if (!$dob || $dob->format('Y-m-d') !== $_POST['date_of_birth']) {
            $form_errors['date_of_birth'] = 'Voer een geldige geboortedatum in';
        } elseif ($dob > new DateTime()) {
            $form_errors['date_of_birth'] = 'Geboortedatum kan niet in de toekomst liggen';
        }
    }
    
    // If no errors, insert patient
    if (empty($form_errors)) {
        try {
            $sql = "INSERT INTO patients (first_name, last_name, address, house_number, postcode, city, phone, email, date_of_birth, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            
            $params = [
                trim($_POST['first_name']),
                trim($_POST['last_name']),
                !empty($_POST['address']) ? trim($_POST['address']) : null,
                !empty($_POST['house_number']) ? trim($_POST['house_number']) : null,
                !empty($_POST['postcode']) ? trim($_POST['postcode']) : null,
                !empty($_POST['city']) ? trim($_POST['city']) : null,
                !empty($_POST['phone']) ? trim($_POST['phone']) : null,
                !empty($_POST['email']) ? trim($_POST['email']) : null,
                !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null
            ];
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            $success_message = "Patiënt succesvol toegevoegd!";
            
            // Clear form data after successful submission
            $_POST = [];
            
        } catch (PDOException $e) {
            error_log("Error adding patient: " . $e->getMessage());
            $error_message = "Er is een fout opgetreden bij het toevoegen van de patiënt.";
        }
    }
}

include 'includes/header.php';
?>

<div class="dashboard-header">
    <div class="header-content">
        <h1>Nieuwe Patiënt Toevoegen</h1>
        <div class="header-actions">
            <a href="dashboard.php" class="btn btn-secondary">← Terug naar overzicht</a>
            <a href="logout.php" class="btn btn-secondary btn-sm">Uitloggen</a>
        </div>
    </div>
</div>

<div class="form-container">
    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
            <a href="dashboard.php" class="btn btn-primary btn-sm" style="margin-left: 1rem;">Ga naar overzicht</a>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="patient-form" novalidate>
        <div class="form-section">
            <h3>Persoonlijke gegevens</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Voornaam *</label>
                    <input type="text" 
                           id="first_name" 
                           name="first_name" 
                           value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
                           class="<?php echo isset($form_errors['first_name']) ? 'error' : ''; ?>"
                           required>
                    <?php if (isset($form_errors['first_name'])): ?>
                        <span class="error-message"><?php echo $form_errors['first_name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Achternaam *</label>
                    <input type="text" 
                           id="last_name" 
                           name="last_name" 
                           value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
                           class="<?php echo isset($form_errors['last_name']) ? 'error' : ''; ?>"
                           required>
                    <?php if (isset($form_errors['last_name'])): ?>
                        <span class="error-message"><?php echo $form_errors['last_name']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="date_of_birth">Geboortedatum</label>
                <input type="date" 
                       id="date_of_birth" 
                       name="date_of_birth" 
                       value="<?php echo isset($_POST['date_of_birth']) ? htmlspecialchars($_POST['date_of_birth']) : ''; ?>"
                       class="<?php echo isset($form_errors['date_of_birth']) ? 'error' : ''; ?>">
                <?php if (isset($form_errors['date_of_birth'])): ?>
                    <span class="error-message"><?php echo $form_errors['date_of_birth']; ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Adresgegevens</h3>
            
            <div class="form-row">
                <div class="form-group flex-2">
                    <label for="address">Adres</label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>"
                           placeholder="Straatnaam">
                </div>
                
                <div class="form-group">
                    <label for="house_number">Huisnummer</label>
                    <input type="text" 
                           id="house_number" 
                           name="house_number" 
                           value="<?php echo isset($_POST['house_number']) ? htmlspecialchars($_POST['house_number']) : ''; ?>"
                           placeholder="123">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input type="text" 
                           id="postcode" 
                           name="postcode" 
                           value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode']) : ''; ?>"
                           placeholder="1234AB">
                </div>
                
                <div class="form-group flex-2">
                    <label for="city">Plaats</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>"
                           placeholder="Stad">
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Contactgegevens</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Telefoon</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                           placeholder="06-12345678">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           class="<?php echo isset($form_errors['email']) ? 'error' : ''; ?>"
                           placeholder="naam@example.com">
                    <?php if (isset($form_errors['email'])): ?>
                        <span class="error-message"><?php echo $form_errors['email']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Patiënt Opslaan</button>
            <a href="dashboard.php" class="btn btn-secondary">Annuleren</a>
        </div>
    </form>
</div>

<style>
.dashboard-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 1rem;
    margin: -20px -20px 20px -20px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 800px;
    margin: 0 auto;
}

.header-content h1 {
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
}

.patient-form {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section h3 {
    margin-top: 0;
    margin-bottom: 1.5rem;
    color: #495057;
    border-bottom: 2px solid #28a745;
    padding-bottom: 0.5rem;
}

.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group {
    flex: 1;
    margin-bottom: 1rem;
}

.form-group.flex-2 {
    flex: 2;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e1e1;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
    box-sizing: border-box;
}

.form-group input:focus {
    outline: none;
    border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

.form-group input.error {
    border-color: #dc3545;
}

.error-message {
    display: block;
    margin-top: 0.25rem;
    color: #dc3545;
    font-size: 0.875rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: all 0.3s;
    font-size: 1rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #1e7e34;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .patient-form {
        padding: 1rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?>