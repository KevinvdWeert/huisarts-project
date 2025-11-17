<?php
require_once 'auth.php';
$pdo = getDbConnection();

$error_message = '';
$success_message = '';

// Check if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

// Process login form
if ($_POST && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error_message = 'Voer zowel gebruikersnaam als wachtwoord in.';
    } else {
        if (login($pdo, $username, $password)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = 'Ongeldige gebruikersnaam of wachtwoord.';
        }
    }
}

// Check for timeout message
if (isset($_GET['timeout'])) {
    $error_message = 'Uw sessie is verlopen. Log opnieuw in.';
}

// Check for logout message
if (isset($_GET['logout'])) {
    $success_message = 'U bent succesvol uitgelogd.';
}

include 'includes/header.php';
?>

<div class="login-container">
    <div class="login-form">
        <div class="login-header">
            <h2>Inloggen</h2>
            <p>Huisartspraktijk Managementsysteem</p>
        </div>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Gebruikersnaam:</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-full">Inloggen</button>
        </form>
        
        <div class="login-footer">
            <p><strong>Demo accounts:</strong></p>
            <p>Admin: admin / password</p>
            <p>Dokter: doctor / password</p>
        </div>
    </div>
</div>

<style>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: -20px;
    padding: 20px;
}

.login-form {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-header h2 {
    color: #333;
    margin-bottom: 0.5rem;
}

.login-header p {
    color: #666;
    font-size: 0.9rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #333;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e1e1;
    border-radius: 5px;
    font-size: 1rem;
    transition: border-color 0.3s;
    box-sizing: border-box;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #667eea;
    color: white;
}

.btn-primary:hover {
    background-color: #5a6fd8;
}

.btn-full {
    width: 100%;
}

.alert {
    padding: 1rem;
    border-radius: 5px;
    margin-bottom: 1.5rem;
}

.alert-error {
    background-color: #fee;
    color: #c33;
    border: 1px solid #fcc;
}

.alert-success {
    background-color: #efe;
    color: #363;
    border: 1px solid #cfc;
}

.login-footer {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
    font-size: 0.85rem;
    color: #666;
    text-align: center;
}

.login-footer p {
    margin: 0.25rem 0;
}
</style>

<?php include 'includes/footer.php'; ?>