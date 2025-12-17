<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - <?php echo e(config('app.name', 'Medniks')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-lg shadow-sm border-b border-gray-100 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Medniks</h1>
                        <p class="text-xs text-gray-500 font-medium">Medical Excellence</p>
                    </div>
                </a>
                
                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="<?php echo e(url('/')); ?>" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Home</a>
                    <a href="<?php echo e(route('courses.index')); ?>" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                    <a href="<?php echo e(route('about')); ?>" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                    <a href="<?php echo e(route('contact')); ?>" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Contact</a>
                </nav>
                
                <!-- Auth Links - Always visible -->
                <div class="flex items-center space-x-2">
                    <?php if(auth()->guard()->check()): ?>
                        <!-- User Dropdown -->
                        <div class="relative">
                            <button onclick="toggleUserDropdown()" class="flex items-center space-x-2 px-4 py-2 md:px-6 md:py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-base rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                <span><?php echo e(Auth::user()->name); ?></span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50">
                                <a href="<?php echo e(url('/dashboard')); ?>" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile Settings
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    My Certificates
                                </a>
                                <hr class="my-2">
                                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline w-full">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 md:px-6 md:py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-base rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02] whitespace-nowrap">Login/Register</a>
                    <?php endif; ?>
                    
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 text-gray-600 hover:text-gray-900 focus:outline-none" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="px-4 py-3 space-y-2">
                <a href="<?php echo e(url('/')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Home</a>
                <a href="<?php echo e(route('courses.index')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                <a href="<?php echo e(route('about')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                <a href="<?php echo e(route('contact')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Contact</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-20 pt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">Contact Us</h1>
            <p class="text-xl max-w-3xl mx-auto">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Whether you're a student looking to enroll, an instructor wanting to teach, or just have a question, we're here to help.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                            <p class="mt-1 text-gray-600">support@medniks.com</p>
                            <p class="text-gray-600">info@medniks.com</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <i class="fas fa-phone text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                            <p class="mt-1 text-gray-600">+1 (555) 123-4567</p>
                            <p class="text-gray-600">Mon-Fri, 9am-6pm</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Office</h3>
                            <p class="mt-1 text-gray-600">123 Medical Plaza</p>
                            <p class="text-gray-600">Healthcare District, HD 12345</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">
                            <i class="fab fa-facebook text-3xl"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">
                            <i class="fab fa-twitter text-3xl"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">
                            <i class="fab fa-linkedin text-3xl"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">
                            <i class="fab fa-instagram text-3xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
                <form action="#" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"></textarea>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How do I enroll in a course?</h3>
                    <p class="text-gray-600">Simply browse our course catalog, select the course you're interested in, and click "Enroll Now". You'll be guided through the payment process.</p>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Are the certificates recognized?</h3>
                    <p class="text-gray-600">Yes, all our certificates are recognized and can be shared on professional networks like LinkedIn.</p>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Can I get a refund?</h3>
                    <p class="text-gray-600">We offer a 30-day money-back guarantee if you're not satisfied with your course.</p>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How do I become an instructor?</h3>
                    <p class="text-gray-600">Visit our "Become an Instructor" page or contact us directly to learn about the requirements and application process.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white">
        <!-- Newsletter Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-4xl font-bold mb-4">Stay Updated with Medical Insights</h3>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Get the latest medical research updates, course announcements, and exclusive healthcare content delivered to your inbox.</p>
                <div class="max-w-md mx-auto flex gap-4">
                    <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-300">
                    <button class="px-8 py-4 bg-white text-blue-600 rounded-2xl font-semibold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">Subscribe</button>
                </div>
            </div>
        </div>
        
        <!-- Main Footer Content -->
        
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        // User dropdown toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button[onclick="toggleUserDropdown()"]');
            
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }
        });
    </script>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white"><?php echo e(config('app.name')); ?></h3>
                    <p class="text-gray-400 mb-4">Empowering medical professionals through quality education and training</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-blue-600 flex items-center justify-center transition-colors" aria-label="Facebook">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-pink-600 flex items-center justify-center transition-colors" aria-label="Instagram">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-red-600 flex items-center justify-center transition-colors" aria-label="YouTube">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-blue-700 flex items-center justify-center transition-colors" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Platform</h4>
                    <ul class="space-y-2">
                        <li><a href="<?php echo e(route('courses.index')); ?>" class="hover:text-blue-400 transition-colors">Browse Courses</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="hover:text-blue-400 transition-colors">About Us</a></li>
                        <li><a href="#faculty" class="hover:text-blue-400 transition-colors">Our Faculty</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-blue-400 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Specializations -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Specializations</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Aesthetic Medicine</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Aesthetic Gynecology</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Ultrasound</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">IVF & Reproductive Medicine</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Surgical Courses</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>
                            <i class="fas fa-envelope mr-2"></i>
                            info@medniks.com
                        </li>
                        <li>
                            <i class="fas fa-phone mr-2"></i>
                            +1 234 567 8900
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            123 Medical Plaza, Healthcare City
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 pt-6 text-center text-gray-400">
                <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
                <div class="mt-2">
                    <span class="inline-block mr-4">
                        <i class="fas fa-shield-alt mr-1"></i>SSL Secured
                    </span>
                    <span class="inline-block">
                        <i class="fas fa-certificate mr-1"></i>ISO Certified
                    </span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/shared/public/contact.blade.php ENDPATH**/ ?>