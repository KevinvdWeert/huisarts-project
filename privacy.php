<?php 
require_once 'config/config.php';
include_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-800 via-gray-800 to-zinc-800 text-white mb-16">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl translate-x-48 translate-y-48"></div>
        <div class="relative z-10 py-16 px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Privacy 
                <span class="block bg-gradient-to-r from-blue-300 to-green-300 bg-clip-text text-transparent">
                    Policy
                </span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                We respect your privacy and handle your personal data with care.
            </p>
        </div>
    </section>
    
    <!-- Content Sections -->
    <div class="space-y-12">
        <!-- Data Collection -->
        <section class="bg-white rounded-3xl p-8 shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">What Data Do We Collect?</h2>
            </div>
            
            <p class="text-lg text-gray-600 mb-6">
                We only collect data that is necessary for medical treatment and administration:
            </p>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold text-gray-800">Personal Information</span>
                    </div>
                    <p class="text-gray-600">Name, address, phone number</p>
                </div>
                
                <div class="bg-green-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold text-gray-800">Medical Data</span>
                    </div>
                    <p class="text-gray-600">Health records and treatment history</p>
                </div>
                
                <div class="bg-purple-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold text-gray-800">Insurance Information</span>
                    </div>
                    <p class="text-gray-600">Insurance provider and policy details</p>
                </div>
                
                <div class="bg-orange-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold text-gray-800">Contact Details</span>
                    </div>
                    <p class="text-gray-600">Email and emergency contact information</p>
                </div>
            </div>
        </section>
        
        <!-- Data Usage -->
        <section class="bg-white rounded-3xl p-8 shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">How Do We Use Your Data?</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Medical Treatment</h3>
                            <p class="text-gray-600">For medical treatment and guidance</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Communication</h3>
                            <p class="text-gray-600">For communication about your care</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Administration</h3>
                            <p class="text-gray-600">For administrative purposes</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Quality Improvement</h3>
                            <p class="text-gray-600">For quality improvement of our services</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Security -->
        <section class="bg-white rounded-3xl p-8 shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Security</h2>
            </div>
            
            <p class="text-lg text-gray-600 mb-6">
                We take appropriate technical and organizational measures to protect your data against loss, 
                misuse, and unauthorized access.
            </p>
            
            <div class="bg-gradient-to-r from-red-50 to-pink-50 p-6 rounded-2xl border border-red-100">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-800 mb-2">Data Protection Measures</h3>
                        <p class="text-red-700">
                            All patient data is encrypted, stored securely, and accessed only by authorized personnel 
                            for legitimate medical purposes.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Your Rights -->
        <section class="bg-white rounded-3xl p-8 shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Your Rights</h2>
            </div>
            
            <p class="text-lg text-gray-600 mb-8">You have the right to:</p>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">Access your data</span>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">Request correction of incorrect data</span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">Request deletion of data (where possible)</span>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">Object to processing</span>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Contact -->
        <section class="relative rounded-3xl bg-gradient-to-r from-blue-600 to-purple-600 text-white p-12 overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-x-36 -translate-y-36"></div>
            <div class="relative z-10 text-center">
                <h2 class="text-3xl font-bold mb-4">Privacy Questions?</h2>
                <p class="text-xl text-blue-100 mb-6">
                    For privacy-related questions, please contact us at:
                </p>
                <div class="inline-flex items-center space-x-3 bg-white/20 backdrop-blur-md rounded-full px-6 py-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <a href="mailto:privacy@medicalpractice.com" class="text-white font-semibold hover:text-blue-200 transition-colors">
                        privacy@medicalpractice.com
                    </a>
                </div>
                
                <p class="text-sm text-blue-200 mt-8">
                    <em>Last updated: <?php echo date('F d, Y'); ?></em>
                </p>
            </div>
        </section>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>