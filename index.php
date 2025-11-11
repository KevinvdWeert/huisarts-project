<?php 
// Include config first to set session parameters
require_once 'config/config.php';
require_once 'auth.php'; 
include_once 'includes/header.php'; 
include_once 'database/connection.php'; 
?>

<!-- Check if user is logged in and show admin panel link -->
<?php if (isLoggedIn()): ?>
    <div class="admin-panel-banner">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="text-white">
                Welkom, <?php echo htmlspecialchars(getCurrentUser()['username']); ?>! 
                <span class="text-white/80">(<?php echo htmlspecialchars(getCurrentUser()['role']); ?>)</span>
            </div>
            <div class="space-x-4">
                <a href="dashboard.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-all duration-300">
                    📊 Patiënten Dashboard
                </a>
                <a href="logout.php" class="border border-white text-white px-4 py-2 rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                    Uitloggen
                </a>
            </div>
        </div>
    </div>
    
    <style>
    .admin-panel-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 50;
    }
    </style>
<?php endif; ?>

<div class="container mx-auto px-6 py-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 text-white mb-16">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 py-20 px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Welcome to Our 
                <span class="block bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent">
                    Medical Practice
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                We provide high-quality medical care to our patients. Our services include general healthcare, 
                preventive care, and chronic disease management. Your health is central to everything we do.
            </p>
            <div class="mt-10 space-x-4">
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        📊 Ga naar Dashboard
                    </a>
                    <a href="add_patient.php" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        ➕ Nieuwe Patiënt
                    </a>
                <?php else: ?>
                    <button class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Book Appointment
                    </button>
                    <button class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        <a href="services.php">Learn More</a>
                    </button>
                <?php endif; ?>
            </div>
            
            <?php if (!isLoggedIn()): ?>
                <div class="mt-8">
                    <a href="login.php" class="text-white/80 hover:text-white transition-colors duration-300 underline">
                        👨‍⚕️ Medewerker Inloggen
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Services Section -->
    <section class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Our <span class="text-blue-600">Services</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">General Consultations</h3>
                    <p class="text-gray-600">Comprehensive medical examinations and treatment for acute and chronic conditions.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Vaccinations & Immunizations</h3>
                    <p class="text-gray-600">Complete vaccination services including regular and travel immunizations.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Health Screenings</h3>
                    <p class="text-gray-600">Preventive health checkups and early detection of health conditions.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Chronic Disease Management</h3>
                    <p class="text-gray-600">Specialized care for patients with diabetes, hypertension, and other chronic conditions.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Preventive Care</h3>
                    <p class="text-gray-600">Comprehensive preventive medicine to maintain optimal health and wellness.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-green-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Medical Screening</h3>
                    <p class="text-gray-600">Advanced medical screenings and diagnostic services for early health assessment.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact CTA Section -->
    <section class="relative rounded-3xl bg-gradient-to-r from-blue-600 to-purple-600 text-white p-12 text-center overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-300/20 rounded-full blur-3xl translate-x-40 translate-y-40"></div>
        <div class="relative z-10">
            <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                For appointments or more information, please contact us via phone or email.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <p class="text-lg"><strong>Phone:</strong> 010-123 4567</p>
                <span class="hidden sm:block text-blue-300">|</span>
                <p class="text-lg"><strong>Email:</strong> info@medicalpractice.com</p>
            </div>
        </div>
    </section>
</div>

<?php include_once 'includes/footer.php'; ?>