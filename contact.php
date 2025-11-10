<?php 
session_start();
include_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-pink-600 via-rose-600 to-red-600 text-white mb-16">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute top-0 left-0 w-72 h-72 bg-pink-300/30 rounded-full blur-3xl -translate-x-36 -translate-y-36"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-rose-400/20 rounded-full blur-2xl"></div>
        <div class="absolute top-1/3 right-1/4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="relative z-10 py-16 px-8 text-center">
            <div class="mb-8 flex justify-center">
                <div class="w-20 h-20 bg-white/20 rounded-full backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Get in 
                <span class="block bg-gradient-to-r from-yellow-200 to-orange-200 bg-clip-text text-transparent">
                    Touch
                </span>
            </h1>
            <p class="text-xl text-pink-100 max-w-3xl mx-auto leading-relaxed">
                Contact us for appointments, questions, or emergencies.
            </p>
            <div class="mt-8 flex justify-center space-x-4">
                <div class="w-16 h-1 bg-white/50 rounded-full"></div>
                <div class="w-8 h-1 bg-white/30 rounded-full"></div>
                <div class="w-4 h-1 bg-white/20 rounded-full"></div>
            </div>
        </div>
    </section>
    
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['form_success'])): ?>
        <div class="bg-gradient-to-r from-green-100 to-emerald-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 backdrop-blur-sm">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm"><?php echo $_SESSION['form_success']; unset($_SESSION['form_success']); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="bg-gradient-to-r from-red-100 to-pink-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-8 backdrop-blur-sm">
            <div class="flex">
                <div class="ml-3">
                    <p class="font-bold">Errors occurred:</p>
                    <ul class="mt-2 text-sm">
                        <?php foreach ($_SESSION['form_errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['form_errors']); ?>
    <?php endif; ?>
    
    <!-- Main Content -->
    <div class="grid lg:grid-cols-2 gap-12">
        <!-- Contact Information -->
        <div class="space-y-8">
            <div class="relative bg-white rounded-3xl p-8 shadow-xl overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full blur-2xl opacity-50"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Contact Information</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Address</h3>
                                <p class="text-gray-600">123 Main Street, 1234 AB Amsterdam</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Phone</h3>
                                <p class="text-gray-600">010-123 4567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Email</h3>
                                <p class="text-gray-600">info@medicalpractice.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Emergency</h3>
                                <p class="text-gray-600">116 117 (after hours)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Opening Hours -->
            <div class="relative bg-white rounded-3xl p-8 shadow-xl overflow-hidden">
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-gradient-to-tr from-green-100 to-blue-100 rounded-full blur-2xl opacity-50"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Opening Hours</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded px-2">
                            <span class="font-medium text-gray-700">Monday</span>
                            <span class="text-gray-600">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded px-2">
                            <span class="font-medium text-gray-700">Tuesday</span>
                            <span class="text-gray-600">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded px-2">
                            <span class="font-medium text-gray-700">Wednesday</span>
                            <span class="text-gray-600">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded px-2">
                            <span class="font-medium text-gray-700">Thursday</span>
                            <span class="text-gray-600">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded px-2">
                            <span class="font-medium text-gray-700">Friday</span>
                            <span class="text-gray-600">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded px-2">
                            <span class="font-medium text-gray-700">Saturday</span>
                            <span class="text-gray-600">09:00 - 12:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="font-medium text-gray-700">Sunday</span>
                            <span class="text-red-600 font-semibold">Closed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="relative bg-white rounded-3xl p-8 shadow-xl overflow-hidden">
            <div class="absolute top-0 left-0 w-48 h-48 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full blur-3xl opacity-40"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Send us a Message</h2>
                
                <form action="contact_handler.php" method="POST" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-gray-300"
                        >
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-gray-300"
                        >
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-gray-300"
                        >
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select 
                            id="subject" 
                            name="subject"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-gray-300"
                        >
                            <option value="appointment" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'appointment') ? 'selected' : ''; ?>>Book Appointment</option>
                            <option value="question" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'question') ? 'selected' : ''; ?>>General Question</option>
                            <option value="complaint" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'complaint') ? 'selected' : ''; ?>>Complaint</option>
                            <option value="compliment" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'compliment') ? 'selected' : ''; ?>>Compliment</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="5" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 resize-none hover:border-gray-300"
                        ><?php echo isset($_SESSION['form_data']['message']) ? htmlspecialchars($_SESSION['form_data']['message']) : ''; ?></textarea>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-xl"
                    >
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
unset($_SESSION['form_data']); 
include_once 'includes/footer.php'; 
?>