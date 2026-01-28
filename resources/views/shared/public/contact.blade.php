<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - {{ config('app.name', 'Medniks') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    @include('shared.partials.header')

    <!-- Hero Section -->
    <div class="bg-teal-600 text-black py-20 pt-32">
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
                    @csrf
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
                                class="w-full bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-teal-700 transition-colors">
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

    <footer class="text-white" style="background-color: #008080;">
        <!-- Newsletter Section -->
        <div class="py-16" style="background-color: #008080;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-4xl font-bold mb-4">Stay Updated with Medical Insights</h3>
                <p class="text-xl text-teal-100 mb-8 max-w-2xl mx-auto">Get the latest medical research updates, course announcements, and exclusive healthcare content delivered to your inbox.</p>
                <div class="max-w-md mx-auto flex gap-4">
                    <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-teal-300">
                    <button class="px-8 py-4 bg-white text-teal-700 rounded-2xl font-semibold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">Subscribe</button>
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
    <footer class="text-white py-12 mt-0" style="background-color: #008080;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white">{{ config('app.name') }}</h3>
                    <p class="text-teal-100 mb-4">Empowering medical professionals through quality education and training</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="Facebook">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="Instagram">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="YouTube">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Platform</h4>
                    <ul class="space-y-2 text-teal-50">
                        <li><a href="{{ route('courses.index') }}" class="hover:text-white transition-colors">Browse Courses</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#faculty" class="hover:text-white transition-colors">Our Faculty</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Specializations -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Specializations</h4>
                    <ul class="space-y-2 text-teal-50">
                        <li><a href="#" class="hover:text-white transition-colors">Aesthetic Medicine</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Aesthetic Gynecology</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Ultrasound</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">IVF & Reproductive Medicine</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Surgical Courses</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Contact Us</h4>
                    <ul class="space-y-2 text-teal-100">
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
            <div class="border-t border-teal-200/60 pt-6 text-center text-teal-50">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
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
