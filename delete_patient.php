<?php
require_once 'config/config.php';
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();
$pdo = getDbConnection();
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

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-gray-200 fixed h-full overflow-y-auto">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-red-600 mb-2">Verwijderen</h2>
                <p class="text-sm text-gray-500">Deze actie kan niet ongedaan worden</p>
            </div>
            <div class="space-y-2">
                <a href="dashboard.php" class="flex items-center space-x-2 px-4 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium text-gray-700">Terug</span>
                </a>
                <a href="edit_patient.php?id=<?php echo $patient_id; ?>" class="flex items-center space-x-2 px-4 py-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="font-medium text-blue-600">Bewerken</span>
                </a>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 ml-72 p-8">
        <div class="max-w-4xl">
    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    
    <div class="delete-form">
        <div class="warning-section">
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
            <div class="notes-info">
                <h4>Let op: Deze patiënt heeft <?php echo $notes_count; ?> notitie(s)</h4>
                <p>Alle notities worden ook permanent verwijderd bij het verwijderen van deze patiënt.</p>
                <a href="patient_notes.php?id=<?php echo $patient_id; ?>" class="btn btn-info btn-sm">
                    Bekijk notities eerst
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
                        Definitief Verwijderen
                </button>
                <a href="dashboard.php" class="btn btn-secondary">Annuleren</a>
                <a href="edit_patient.php?id=<?php echo $patient_id; ?>" class="btn btn-primary">
                    Bewerken in plaats van verwijderen
                </a>
            </div>
        </form>
    </div>
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

.delete-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.warning-section {
    background-color: #fef3c7;
    border-bottom: 1px solid #fbbf24;
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
    background-color: #ef4444;
    color: white;
    font-weight: 600;
}

.btn-danger:hover {
    background-color: #dc2626;
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