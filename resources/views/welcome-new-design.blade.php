<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paathshaala - Learn With The Best Online Medical School</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Floating Profile Images Animation */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes float-medium {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(-5deg); }
        }
        
        @keyframes float-fast {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(3deg); }
        }
        
        .profile-float-1 { animation: float-slow 6s ease-in-out infinite; }
        .profile-float-2 { animation: float-medium 5s ease-in-out infinite 0.5s; }
        .profile-float-3 { animation: float-fast 7s ease-in-out infinite 1s; }
        .profile-float-4 { animation: float-slow 5.5s ease-in-out infinite 1.5s; }
        
        /* Badge Pulse Animation */
        @keyframes badge-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .badge-pulse { animation: badge-pulse 2s ease-in-out infinite; }
        
        /* Smooth Scroll */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-b from-cyan-50 via-white to-teal-50">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-xl p-2.5 group-hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Paathshaala</h1>
                        <p class="text-xs text-gray-500">Medical Education Platform</p>
                    </div>
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Home</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">About Us</a>
                    <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Courses</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Contact</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-teal-600 hover:text-teal-700 font-medium transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-teal-600 hover:text-teal-700 font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            Get Started
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-teal-600 font-medium">Home</a>
                <a href="{{ route('about') }}" class="block text-gray-700 hover:text-teal-600 font-medium">About Us</a>
                <a href="{{ route('courses.index') }}" class="block text-gray-700 hover:text-teal-600 font-medium">Courses</a>
                <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-teal-600 font-medium">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-teal-600 font-medium">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-teal-600 font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-teal-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="block text-teal-600 hover:text-teal-700 font-medium">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section with Floating Profiles -->
    <section class="relative pt-32 pb-20 px-4 overflow-hidden bg-gradient-to-br from-cyan-50 via-white to-teal-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="relative z-10">
                    <div class="inline-block mb-4 px-4 py-2 bg-teal-100 rounded-full">
                        <span class="text-teal-700 font-semibold text-sm">🎓 #1 Medical Education Platform</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Learn With The Best<br/>
                        <span class="bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">Online Medical School</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Master healthcare and medical sciences with world-class instructors and cutting-edge curriculum. Start your journey today.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('courses.index') }}" class="px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-full font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                            <span>Explore Courses</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-teal-600 border-2 border-teal-600 rounded-full font-semibold hover:bg-teal-50 transition-all duration-300 inline-flex items-center">
                            <i class="fas fa-play-circle mr-2"></i>
                            <span>Watch Demo</span>
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                        <div>
                            <div class="text-3xl font-bold text-teal-600">10K+</div>
                            <div class="text-sm text-gray-600">Students</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-teal-600">500+</div>
                            <div class="text-sm text-gray-600">Courses</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-teal-600">100+</div>
                            <div class="text-sm text-gray-600">Instructors</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right - Floating Profile Images -->
                <div class="relative h-[500px] hidden md:block">
                    <!-- Profile Image 1 - Top Left -->
                    <div class="absolute top-0 left-0 profile-float-1">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/150?img=5" alt="Student" class="w-32 h-32 rounded-3xl shadow-2xl border-4 border-white">
                            <div class="absolute -top-2 -right-2 bg-pink-500 text-white text-xs px-2 py-1 rounded-full badge-pulse">New</div>
                        </div>
                    </div>
                    
                    <!-- Profile Image 2 - Top Right -->
                    <div class="absolute top-16 right-8 profile-float-2">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/150?img=12" alt="Student" class="w-40 h-40 rounded-3xl shadow-2xl border-4 border-white">
                            <div class="absolute -bottom-2 -left-2 bg-teal-500 text-white text-xs px-2 py-1 rounded-full">Top</div>
                        </div>
                    </div>
                    
                    <!-- Profile Image 3 - Middle Left -->
                    <div class="absolute top-48 left-16 profile-float-3">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/150?img=8" alt="Student" class="w-36 h-36 rounded-3xl shadow-2xl border-4 border-white">
                            <div class="absolute -top-2 -right-2 bg-purple-500 text-white text-xs px-2 py-1 rounded-full badge-pulse">Pro</div>
                        </div>
                    </div>
                    
                    <!-- Profile Image 4 - Bottom Right -->
                    <div class="absolute bottom-0 right-0 profile-float-4">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/150?img=15" alt="Student" class="w-44 h-44 rounded-3xl shadow-2xl border-4 border-white">
                            <div class="absolute -top-2 -left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">Best</div>
                        </div>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute top-32 right-4 w-16 h-16 bg-teal-200 rounded-full opacity-40 blur-xl"></div>
                    <div class="absolute bottom-24 left-4 w-24 h-24 bg-cyan-200 rounded-full opacity-40 blur-xl"></div>
                    <div class="absolute top-64 left-32 w-20 h-20 bg-purple-200 rounded-full opacity-40 blur-xl"></div>
                </div>
            </div>
        </div>
        
        <!-- Background Decorative Circles -->
        <div class="absolute top-20 right-10 w-96 h-96 bg-teal-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-100 rounded-full opacity-20 blur-3xl"></div>
    </section>

    <!-- What We Provide Section -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">What We Provide To You</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive medical education with expert instructors, modern curriculum, and hands-on learning experiences.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Lecturers</h3>
                    <p class="text-gray-600">Learn from experienced medical professionals and certified instructors.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="group p-8 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-book-medical text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Rich Library</h3>
                    <p class="text-gray-600">Access thousands of medical books, journals, and research papers.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="group p-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-video text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Online Classes</h3>
                    <p class="text-gray-600">Live and recorded classes available anytime, anywhere.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="group p-8 bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-red-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">24/7 Support</h3>
                    <p class="text-gray-600">Round-the-clock assistance for all your learning needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Popular Courses</h2>
                    <p class="text-xl text-gray-600">Explore our most sought-after medical programs</p>
                </div>
                <a href="{{ route('courses.index') }}" class="hidden md:inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-full font-semibold hover:bg-teal-700 transition-colors">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Course Card 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-56 bg-gradient-to-br from-teal-500 to-cyan-500 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500" alt="Course" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-green-500 text-white text-xs rounded-full font-semibold">Beginner</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">General Medicine</h3>
                        <p class="text-gray-600 mb-4">Comprehensive introduction to medical sciences and healthcare fundamentals.</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span class="text-sm">12 Weeks</span>
                            </div>
                            <div class="text-teal-600 font-bold text-lg">₹5,999</div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Card 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-56 bg-gradient-to-br from-purple-500 to-pink-500 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=500" alt="Course" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-yellow-500 text-white text-xs rounded-full font-semibold">Intermediate</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Advanced Surgery</h3>
                        <p class="text-gray-600 mb-4">Master surgical techniques and procedures with expert guidance.</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span class="text-sm">16 Weeks</span>
                            </div>
                            <div class="text-teal-600 font-bold text-lg">₹8,999</div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Card 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-56 bg-gradient-to-br from-blue-500 to-indigo-500 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1530497610245-94d3c16cda28?w=500" alt="Course" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-red-500 text-white text-xs rounded-full font-semibold">Advanced</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Cardiology Specialist</h3>
                        <p class="text-gray-600 mb-4">Become a cardiovascular expert with our comprehensive program.</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span class="text-sm">20 Weeks</span>
                            </div>
                            <div class="text-teal-600 font-bold text-lg">₹12,999</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12 md:hidden">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-full font-semibold hover:bg-teal-700 transition-colors">
                    View All Courses <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">What Our Students Say</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Hear from thousands of successful medical professionals who started their journey with us.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Student" class="w-16 h-16 rounded-full border-4 border-white shadow-lg">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Dr. Sarah Johnson</h4>
                            <p class="text-sm text-gray-600">Cardiologist</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The medical courses here transformed my career. The instructors are world-class and the curriculum is cutting-edge. Highly recommended!"</p>
                    <div class="flex mt-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://i.pravatar.cc/100?img=3" alt="Student" class="w-16 h-16 rounded-full border-4 border-white shadow-lg">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Dr. Michael Chen</h4>
                            <p class="text-sm text-gray-600">Surgeon</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Outstanding platform for medical education. The flexible schedule allowed me to learn while working. The support team is amazing!"</p>
                    <div class="flex mt-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <img src="https://i.pravatar.cc/100?img=5" alt="Student" class="w-16 h-16 rounded-full border-4 border-white shadow-lg">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Dr. Emily Davis</h4>
                            <p class="text-sm text-gray-600">Pediatrician</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Best decision I ever made! The comprehensive curriculum and hands-on approach prepared me perfectly for my medical career."</p>
                    <div class="flex mt-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready To Start Your Medical Journey?</h2>
            <p class="text-xl mb-8 opacity-90">Join thousands of students worldwide and become a certified healthcare professional.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-teal-600 rounded-full font-bold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    <span>Enroll Now</span>
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-bold hover:bg-white hover:text-teal-600 transition-all duration-300 inline-flex items-center">
                    <i class="fas fa-phone mr-2"></i>
                    <span>Contact Us</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Paathshaala</h3>
                    <p class="text-gray-400 text-sm">Leading online medical education platform providing world-class healthcare training.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <div class="space-y-2">
                        <a href="{{ route('about') }}" class="block text-gray-400 hover:text-white text-sm">About Us</a>
                        <a href="{{ route('courses.index') }}" class="block text-gray-400 hover:text-white text-sm">Courses</a>
                        <a href="{{ route('contact') }}" class="block text-gray-400 hover:text-white text-sm">Contact</a>
                    </div>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="font-bold mb-4">Support</h4>
                    <div class="space-y-2">
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Help Center</a>
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Terms of Service</a>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h4 class="font-bold mb-4">Newsletter</h4>
                    <p class="text-gray-400 text-sm mb-4">Subscribe to get updates</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l-full text-gray-900 w-full focus:outline-none">
                        <button class="px-6 py-2 bg-teal-600 rounded-r-full hover:bg-teal-700 transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2025 Paathshaala. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
