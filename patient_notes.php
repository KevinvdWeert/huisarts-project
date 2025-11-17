<?php
require_once 'config/config.php';
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();
$pdo = getDbConnection();
$patient = null;
$notes = [];
$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$success_message = '';
$error_message = '';

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

// Process new note submission
if ($_POST && isset($_POST['add_note'])) {
    $subject = trim($_POST['subject']);
    $note_date = !empty($_POST['note_date']) ? $_POST['note_date'] : date('Y-m-d');
    $text = trim($_POST['text']);
    
    if (empty($subject)) {
        $error_message = "Onderwerp is verplicht.";
    } elseif (empty($text)) {
        $error_message = "Notitie tekst is verplicht.";
    } else {
        try {
            $sql = "INSERT INTO notes (patient_id, user_id, subject, note_date, text, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$patient_id, $current_user['user_id'], $subject, $note_date, $text]);
            
            $success_message = "Notitie succesvol toegevoegd.";
            // Clear form
            $_POST = [];
            
        } catch (PDOException $e) {
            error_log("Error adding note: " . $e->getMessage());
            $error_message = "Er is een fout opgetreden bij het toevoegen van de notitie.";
        }
    }
}

// Process note deletion
if (isset($_GET['delete_note'])) {
    $note_id = intval($_GET['delete_note']);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM notes WHERE note_id = ? AND patient_id = ?");
        $stmt->execute([$note_id, $patient_id]);
        
        if ($stmt->rowCount() > 0) {
            $success_message = "Notitie succesvol verwijderd.";
        } else {
            $error_message = "Notitie niet gevonden of geen rechten om te verwijderen.";
        }
        
        // Redirect to remove the delete parameter from URL
        $redirect_url = "patient_notes.php?id=$patient_id";
        if ($success_message) $redirect_url .= "&success=" . urlencode($success_message);
        if ($error_message) $redirect_url .= "&error=" . urlencode($error_message);
        header("Location: $redirect_url");
        exit;
        
    } catch (PDOException $e) {
        error_log("Error deleting note: " . $e->getMessage());
        $error_message = "Er is een fout opgetreden bij het verwijderen van de notitie.";
    }
}

// Check for messages from redirect
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}

// Fetch notes for this patient, sorted by date (newest first)
try {
    $sql = "SELECT n.*, u.username 
            FROM notes n 
            LEFT JOIN users u ON n.user_id = u.user_id 
            WHERE n.patient_id = ? 
            ORDER BY n.note_date DESC, n.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$patient_id]);
    $notes = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error fetching notes: " . $e->getMessage());
    $error_message = "Er is een fout opgetreden bij het ophalen van notities.";
}

require_once 'includes/header.php';
?>

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-gray-200 fixed h-full overflow-y-auto">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Notities</h2>
                <div class="bg-green-50 px-3 py-2 rounded-lg text-sm font-medium text-green-700">
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
                <a href="edit_patient.php?id=<?php echo $patient_id; ?>" class="flex items-center space-x-2 px-4 py-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="font-medium text-blue-600">Bewerk Patiënt</span>
                </a>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 ml-72 p-8">
        <div class="max-w-5xl">

<div class="notes-container">
    <!-- Quick Patient Info -->
    <div class="patient-summary">
        <div class="summary-item">
            <strong>📞 Telefoon:</strong> 
            <?php echo $patient['phone'] ? htmlspecialchars($patient['phone']) : 'Niet opgegeven'; ?>
        </div>
        <div class="summary-item">
            <strong>✉️ Email:</strong> 
            <?php echo $patient['email'] ? htmlspecialchars($patient['email']) : 'Niet opgegeven'; ?>
        </div>
        <div class="summary-item">
            <strong>🏠 Adres:</strong> 
            <?php 
            $address_parts = array_filter([
                $patient['address'],
                $patient['house_number'],
                $patient['postcode'],
                $patient['city']
            ]);
            echo !empty($address_parts) ? htmlspecialchars(implode(', ', $address_parts)) : 'Niet opgegeven';
            ?>
        </div>
    </div>

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

    <!-- Add New Note Form -->
    <div class="add-note-section">
        <h3>📝 Nieuwe Notitie Toevoegen</h3>
        <form method="POST" action="" class="note-form">
            <div class="form-row">
                <div class="form-group flex-2">
                    <label for="subject">Onderwerp *</label>
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>"
                           placeholder="Bijv. Controle, Klachten, Medicatie, ..."
                           required>
                </div>
                
                <div class="form-group">
                    <label for="note_date">Datum</label>
                    <input type="date" 
                           id="note_date" 
                           name="note_date" 
                           value="<?php echo isset($_POST['note_date']) ? $_POST['note_date'] : date('Y-m-d'); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="text">Notitie *</label>
                <textarea id="text" 
                          name="text" 
                          rows="4" 
                          placeholder="Beschrijf hier de notitie, bevindingen, behandeling, etc..."
                          required><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="add_note" value="1" class="btn btn-success">
                    💾 Notitie Opslaan
                </button>
            </div>
        </form>
    </div>

    <!-- Notes List -->
    <div class="notes-section">
        <div class="notes-header">
            <h3>📋 Alle Notities (<?php echo count($notes); ?>)</h3>
            <?php if (count($notes) > 0): ?>
                <p class="notes-subtitle">Gesorteerd op datum (nieuwste eerst)</p>
            <?php endif; ?>
        </div>

        <?php if (empty($notes)): ?>
            <div class="no-notes">
                <div class="no-notes-icon">📝</div>
                <h4>Nog geen notities</h4>
                <p>Er zijn nog geen notities toegevoegd voor deze patiënt. Voeg hierboven uw eerste notitie toe.</p>
            </div>
        <?php else: ?>
            <div class="notes-list">
                <?php foreach ($notes as $note): ?>
                    <div class="note-item">
                        <div class="note-header">
                            <div class="note-title">
                                <h4><?php echo htmlspecialchars($note['subject']); ?></h4>
                                <div class="note-meta">
                                    <span class="note-date">
                                        📅 <?php echo date('d-m-Y', strtotime($note['note_date'])); ?>
                                    </span>
                                    <span class="note-author">
                                        👤 <?php echo htmlspecialchars($note['username'] ?: 'Onbekend'); ?>
                                    </span>
                                    <span class="note-created">
                                        🕐 <?php echo date('d-m-Y H:i', strtotime($note['created_at'])); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="note-actions">
                                <a href="?id=<?php echo $patient_id; ?>&delete_note=<?php echo $note['note_id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   title="Verwijderen"
                                   onclick="return confirm('Weet u zeker dat u deze notitie wilt verwijderen?')">
                                   🗑️
                                </a>
                            </div>
                        </div>
                        
                        <div class="note-content">
                            <?php echo nl2br(htmlspecialchars($note['text'])); ?>
                        </div>
                        
                        <?php if ($note['updated_at'] !== $note['created_at']): ?>
                            <div class="note-updated">
                                <small>
                                    Laatst bijgewerkt: <?php echo date('d-m-Y H:i', strtotime($note['updated_at'])); ?>
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
    </main>
</div>

<style>
body {
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

.notes-container {
    max-width: 100%;
}

.patient-summary {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    flex-wrap: wrap;
}

.summary-item {
    flex: 1;
    min-width: 200px;
    padding: 0.5rem;
    background: white;
    border-radius: 4px;
    border-left: 4px solid #17a2b8;
}

.add-note-section {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
}

.add-note-section h3 {
    margin-top: 0;
    margin-bottom: 1.5rem;
    color: #1f2937;
    font-size: 1.25rem;
    font-weight: 600;
}

.note-form {
    margin: 0;
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

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e1e1;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
    box-sizing: border-box;
    font-family: inherit;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #17a2b8;
    box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

.notes-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.notes-header {
    padding: 2rem 2rem 1rem 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

.notes-header h3 {
    margin: 0 0 0.5rem 0;
    color: #495057;
}

.notes-subtitle {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.no-notes {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.no-notes-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.no-notes h4 {
    margin-bottom: 0.5rem;
    color: #495057;
}

.notes-list {
    padding: 1rem;
}

.note-item {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    margin-bottom: 1rem;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s;
}

.note-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.note-item:last-child {
    margin-bottom: 0;
}

.note-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #e9ecef;
}

.note-title h4 {
    margin: 0 0 0.5rem 0;
    color: #495057;
}

.note-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: #6c757d;
    flex-wrap: wrap;
}

.note-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.note-actions {
    display: flex;
    gap: 0.25rem;
}

.note-content {
    padding: 1rem;
    line-height: 1.6;
    color: #495057;
}

.note-updated {
    padding: 0 1rem 1rem 1rem;
    color: #6c757d;
    font-style: italic;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
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

.btn-success {
    background-color: #10b981;
    color: white;
    font-weight: 600;
}

.btn-success:hover {
    background-color: #059669;
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
    
    .patient-summary {
        flex-direction: column;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .note-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .note-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .notes-header,
    .add-note-section {
        padding: 1rem;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>