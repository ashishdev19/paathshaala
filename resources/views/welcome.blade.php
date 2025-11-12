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
            <div class="flex justify-between items-center h-24">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="rounded-xl p-2.5 group-hover:shadow-lg transition-all duration-300" style="background: linear-gradient(135deg, #0f766e, #0891b2);"
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Paathshaala</h1>
                        <p class="text-xs text-gray-500">Medical Education Platform</p>
                    </div>
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 font-medium transition-colors" style="hover:color: #0f766e;">Home</a>
                    <a href="{{ route('about') }}" class="text-gray-700 font-medium transition-colors" style="hover:color: #0f766e;">About Us</a>
                    <a href="{{ route('courses.index') }}" class="text-gray-700 font-medium transition-colors" style="hover:color: #0f766e;">Courses</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 font-medium transition-colors" style="hover:color: #0f766e;">Contact</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-teal-600 hover:text-teal-700 font-medium transition-colors text-lg">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-lg">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="px-6 py-2.5 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-lg" style="background: linear-gradient(135deg, #0f766e, #0891b2);">Sign Up</a>
                    @endauth
                </div>

                <!-- Mobile Navigation Buttons -->
                <div class="md:hidden flex flex-wrap gap-3 py-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium rounded-full border-2 transition-all duration-300" style="color: #0f766e; border-color: #0f766e;" onmouseover="this.style.backgroundColor='#f0fdfa'" onmouseout="this.style.backgroundColor='transparent'">Home</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 text-sm font-medium rounded-full border-2 transition-all duration-300" style="color: #0f766e; border-color: #0f766e;" onmouseover="this.style.backgroundColor='#f0fdfa'" onmouseout="this.style.backgroundColor='transparent'">About</a>
                    <a href="{{ route('courses.index') }}" class="px-4 py-2 text-sm font-medium rounded-full border-2 transition-all duration-300" style="color: #0f766e; border-color: #0f766e;" onmouseover="this.style.backgroundColor='#f0fdfa'" onmouseout="this.style.backgroundColor='transparent'">Courses</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 text-sm font-medium rounded-full border-2 transition-all duration-300" style="color: #0f766e; border-color: #0f766e;" onmouseover="this.style.backgroundColor='#f0fdfa'" onmouseout="this.style.backgroundColor='transparent'">Contact</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium rounded-full text-white transition-all duration-300" style="background: linear-gradient(135deg, #0f766e, #0891b2);">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-medium rounded-full border-2 transition-all duration-300" style="color: #dc2626; border-color: #dc2626;" onmouseover="this.style.backgroundColor='#fef2f2'" onmouseout="this.style.backgroundColor='transparent'">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium rounded-full text-white transition-all duration-300" style="background: linear-gradient(135deg, #0f766e, #0891b2);">Sign Up</a>
                    @endauth
                </div>
    </nav>

    <!-- Hero Section with Floating Profiles -->
    <section class="relative pb-20 px-4 overflow-hidden bg-gradient-to-b from-cyan-25 via-white to-cyan-25" style="background: linear-gradient(to bottom, #f0fdfa, #ffffff, #f0fdfa); padding-top: 140px;"
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="relative z-10">
                    <div class="inline-flex items-center mb-6 px-4 py-2 rounded-full" style="background: linear-gradient(to right, #ccfbf1, #a7f3d0); border: 1px solid #0f766e;">
                        <i class="fas fa-award mr-2" style="color: #0f766e;"></i>
                        <span class="font-semibold text-sm" style="color: #0f766e;">#1 Medical Education Platform</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                        Master Medicine<br/>
                        <span style="background: linear-gradient(135deg, #0f766e, #0891b2, #0369a1); -webkit-background-clip: text; background-clip: text; color: transparent;">Your Way</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Join 50,000+ healthcare professionals learning from world-renowned experts. Interactive courses, live sessions, and lifetime access.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ route('courses.index') }}" class="px-8 py-4 text-white rounded-full font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center group" style="background: linear-gradient(135deg, #0f766e, #0891b2);"
                            <span>Start Learning Today</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="px-8 py-4 bg-white rounded-full font-semibold hover:shadow-lg transition-all duration-300 inline-flex items-center justify-center" style="color: #0f766e; border: 2px solid #0f766e;" onmouseover="this.style.backgroundColor='#f0fdfa'" onmouseout="this.style.backgroundColor='white'"
                            <i class="fas fa-play-circle mr-2"></i>
                            <span>Watch Demo</span>
                        </a>
                    </div>
                    
                    <!-- Trust Indicators -->
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>No credit card required</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                            <span>30-day money back</span>
                        </div>
                    </div>
                </div>
                
                <!-- Right - Stats and Floating Profile Images -->
                <div class="relative h-[600px] block">
                    <!-- Stats Section at Top -->
                    <div class="absolute top-0 left-0 right-0 z-20">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white/90 backdrop-blur-sm rounded-2xl p-4 md:p-6 shadow-lg border border-gray-100">
                            <div class="text-center">
                                <div class="text-3xl md:text-2xl font-bold mb-1" style="color: #0f766e;">50K+</div>
                                <div class="text-sm md:text-xs text-gray-600 font-medium">Active Students</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl md:text-2xl font-bold mb-1" style="color: #0f766e;">1,200+</div>
                                <div class="text-sm md:text-xs text-gray-600 font-medium">Expert Courses</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl md:text-2xl font-bold mb-1" style="color: #0f766e;">98%</div>
                                <div class="text-sm md:text-xs text-gray-600 font-medium">Success Rate</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Main Large Profile - Center
                    <div class="absolute top-32 md:top-24 left-1/2 transform -translate-x-1/2 profile-float-1">
                        <div class="relative">
                            <img src="" alt="Student" class="w-32 md:w-40 h-32 md:h-40 rounded-3xl shadow-2xl border-4 border-white">
                            <div class="absolute -top-3 -right-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-lg badge-pulse">⭐ Top Student</div>
                        </div>
                    </div>
                    
                     Profile Image 2 - Top Left -->
                    <!-- <div class="absolute top-40 md:top-32 left-2 md:left-4 profile-float-2">
                        <div class="relative">
                            <img src="" alt="Student" class="w-24 md:w-28 h-24 md:h-28 rounded-2xl shadow-xl border-4 border-white">
                            <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-xs px-2 py-1 rounded-full font-semibold">Dr. Smith</div>
                        </div>
                    </div> -->
                    
                    <!-- Profile Image 3 - Top Right -->
                    <!-- <div class="absolute top-48 md:top-40 right-0 profile-float-3">
                        <div class="relative">
                            <img src="" alt="Student" class="w-28 md:w-32 h-28 md:h-32 rounded-3xl shadow-xl border-4 border-white">
                            <div class="absolute -top-2 -left-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs px-2 py-1 rounded-full font-semibold badge-pulse">🏆 Honor Roll</div>
                        </div>
                    </div> -->
                    
                    <!-- Profile Image 4 - Bottom Left -->
                    <!-- <div class="absolute bottom-24 md:bottom-16 left-4 md:left-8 profile-float-4">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/150?img=15" alt="Student" class="w-28 md:w-32 h-28 md:h-32 rounded-2xl shadow-xl border-4 border-white">
                            <div class="absolute -top-2 -right-2 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">New Grad</div>
                        </div>
                    </div> -->
                    
                    <!-- Profile Image 5 - Bottom Right -->
                    <!-- <div class="absolute bottom-16 md:bottom-8 right-4 md:right-8 profile-float-1" style="animation-delay: 2s;">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/170?img=22" alt="Student" class="w-32 md:w-36 h-32 md:h-36 rounded-3xl shadow-xl border-4 border-white">
                            <div class="absolute -bottom-2 -left-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs px-2 py-1 rounded-full font-semibold">Certified</div>
                        </div>
                    </div> -->
                    
                    <!-- Profile Image 6 - Middle Right -->
                    <!-- <div class="absolute top-72 md:top-64 right-2 md:right-4 profile-float-2" style="animation-delay: 1.5s;">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/130?img=35" alt="Student" class="w-20 md:w-24 h-20 md:h-24 rounded-xl shadow-lg border-4 border-white">
                            <div class="absolute -top-1 -right-1 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs px-2 py-1 rounded-full font-semibold">⭐</div>
                        </div>
                    </div> -->
                    
                    <!-- Decorative Elements -->
                    <div class="absolute top-48 right-32 w-20 h-20 bg-cyan-100 rounded-full opacity-20 blur-xl animate-pulse"></div>
                    <div class="absolute bottom-40 left-16 w-24 h-24 bg-teal-100 rounded-full opacity-20 blur-xl animate-pulse" style="animation-delay: 1s;"></div>
                    <div class="absolute top-80 left-32 w-16 h-16 bg-emerald-100 rounded-full opacity-20 blur-xl animate-pulse" style="animation-delay: 2s;"></div>
                    
                    <!-- Floating Achievement Badges -->
                    <div class="absolute top-20 left-1/4 w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 0.5s;">
                        <i class="fas fa-graduation-cap text-white text-xs"></i>
                    </div>
                    <div class="absolute bottom-32 right-1/4 w-8 h-8 bg-green-400 rounded-full flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 1s;">
                        <i class="fas fa-award text-white text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Background Decorative Circles -->
        <div class="absolute top-20 right-10 w-96 h-96 bg-cyan-50 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-teal-50 rounded-full opacity-10 blur-3xl"></div>
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
    <section class="py-20 px-4" style="background: linear-gradient(to bottom right, #f8fafc, #f1f5f9);">
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
    <section class="py-20 px-4 text-white" style="background: linear-gradient(135deg, #0f766e, #0891b2);">
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
    <footer class="text-white py-12 px-4" style="background: #134e4a;">
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


</body>
</html>
