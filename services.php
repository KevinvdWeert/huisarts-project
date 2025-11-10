<?php include_once 'includes/header.php'; ?>

<div class="container mx-auto px-6 py-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 text-white mb-16 animate-fade-in">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-300/30 rounded-full blur-3xl -translate-x-40 translate-y-40"></div>
        <div class="absolute top-10 right-10 w-40 h-40 bg-cyan-400/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-20 w-60 h-60 bg-teal-300/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 py-16 px-8 text-center">
            <div class="mb-8 flex justify-center">
                <div class="w-20 h-20 bg-white/20 rounded-full backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Our 
                <span class="block bg-gradient-to-r from-yellow-200 to-green-200 bg-clip-text text-transparent">
                    Services
                </span>
            </h1>
            <p class="text-xl text-emerald-100 max-w-3xl mx-auto leading-relaxed">
                We offer a comprehensive range of medical services for patients of all ages.
            </p>
            <div class="mt-8 flex justify-center space-x-4">
                <div class="w-16 h-1 bg-white/50 rounded-full"></div>
                <div class="w-8 h-1 bg-white/30 rounded-full"></div>
                <div class="w-4 h-1 bg-white/20 rounded-full"></div>
            </div>
        </div>
    </section>
    
    <!-- General Care Section -->
    <section class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">General Care</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-emerald-600 to-teal-600 mx-auto rounded-full"></div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-emerald-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">General Consultations</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Treatment of acute and chronic complaints with comprehensive medical examinations 
                        and personalized care plans.
                    </p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Preventive Care</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Health checkups and screenings to detect potential health issues early and 
                        maintain optimal wellness.
                    </p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Vaccinations</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Regular and travel vaccinations to protect against various diseases and 
                        maintain community health.
                    </p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Minor Surgery</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Wound treatment and removal of small growths in our modern, well-equipped facility.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Specialized Care Section -->
    <section class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Specialized Care</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-orange-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Diabetes Care</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Complete care for diabetic patients including monitoring, education, and management 
                        of blood sugar levels.
                    </p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Cardiovascular Care</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Monitoring and treatment of cardiovascular conditions including heart disease 
                        and blood pressure management.
                    </p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-teal-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Mental Health</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Support for anxiety, depression, and stress management with compassionate care 
                        and referral services.
                    </p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Elderly Care</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Specialized care for patients 65+ including comprehensive health assessments 
                        and age-related health management.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Appointment Section -->
    <section class="relative rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white p-12 overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl -translate-y-40 translate-x-40"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl translate-y-48 -translate-x-48"></div>
        <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-pink-400/30 rounded-full blur-2xl -translate-x-16 -translate-y-16"></div>
        
        <div class="relative z-10 text-center">
            <div class="mb-6 flex justify-center">
                <div class="w-16 h-16 bg-white/20 rounded-2xl backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-4xl font-bold mb-6">Schedule an Appointment</h2>
            <p class="text-xl text-purple-100 mb-8 max-w-3xl mx-auto">
                To schedule an appointment, please contact us via phone, online portal, or emergency services.
            </p>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="group bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-400 transition-colors duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Phone</h3>
                    <p class="text-blue-200 mb-2 font-semibold">010-123 4567</p>
                    <p class="text-sm text-gray-300">Mon-Fri 08:00-17:00</p>
                </div>
                
                <div class="group bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-400 transition-colors duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Online Portal</h3>
                    <p class="text-green-200 mb-2 font-semibold">Patient Portal</p>
                    <p class="text-sm text-gray-300">24/7 Online Booking</p>
                </div>
                
                <div class="group bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-red-400 transition-colors duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Emergency</h3>
                    <p class="text-red-200 mb-2 font-semibold">116 117</p>
                    <p class="text-sm text-gray-300">After hours emergency</p>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once 'includes/footer.php'; ?>