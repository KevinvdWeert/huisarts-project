<?php 
require_once 'config/config.php';
require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white mb-16">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -translate-y-48 translate-x-48"></div>
        <div class="relative z-10 py-16 px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Our 
                <span class="block bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent">
                    Medical Services
                </span>
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto leading-relaxed">
                Comprehensive healthcare services designed to meet all your medical needs with expertise and compassion.
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="mb-16 relative">     
            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Modern Equipment</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            State-of-the-art medical technology and equipment for accurate diagnoses and effective treatments.
                        </p>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Expert Team</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Highly qualified medical professionals with years of experience and continuous education.
                        </p>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-br from-orange-100 to-red-100 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Quick Service</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Efficient appointment scheduling and minimal waiting times for urgent and routine care.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Call to Action Banner -->
            <div class="mt-12 relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-8">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 text-center text-white">
                    <h3 class="text-2xl font-bold mb-3">Ready to Experience Quality Healthcare?</h3>
                    <p class="text-lg text-purple-100 mb-6 max-w-2xl mx-auto">
                        Join thousands of satisfied patients who trust us with their health and wellness needs.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="contact.php" class="bg-white text-purple-600 px-6 py-3 rounded-full font-semibold hover:bg-purple-50 transition-all duration-300 transform hover:scale-105">
                            Book Appointment
                        </a>
                        <a href="about.php" class="border-2 border-white/50 text-white px-6 py-3 rounded-full font-semibold hover:bg-white/20 transition-all duration-300">
                            Learn About Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- General Care Section -->
    <section class="mb-16 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 rounded-3xl -z-10"></div>
        <div class="py-12 px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    General <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Care Services</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-emerald-600 to-teal-600 mx-auto rounded-full mb-6"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Our primary healthcare services provide comprehensive medical care for patients of all ages.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100/50 rounded-full blur-2xl opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-emerald-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">General Consultations</h3>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Comprehensive medical examinations and treatment for acute and chronic conditions 
                            with personalized care plans tailored to your needs.
                        </p>
                        <ul class="text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Health assessments
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Diagnosis and treatment
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Follow-up care
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-green-100/50 rounded-full blur-2xl opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Preventive Care</h3>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Proactive healthcare to detect potential health issues early and maintain 
                            optimal wellness through regular screenings and health education.
                        </p>
                        <ul class="text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Annual health checkups
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Cancer screenings
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Health education
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-36 h-36 bg-purple-100/50 rounded-full blur-2xl opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Vaccinations</h3>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Complete vaccination services including routine immunizations and travel vaccines 
                            to protect against various diseases and maintain community health.
                        </p>
                        <ul class="text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Routine immunizations
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Travel vaccinations
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Flu shots
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-orange-100/50 rounded-full blur-2xl opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Minor Procedures</h3>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Safe and effective minor surgical procedures performed in our modern, 
                            well-equipped facility with proper sterilization protocols.
                        </p>
                        <ul class="text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Wound care and suturing
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Mole and cyst removal
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Skin lesion treatment
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Specialized Care Section -->
    <section class="mb-16 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-3xl -z-10"></div>
        <div class="py-12 px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Specialized <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Care Services</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full mb-6"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Advanced medical care for specific conditions requiring specialized attention and expertise.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Diabetes Care</h3>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Comprehensive diabetes management including monitoring, education, and lifestyle guidance.
                        </p>
                        <div class="text-left space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                Blood sugar monitoring
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-orange-400 rounded-full mr-2"></div>
                                Medication management
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
                                Dietary counseling
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Cardiovascular Care</h3>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Heart health monitoring and treatment for cardiovascular conditions and risk factors.
                        </p>
                        <div class="text-left space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                Blood pressure monitoring
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-indigo-400 rounded-full mr-2"></div>
                                Cholesterol management
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                                Heart disease prevention
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-teal-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Mental Health Support</h3>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4">
                            Compassionate mental health care and support for anxiety, depression, and stress management.
                        </p>
                        <div class="text-left space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                Mental health screening
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-teal-400 rounded-full mr-2"></div>
                                Counseling referrals
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-cyan-400 rounded-full mr-2"></div>
                                Stress management
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Appointment Scheduling Section -->
    <section class="relative rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white p-12 overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl -translate-y-40 translate-x-40"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl translate-y-48 -translate-x-48"></div>
        <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-pink-400/30 rounded-full blur-2xl -translate-x-16 -translate-y-16"></div>
        
        <div class="relative z-10 text-center">
            <div class="mb-8 flex justify-center">
                <div class="w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Schedule Your Visit?</h2>
            <p class="text-xl text-purple-100 mb-10 max-w-3xl mx-auto">
                Contact us today to book your appointment or to learn more about our comprehensive healthcare services.
            </p>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto mb-8">
                <div class="group bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/25 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-500/80 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-400 transition-colors duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Call Us</h3>
                    <p class="text-blue-200 mb-2 font-semibold text-lg">010-123 4567</p>
                    <p class="text-sm text-gray-300">Monday - Friday: 8:00 AM - 5:00 PM</p>
                    <p class="text-sm text-gray-300">Saturday: 9:00 AM - 12:00 PM</p>
                </div>
                
                <div class="group bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/25 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-green-500/80 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-400 transition-colors duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Online Booking</h3>
                    <p class="text-green-200 mb-2 font-semibold text-lg">Patient Portal</p>
                    <p class="text-sm text-gray-300">24/7 convenient online scheduling</p>
                    <p class="text-sm text-gray-300">Manage your appointments anytime</p>
                </div>
                
                <div class="group bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/25 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-red-500/80 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-red-400 transition-colors duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Emergency</h3>
                    <p class="text-red-200 mb-2 font-semibold text-lg">116 117</p>
                    <p class="text-sm text-gray-300">After hours emergency service</p>
                    <p class="text-sm text-gray-300">Available 24/7 for urgent care</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="contact.php" class="bg-white/20 backdrop-blur-md text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-purple-600 transition-all duration-300 transform hover:scale-105 border border-white/30">
                    Contact Us Today
                </a>
                <a href="about.php" class="border-2 border-white/50 text-white px-8 py-4 rounded-full font-semibold hover:bg-white/20 transition-all duration-300">
                    Learn More About Us
                </a>
            </div>
        </div>
    </section>
</div>

<?php require_once 'includes/footer.php'; ?>