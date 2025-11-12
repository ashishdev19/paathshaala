<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Paathshaala</h1>
                    </a>
                    
                    <div class="hidden md:block ml-10">
                        <div class="flex items-baseline space-x-4">
                            <a href="{{ route('home') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Home</a>
                            <a href="{{ route('courses.index') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Courses</a>
                            <a href="{{ route('about') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">About</a>
                            <a href="{{ route('contact') }}" class="text-indigo-600 px-3 py-2 text-sm font-medium border-b-2 border-indigo-600">Contact</a>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">
                    Get In Touch
                </h1>
                <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Have questions about our courses or need support? We're here to help you on your healthcare learning journey.
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Send us a message</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Your first name">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Your last name">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="your.email@example.com">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select a subject</option>
                                <option value="course_inquiry">Course Inquiry</option>
                                <option value="technical_support">Technical Support</option>
                                <option value="enrollment_help">Enrollment Help</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tell us how we can help you..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Contact Information</h2>
                    
                    <div class="space-y-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Our Address</h3>
                                <p class="text-gray-600">123 Healthcare Education Center<br>Medical District, New Delhi<br>India - 110001</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Phone Number</h3>
                                <p class="text-gray-600">+91 9876543210</p>
                                <p class="text-gray-600">+91 9876543211 (Support)</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Address</h3>
                                <p class="text-gray-600">info@paathshaala.com</p>
                                <p class="text-gray-600">support@paathshaala.com</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Office Hours</h3>
                                <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                                <p class="text-gray-600">Saturday: 10:00 AM - 4:00 PM</p>
                                <p class="text-gray-600">Sunday: Closed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center hover:bg-indigo-200 transition duration-300">
                                <span class="text-indigo-600 font-semibold">f</span>
                            </a>
                            <a href="#" class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center hover:bg-indigo-200 transition duration-300">
                                <span class="text-indigo-600 font-semibold">t</span>
                            </a>
                            <a href="#" class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center hover:bg-indigo-200 transition duration-300">
                                <span class="text-indigo-600 font-semibold">in</span>
                            </a>
                            <a href="#" class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center hover:bg-indigo-200 transition duration-300">
                                <span class="text-indigo-600 font-semibold">ig</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Quick answers to common questions</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How do I enroll in a course?</h3>
                    <p class="text-gray-600">Simply browse our courses, select the one that interests you, and click "Enroll Now". You'll need to create an account and complete the payment process.</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Are the certificates recognized?</h3>
                    <p class="text-gray-600">Yes, our certificates are industry-recognized and can help advance your healthcare career. They demonstrate your commitment to continuous learning.</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Can I access courses on mobile?</h3>
                    <p class="text-gray-600">Absolutely! Our platform is fully responsive and works great on all devices, including smartphones and tablets.</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What if I need technical support?</h3>
                    <p class="text-gray-600">Our support team is available to help you with any technical issues. Contact us via email or phone during business hours.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Paathshaala</h3>
                    <p class="text-gray-400">Empowering healthcare professionals with quality education and training.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('courses.index') }}" class="text-gray-400 hover:text-white">Courses</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 info@paathshaala.com</li>
                        <li>📞 +91 9876543210</li>
                        <li>📍 New Delhi, India</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Paathshaala. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>