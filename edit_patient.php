<?php
require_once 'config/config.php';
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();
$pdo = getDbConnection();
$success_message = '';
$error_message = '';
$form_errors = [];
$patient = null;

// Get patient ID from URL
$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$patient_id) {
    header('Location: dashboard.php');
    exit;
}

// Fetch patient data
try {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->execute([$patient_id]);
    $patient = $stmt->fetch();
    
    if (!$patient) {
        $_SESSION['error'] = "Patiënt niet gevonden.";
        header('Location: dashboard.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("Error fetching patient: " . $e->getMessage());
    $_SESSION['error'] = "Er is een fout opgetreden bij het ophalen van patiëntgegevens.";
    header('Location: dashboard.php');
    exit;
}

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
    
    // If no errors, update patient
    if (empty($form_errors)) {
        try {
            $sql = "UPDATE patients 
                    SET first_name = ?, last_name = ?, address = ?, house_number = ?, postcode = ?, 
                        city = ?, phone = ?, email = ?, date_of_birth = ?, updated_at = NOW()
                    WHERE patient_id = ?";
            
            $params = [
                trim($_POST['first_name']),
                trim($_POST['last_name']),
                !empty($_POST['address']) ? trim($_POST['address']) : null,
                !empty($_POST['house_number']) ? trim($_POST['house_number']) : null,
                !empty($_POST['postcode']) ? trim($_POST['postcode']) : null,
                !empty($_POST['city']) ? trim($_POST['city']) : null,
                !empty($_POST['phone']) ? trim($_POST['phone']) : null,
                !empty($_POST['email']) ? trim($_POST['email']) : null,
                !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null,
                $patient_id
            ];
            
            $stmt = $pdo->prepare($sql);
            $sth->bindParam('calories', $calories, PDO::PARAM_INT);
            /* Names can be prefixed with colons ":" too (optional) */
            $sth->bindParam(':colour', $colour, PDO::PARAM_STR);            
            $stmt->execute($params);
            
            $success_message = "Patiëntgegevens succesvol bijgewerkt!";
            
            // Refresh patient data
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
            $stmt->execute([$patient_id]);
            $patient = $stmt->fetch();
            
        } catch (PDOException $e) {
            error_log("Error updating patient: " . $e->getMessage());
            $error_message = "Er is een fout opgetreden bij het bijwerken van de patiëntgegevens.";
        }
    }
} else {
    // Pre-fill form with existing data
    $_POST = [
        'first_name' => $patient['first_name'],
        'last_name' => $patient['last_name'],
        'address' => $patient['address'],
        'house_number' => $patient['house_number'],
        'postcode' => $patient['postcode'],
        'city' => $patient['city'],
        'phone' => $patient['phone'],
        'email' => $patient['email'],
        'date_of_birth' => $patient['date_of_birth']
    ];
}

require_once 'includes/header.php';
?>

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-gray-200 fixed h-full overflow-y-auto">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Patiënt Bewerken</h2>
                <div class="bg-blue-50 px-3 py-2 rounded-lg text-sm font-medium text-blue-700">
                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                </div>
            </div>
            <div class="space-y-2">
                <a href="dashboard.php" class="flex items-center space-x-2 px-4 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium text-gray-700">Dashboard</span>
                </a>
                <a href="patient_notes.php?id=<?php echo $patient_id; ?>" class="flex items-center space-x-2 px-4 py-3 rounded-xl bg-green-50 hover:bg-green-100 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium text-green-600">Notities</span>
                </a>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 ml-72 p-8">
        <div class="max-w-4xl">
    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
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
                           value="<?php echo htmlspecialchars($_POST['first_name']); ?>"
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
                           value="<?php echo htmlspecialchars($_POST['last_name']); ?>"
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
                       value="<?php echo htmlspecialchars($_POST['date_of_birth']); ?>"
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
                           value="<?php echo htmlspecialchars($_POST['address']); ?>"
                           placeholder="Straatnaam">
                </div>
                
                <div class="form-group">
                    <label for="house_number">Huisnummer</label>
                    <input type="text" 
                           id="house_number" 
                           name="house_number" 
                           value="<?php echo htmlspecialchars($_POST['house_number']); ?>"
                           placeholder="123">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input type="text" 
                           id="postcode" 
                           name="postcode" 
                           value="<?php echo htmlspecialchars($_POST['postcode']); ?>"
                           placeholder="1234AB">
                </div>
                
                <div class="form-group flex-2">
                    <label for="city">Plaats</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="<?php echo htmlspecialchars($_POST['city']); ?>"
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
                           value="<?php echo htmlspecialchars($_POST['phone']); ?>"
                           placeholder="06-12345678">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?php echo htmlspecialchars($_POST['email']); ?>"
                           class="<?php echo isset($form_errors['email']) ? 'error' : ''; ?>"
                           placeholder="naam@example.com">
                    <?php if (isset($form_errors['email'])): ?>
                        <span class="error-message"><?php echo $form_errors['email']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Registratiegegevens</h3>
            <div class="info-row">
                <div class="info-item">
                    <strong>Toegevoegd op:</strong> 
                    <?php echo date('d-m-Y H:i', strtotime($patient['created_at'])); ?>
                </div>
                <div class="info-item">
                    <strong>Laatst bijgewerkt:</strong> 
                    <?php echo date('d-m-Y H:i', strtotime($patient['updated_at'])); ?>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
            <a href="dashboard.php" class="btn btn-secondary">Annuleren</a>
            <a href="delete_patient.php?id=<?php echo $patient_id; ?>" 
               class="btn btn-danger"
               onclick="return confirm('Weet u zeker dat u deze patiënt wilt verwijderen? Dit kan niet ongedaan worden gemaakt.')">
               🗑️ Verwijderen
            </a>
        </div>
    </form>
</div>
    </main>
</div>

<style>
body {
    background: #f9fafb;
    background: #f9fafb;
}

aside::-webkit-scrollbar {
    width: 6px;
}

aside::-webkit-scrollbar-track {
    background: #f1f1f1;
}

aside::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

aside::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

.form-container {
    max-width: 100%;
}

.patient-form {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
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
    color: #1f2937;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 0.5rem;
    font-size: 1.125rem;
    font-weight: 600;
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
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
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

.info-row {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.info-item {
    color: #6c757d;
    font-size: 0.9rem;
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
    background-color: #3b82f6;
    color: white;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
}

.btn-info:hover {
    background-color: #117a8b;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1.5rem;
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
        text-align: center;
    }
    
    .header-actions {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .form-row, .info-row {
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

<?php require_once 'includes/footer.php'; ?>