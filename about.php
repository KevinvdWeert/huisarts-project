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
                About Our 
                <span class="block bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent">
                    Practice
                </span>
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto leading-relaxed">
                Our medical practice has been serving the community for over 20 years and is known for personal, 
                committed care for all patients.
            </p>
        </div>
    </section>
    
    <!-- Philosophy Section -->
    <section class="mb-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Our Philosophy</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    We believe in a holistic approach to healthcare, where we not only treat symptoms but also 
                    take preventive measures to promote your overall well-being.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Our commitment extends beyond traditional medical care to include comprehensive wellness 
                    programs and patient education initiatives.
                </p>
            </div>
            <div class="order-1 lg:order-2 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-3xl blur-xl opacity-20"></div>
                <div class="relative bg-white rounded-3xl p-8 shadow-2xl">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">20+</div>
                            <div class="text-sm text-gray-600">Years of Experience</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">5000+</div>
                            <div class="text-sm text-gray-600">Patients Served</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">24/7</div>
                            <div class="text-sm text-gray-600">Emergency Care</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600">98%</div>
                            <div class="text-sm text-gray-600">Patient Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Team Section -->
    <section class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Meet Our Team</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Our dedicated team of medical professionals is committed to providing exceptional care 
                with compassion and expertise.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Dr. John van Berg</h3>
                    <p class="text-blue-600 font-semibold mb-4">Lead General Practitioner</p>
                    <p class="text-gray-600">Specialist in chronic care with over 15 years of experience in family medicine.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Dr. Maria Jensen</h3>
                    <p class="text-green-600 font-semibold mb-4">General Practitioner</p>
                    <p class="text-gray-600">Expert in preventive medicine and women's health with a focus on holistic care.</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Lisa de Vries</h3>
                    <p class="text-purple-600 font-semibold mb-4">Nurse Practitioner</p>
                    <p class="text-gray-600">Specialized nursing professional with expertise in patient care and health education.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Opening Hours Section -->
    <section class="relative rounded-3xl bg-gradient-to-r from-gray-800 to-gray-900 text-white p-12 overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl -translate-x-36 -translate-y-36"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl translate-x-48 translate-y-48"></div>
        
        <div class="relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Opening Hours</h2>
                <p class="text-gray-300 text-lg">We're here when you need us most</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                    <h3 class="text-xl font-bold mb-6 text-blue-300">Weekdays</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-white/20">
                            <span class="text-gray-300">Monday</span>
                            <span class="font-semibold">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/20">
                            <span class="text-gray-300">Tuesday</span>
                            <span class="font-semibold">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/20">
                            <span class="text-gray-300">Wednesday</span>
                            <span class="font-semibold">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/20">
                            <span class="text-gray-300">Thursday</span>
                            <span class="font-semibold">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-300">Friday</span>
                            <span class="font-semibold">08:00 - 17:00</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                    <h3 class="text-xl font-bold mb-6 text-purple-300">Weekend</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-white/20">
                            <span class="text-gray-300">Saturday</span>
                            <span class="font-semibold">09:00 - 12:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 mb-6">
                            <span class="text-gray-300">Sunday</span>
                            <span class="font-semibold text-red-300">Closed</span>
                        </div>
                        <div class="bg-red-500/20 rounded-lg p-4 border border-red-400/30">
                            <div class="text-sm text-red-200">
                                <strong>Emergency Service Available</strong><br>
                                24/7 emergency care through our partner network
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'includes/footer.php'; ?>