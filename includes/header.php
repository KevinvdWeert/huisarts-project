<?php
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../auth.php';
}

// Detect current page
$current_page = basename($_SERVER['PHP_SELF']);

// Page configuration
$page_config = [
    'index.php' => ['title' => 'Home', 'description' => 'Medical Practice provides high-quality medical care, including general healthcare and chronic disease management.'],
    'about.php' => ['title' => 'About Us', 'description' => 'Learn about our medical practice and our commitment to providing excellent healthcare.'],
    'services.php' => ['title' => 'Our Services', 'description' => 'Comprehensive healthcare services designed to meet all your medical needs.'],
    'contact.php' => ['title' => 'Contact Us', 'description' => 'Get in touch with us for appointments, questions, or emergencies.'],
    'privacy.php' => ['title' => 'Privacy Policy', 'description' => 'Learn how we protect and handle your personal medical information.'],
    'dashboard.php' => ['title' => 'Dashboard', 'description' => 'Patient management dashboard for healthcare professionals.'],
    'add_patient.php' => ['title' => 'Add New Patient', 'description' => 'Register a new patient in the system.'],
    'edit_patient.php' => ['title' => 'Edit Patient', 'description' => 'Update patient information.'],
    'patient_notes.php' => ['title' => 'Patient Notes', 'description' => 'View and manage patient medical notes.'],
    'login.php' => ['title' => 'Login', 'description' => 'Login to the medical practice management system.'],
];

// Set page-specific or default values
$page_title = isset($page_config[$current_page]) ? $page_config[$current_page]['title'] : 'Medical Practice';
$page_description = isset($page_config[$current_page]) ? $page_config[$current_page]['description'] : 'Medical Practice provides high-quality medical care, including general healthcare and chronic disease management.';

// Allow pages to override title and description
if (isset($custom_page_title)) {
    $page_title = $custom_page_title;
}
if (isset($custom_page_description)) {
    $page_description = $custom_page_description;
}

// Function to check if link is active
function isActivePage($page) {
    global $current_page;
    return $current_page === $page;
}

// Navigation link classes
function getNavLinkClass($page) {
    $base_class = "text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium";
    $active_class = "text-blue-600 font-bold border-b-2 border-blue-600";
    return isActivePage($page) ? $active_class : $base_class;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="<?php echo htmlspecialchars($page_title); ?> - Medical Practice">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="general practitioner, medical care, healthcare, chronic diseases">
    <meta name="robots" content="index, follow">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title><?php echo htmlspecialchars($page_title); ?> - Medical Practice</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="nav-logo">
                    <a href="index.php" class="flex items-center">
                        <img src="assets/img/logo.svg" alt="Huisarts Logo" class="h-12">
                    </a>
                </div>
                <ul class="hidden md:flex space-x-8 items-center">
                    <li><a href="index.php" class="<?php echo getNavLinkClass('index.php'); ?>">Home</a></li>
                    <li><a href="about.php" class="<?php echo getNavLinkClass('about.php'); ?>">About</a></li>
                    <li><a href="services.php" class="<?php echo getNavLinkClass('services.php'); ?>">Services</a></li>
                    <li><a href="contact.php" class="<?php echo getNavLinkClass('contact.php'); ?>">Contact</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="dashboard.php" class="<?php echo getNavLinkClass('dashboard.php'); ?>">Dashboard</a></li>
                        <li><a href="add_patient.php" class="<?php echo getNavLinkClass('add_patient.php'); ?>">Nieuwe Patiënt</a></li>
                        <li><a href="logout.php" class="text-white px-6 py-2 rounded-full font-semibold transition-all duration-300 transform hover:scale-105" style="background-color: rgba(37, 99, 235, var(--tw-bg-opacity));">Uitloggen</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="bg-blue-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">Inloggen</a></li>
                    <?php endif; ?>
                </ul>
                <button class="mobile-menu-btn md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- Mobile menu -->
            <div class="mobile-nav-menu hidden md:hidden mt-4 py-4 border-t border-gray-200">
                <ul class="space-y-2">
                    <li><a href="index.php" class="block py-2 <?php echo isActivePage('index.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">Home</a></li>
                    <li><a href="about.php" class="block py-2 <?php echo isActivePage('about.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">About</a></li>
                    <li><a href="services.php" class="block py-2 <?php echo isActivePage('services.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">Services</a></li>
                    <li><a href="contact.php" class="block py-2 <?php echo isActivePage('contact.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">Contact</a></li>
                    <li><a href="privacy.php" class="block py-2 <?php echo isActivePage('privacy.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">Privacy</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="dashboard.php" class="block py-2 <?php echo isActivePage('dashboard.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">Dashboard</a></li>
                        <li><a href="add_patient.php" class="block py-2 <?php echo isActivePage('add_patient.php') ? 'text-blue-600 font-bold' : 'text-gray-700'; ?> hover:text-blue-600 transition-colors">Nieuwe Patiënt</a></li>
                        <li class="border-t border-gray-200 pt-2">
                            <span class="block py-2 text-gray-500 text-sm"><?php echo htmlspecialchars(getCurrentUser()['username']); ?> (<?php echo htmlspecialchars(getCurrentUser()['role']); ?>)</span>
                        </li>
                        <li><a href="logout.php" class="block py-2 text-red-600 hover:text-red-700 transition-colors font-medium">Uitloggen</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="block py-2 text-blue-600 hover:text-blue-700 transition-colors font-semibold">Inloggen</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <main class="flex-1">