<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Medical Practice - Your Health, Our Care">
    <meta name="description" content="Medical Practice provides high-quality medical care, including general healthcare and chronic disease management.">
    <meta name="keywords" content="general practitioner, medical care, healthcare, chronic diseases">
    <meta name="robots" content="index, follow">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Medical Practice</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="assets/js/script.js" defer></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen">
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/80 border-b border-white/20 shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="nav-logo">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Medical Practice
                    </h1>
                </div>
                <ul class="hidden md:flex space-x-8">
                    <li><a href="index.php" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a></li>
                    <li><a href="about.php" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">About</a></li>
                    <li><a href="services.php" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Services</a></li>
                    <li><a href="contact.php" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Contact</a></li>
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
                    <li><a href="index.php" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Home</a></li>
                    <li><a href="about.php" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">About</a></li>
                    <li><a href="services.php" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Services</a></li>
                    <li><a href="contact.php" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="min-h-screen">