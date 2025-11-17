<?php
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();
$patient = null;
$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$patient_id) {
    $_SESSION['error'] = "Geen geldige patiënt geselecteerd.";
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

// Process deletion
if ($_POST && isset($_POST['confirm_delete'])) {
    try {
        // Start transaction
        $pdo->beginTransaction();
        
        // First delete all notes associated with this patient
        $stmt = $pdo->prepare("DELETE FROM notes WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        
        // Then delete the patient
        $stmt = $pdo->prepare("DELETE FROM patients WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        
        // Commit transaction
        $pdo->commit();
        
        $_SESSION['success'] = "Patiënt '" . $patient['first_name'] . ' ' . $patient['last_name'] . "' is succesvol verwijderd.";
        header('Location: dashboard.php');
        exit;
        
    } catch (PDOException $e) {
        // Rollback transaction
        $pdo->rollBack();
        error_log("Error deleting patient: " . $e->getMessage());
        $error_message = "Er is een fout opgetreden bij het verwijderen van de patiënt.";
    }
}

// Check if patient has notes
$notes_count = 0;
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM notes WHERE patient_id = ?");
    $stmt->execute([$patient_id]);
    $notes_count = $stmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Error counting notes: " . $e->getMessage());
}

require_once 'includes/header.php';
?>

<div class="dashboard-header">
    <div class="header-content">
        <h1>Patiënt Verwijderen</h1>
        <div class="header-actions">
            <a href="dashboard.php" class="btn btn-secondary">← Terug naar overzicht</a>
            <a href="edit_patient.php?id=<?php echo $patient_id; ?>" class="btn btn-primary">✏️ Bewerken</a>
            <a href="logout.php" class="btn btn-secondary btn-sm">Uitloggen</a>
        </div>
    </div>
</div>

<div class="delete-container">
    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    
    <div class="delete-form">
        <div class="warning-section">
            <div class="warning-icon">⚠️</div>
            <h2>Patiënt definitief verwijderen?</h2>
            <p class="warning-text">
                U staat op het punt om de volgende patiënt permanent te verwijderen uit het systeem.
                <strong>Deze actie kan niet ongedaan worden gemaakt!</strong>
            </p>
        </div>
        
        <div class="patient-details">
            <h3>Patiëntgegevens</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Naam:</strong> 
                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                </div>
                
                <div class="detail-item">
                    <strong>Geboortedatum:</strong> 
                    <?php 
                    if ($patient['date_of_birth']) {
                        $dob = new DateTime($patient['date_of_birth']);
                        $today = new DateTime();
                        $age = $today->diff($dob)->y;
                        echo $dob->format('d-m-Y') . " ($age jaar)";
                    } else {
                        echo 'Niet opgegeven';
                    }
                    ?>
                </div>
                
                <?php if ($patient['email']): ?>
                <div class="detail-item">
                    <strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($patient['phone']): ?>
                <div class="detail-item">
                    <strong>Telefoon:</strong> <?php echo htmlspecialchars($patient['phone']); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($patient['address'] || $patient['city']): ?>
                <div class="detail-item">
                    <strong>Adres:</strong> 
                    <?php 
                    $address_parts = array_filter([
                        $patient['address'],
                        $patient['house_number'],
                        $patient['postcode'],
                        $patient['city']
                    ]);
                    echo htmlspecialchars(implode(', ', $address_parts));
                    ?>
                </div>
                <?php endif; ?>
                
                <div class="detail-item">
                    <strong>Geregistreerd op:</strong> 
                    <?php echo date('d-m-Y H:i', strtotime($patient['created_at'])); ?>
                </div>
                
                <div class="detail-item">
                    <strong>Laatst bijgewerkt:</strong> 
                    <?php echo date('d-m-Y H:i', strtotime($patient['updated_at'])); ?>
                </div>
            </div>
        </div>
        
        <?php if ($notes_count > 0): ?>
        <div class="notes-warning">
            <div class="warning-icon">📝</div>
            <div class="notes-info">
                <h4>Let op: Deze patiënt heeft <?php echo $notes_count; ?> notitie(s)</h4>
                <p>Alle notities worden ook permanent verwijderd bij het verwijderen van deze patiënt.</p>
                <a href="patient_notes.php?id=<?php echo $patient_id; ?>" class="btn btn-info btn-sm">
                    📝 Bekijk notities eerst
                </a>
            </div>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="confirmation-form">
            <div class="checkbox-container">
                <input type="checkbox" id="confirm_understanding" required>
                <label for="confirm_understanding">
                    Ik begrijp dat deze actie permanent is en niet ongedaan kan worden gemaakt
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" 
                        name="confirm_delete" 
                        value="1" 
                        class="btn btn-danger"
                        onclick="return confirm('Laatste waarschuwing: Weet u heel zeker dat u patiënt <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?> wilt verwijderen? Type JA om te bevestigen.') && prompt('Type JA (hoofdletters) om te bevestigen:') === 'JA'">
                    🗑️ Definitief Verwijderen
                </button>
                <a href="dashboard.php" class="btn btn-secondary">Annuleren</a>
                <a href="edit_patient.php?id=<?php echo $patient_id; ?>" class="btn btn-primary">
                    ✏️ Bewerken in plaats van verwijderen
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.dashboard-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content h1 {
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.delete-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
}

.delete-form {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.warning-section {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 2px solid #ffc107;
    padding: 2rem;
    text-align: center;
}

.warning-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.warning-section h2 {
    color: #856404;
    margin-bottom: 1rem;
}

.warning-text {
    color: #856404;
    font-size: 1.1rem;
    line-height: 1.5;
}

.patient-details {
    padding: 2rem;
    border-bottom: 1px solid #eee;
}

.patient-details h3 {
    margin-top: 0;
    margin-bottom: 1.5rem;
    color: #495057;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.detail-item {
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 4px;
    border-left: 4px solid #007bff;
}

.detail-item strong {
    color: #495057;
}

.notes-warning {
    background: #e7f3ff;
    border: 2px solid #007bff;
    padding: 1.5rem;
    margin: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.notes-warning .warning-icon {
    font-size: 2rem;
    margin: 0;
}

.notes-info h4 {
    color: #0056b3;
    margin: 0 0 0.5rem 0;
}

.notes-info p {
    color: #495057;
    margin-bottom: 1rem;
}

.confirmation-form {
    padding: 2rem;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: #fff5f5;
    border: 2px solid #fed7d7;
    border-radius: 8px;
}

.checkbox-container input[type="checkbox"] {
    width: 1.2rem;
    height: 1.2rem;
}

.checkbox-container label {
    color: #742a2a;
    font-weight: 500;
    cursor: pointer;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
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
    font-weight: 600;
}

.btn-danger:hover {
    background-color: #c82333;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1.5rem;
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
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .notes-warning {
        flex-direction: column;
        text-align: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .delete-form {
        margin: 0 0.5rem;
    }
    
    .warning-section,
    .patient-details,
    .confirmation-form {
        padding: 1rem;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>