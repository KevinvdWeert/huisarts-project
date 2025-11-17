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

require_once 'includes/header.php';
?>

<div class="min-h-screen flex items-center justify-center px-4 py-12" style="margin-top: -2rem;">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="relative">
            <!-- Animated background blobs -->
            <div class="absolute -top-4 -left-4 w-32 h-32 bg-blue-400 rounded-full opacity-20 blur-2xl animate-pulse"></div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-purple-400 rounded-full opacity-20 blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
            
            <!-- Main card -->
            <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden backdrop-blur-lg border border-gray-100">
                <!-- Header with gradient -->
                <div class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 px-8 py-10 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="absolute inset-0">
                        <div class="absolute top-5 right-5 w-20 h-20 bg-white rounded-full opacity-10 blur-xl"></div>
                        <div class="absolute bottom-5 left-5 w-24 h-24 bg-white rounded-full opacity-10 blur-xl"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/30">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Welkom Terug</h2>
                        <p class="text-blue-100 text-sm">Huisartspraktijk Managementsysteem</p>
                    </div>
                </div>
                
                <!-- Form Section -->
                <div class="px-8 py-8">
                    <!-- Alerts -->
                    <?php if ($error_message): ?>
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-lg p-4 animate-shake">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-red-700 text-sm font-medium"><?php echo htmlspecialchars($error_message); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success_message): ?>
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-green-700 text-sm font-medium"><?php echo htmlspecialchars($success_message); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Login Form -->
                    <form method="POST" action="" class="space-y-6" id="loginForm">
                        <!-- Username Field -->
                        <div class="group">
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Gebruikersnaam
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="username" 
                                       name="username" 
                                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 text-gray-800 placeholder-gray-400"
                                       placeholder="Voer uw gebruikersnaam in"
                                       required
                                       autocomplete="username">
                            </div>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Wachtwoord
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 text-gray-800 placeholder-gray-400"
                                       placeholder="Voer uw wachtwoord in"
                                       required
                                       autocomplete="current-password">
                                <button type="button" 
                                        onclick="togglePassword()" 
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white py-4 rounded-xl font-bold text-lg hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg hover:shadow-2xl relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Inloggen
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        </button>
                    </form>
                </div>
                
                <!-- Demo Accounts Section -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 px-8 py-6 border-t border-gray-200">
                    <div class="text-center mb-4">
                        <h3 class="text-sm font-bold text-gray-700 mb-2 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Demo Accounts
                        </h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white rounded-xl p-3 border-2 border-gray-200 hover:border-blue-300 transition-all duration-300 cursor-pointer group" onclick="fillLogin('admin', 'password')">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs font-bold text-gray-700 group-hover:text-purple-600 transition-colors">Admin</div>
                                    <div class="text-xs text-gray-500">Volledige toegang</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-3 border-2 border-gray-200 hover:border-green-300 transition-all duration-300 cursor-pointer group" onclick="fillLogin('doctor', 'password')">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs font-bold text-gray-700 group-hover:text-green-600 transition-colors">Dokter</div>
                                    <div class="text-xs text-gray-500">Standaard toegang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 text-center mt-4">Klik op een demo account om automatisch in te vullen</p>
                </div>
            </div>
        </div>
        
        <!-- Back to home link -->
        <div class="text-center mt-6">
            <a href="index.php" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Terug naar homepage
            </a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

function fillLogin(username, password) {
    document.getElementById('username').value = username;
    document.getElementById('password').value = password;
    
    // Add visual feedback
    const form = document.getElementById('loginForm');
    form.classList.add('scale-[1.01]');
    setTimeout(() => form.classList.remove('scale-[1.01]'), 200);
}

// Add shake animation for errors
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
`;
document.head.appendChild(style);

// Auto-hide success message
<?php if ($success_message): ?>
setTimeout(() => {
    const successAlert = document.querySelector('.bg-gradient-to-r.from-green-50');
    if (successAlert) {
        successAlert.style.transition = 'opacity 0.5s, transform 0.5s';
        successAlert.style.opacity = '0';
        successAlert.style.transform = 'translateY(-20px)';
        setTimeout(() => successAlert.remove(), 500);
    }
}, 5000);
<?php endif; ?>
</script>

<?php require_once 'includes/footer.php'; ?>