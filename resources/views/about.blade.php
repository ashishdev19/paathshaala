<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Paathshaala</title>
    
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
                            <a href="{{ route('about') }}" class="text-indigo-600 px-3 py-2 text-sm font-medium border-b-2 border-indigo-600">About</a>
                            <a href="{{ route('contact') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Contact</a>
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
                    About Paathshaala
                </h1>
                <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Empowering the next generation of healthcare professionals through world-class online education.
                </p>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Our Mission</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    To bridge the gap between traditional healthcare education and modern learning needs by providing 
                    accessible, high-quality, and practical medical education to students worldwide.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
                    <p class="text-gray-600">Using cutting-edge technology to deliver immersive learning experiences</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Community</h3>
                    <p class="text-gray-600">Building a supportive network of healthcare professionals and students</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Excellence</h3>
                    <p class="text-gray-600">Maintaining the highest standards in medical education and certification</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Meet Our Expert Teachers</h2>
                <p class="text-xl text-gray-600">Learn from experienced healthcare professionals and medical experts</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($teachers as $teacher)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600">{{ substr($teacher->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $teacher->name }}</h3>
                        <p class="text-gray-600 mb-3">Healthcare Professional</p>
                        <div class="text-sm text-gray-500">
                            <p>{{ $teacher->active_courses_count }} Active Courses</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-white">1000+</div>
                    <div class="text-indigo-100">Students Enrolled</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">50+</div>
                    <div class="text-indigo-100">Expert Teachers</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">100+</div>
                    <div class="text-indigo-100">Courses Available</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">95%</div>
                    <div class="text-indigo-100">Success Rate</div>
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