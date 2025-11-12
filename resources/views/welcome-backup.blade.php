<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paathshaala - Learn With The Best Online Medical School</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            overflow-x: hidden;
        }
        
        .floating-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }
        
        .floating-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Professional Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center group">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg p-2 mr-3 group-hover:shadow-lg transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">Paathshaala</h1>
                        <p class="text-xs text-gray-500 font-medium">Healthcare Education Platform</p>
                    </div>
                </a>
                
                <!-- All Navigation & Actions on Right Side -->
                <div class="flex items-center space-x-6">
                    <!-- Navigation Links -->
                    <div class="hidden sm:flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="relative text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 group">
                            Home
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('courses.index') }}" class="relative text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 group">
                            Courses
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('about') }}" class="relative text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 group">
                            About
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('contact') }}" class="relative text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 group">
                            Contact
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        
                        <!-- Auth Buttons integrated with navigation -->
                        @auth
                            <!-- Direct Auth Buttons - No Dropdown -->
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 border border-gray-300 rounded-full hover:border-indigo-600 hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 border border-gray-300 rounded-full hover:border-indigo-600 hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center space-x-1 text-red-600 hover:text-red-700 px-3 py-2 text-sm font-semibold transition-all duration-300 border border-red-300 rounded-full hover:border-red-600 hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        @else
                            <!-- Guest User Actions -->
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold transition-all duration-300 border border-gray-300 rounded-full hover:border-indigo-600 hover:shadow-md">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Register
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="sm:hidden">
                        <button class="text-gray-700 hover:text-indigo-600 p-2" onclick="toggleMobileMenu()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                    <!-- Mobile Menu Button -->
                    <div class="sm:hidden">
                        <button class="text-gray-700 hover:text-indigo-600 p-2" onclick="toggleMobileMenu()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="sm:hidden hidden border-t border-gray-200 py-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold">Home</a>
                    <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold">Courses</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold">Contact</a>
                    <hr class="border-gray-200">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 px-3 py-2 text-sm font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 px-3 py-2 text-sm font-semibold text-left w-full flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-semibold border border-gray-300 rounded-md mx-3 text-center">Sign In</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 text-center mx-3">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

    <!-- Professional Hero Section -->
    <div class="relative pt-24 pb-6 w-full" 
     style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 30%, #06b6d4 70%, #10b981 100%) !important; position: relative; overflow: hidden; max-width: 100vw; margin-top: 80px;">
        
        <!-- Main Content -->
        <div class="flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-8 relative z-20 w-full">
                <div class="grid lg:grid-cols-2 gap-8 items-center">
                    <!-- Left Content -->
                    <div class="text-left lg:text-left order-2 lg:order-1">
                        <div class="inline-flex items-center px-2 py-0.5 bg-white/10 backdrop-blur-sm rounded-full text-white text-xs font-medium mb-3">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            #1 Healthcare Education Platform
                        </div>
                        
                        <h1 class="text-lg lg:text-2xl xl:text-3xl font-bold text-white mb-2 leading-tight">
                            Master 
                            <span style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Healthcare</span>
                            <br>& Medical Sciences
                        </h1>
                        
                        <p class="text-xs lg:text-sm text-blue-100 mb-3 leading-relaxed font-light max-w-xl">
                            Join <span class="font-semibold text-white">25,000+</span> students learning from expert healthcare professionals. Build your career with our comprehensive medical education platform.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-2 mb-3">
                            <a href="{{ route('courses.index') }}" class="group inline-flex items-center justify-center px-3 py-1.5 bg-white text-blue-900 rounded-md font-medium hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg text-xs">
                                <svg class="w-3 h-3 mr-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                Explore Courses
                            </a>
                            <a href="{{ route('register') }}" class="group inline-flex items-center justify-center px-3 py-1.5 bg-transparent border-2 border-white text-white rounded-md font-medium hover:bg-white hover:text-blue-900 transition-all duration-300 transform hover:scale-105 text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Start Learning
                            </a>
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="flex items-center space-x-3 text-blue-100">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs font-medium">4.9/5 Rating</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-green-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-xs font-medium">Certified Courses</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-blue-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                                <span class="text-xs font-medium">Expert Faculty</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Visual -->
                    <div class="order-1 lg:order-2 relative overflow-hidden">
                        <div class="relative overflow-hidden">
                            <!-- Main Card -->
                            <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2);" class="rounded-xl p-4 shadow-2xl">
                                <div class="text-center text-white">
                                    <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.84L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold mb-2">Premium Healthcare Education</h3>
                                    <p class="text-blue-100 mb-3 text-xs">Learn from industry experts with hands-on experience in healthcare management, clinical procedures, and medical diagnostics.</p>
                                    
                                    <!-- Mini Stats -->
                                    <div class="grid grid-cols-2 gap-3 text-center">
                                        <div class="bg-white/10 rounded-lg p-2">
                                            <div class="text-lg font-bold text-yellow-400">{{ $stats['total_courses'] }}+</div>
                                            <div class="text-xs text-blue-100">Courses</div>
                                        </div>
                                        <div class="bg-white/10 rounded-lg p-2">
                                            <div class="text-lg font-bold text-green-400">{{ $stats['total_students'] }}+</div>
                                            <div class="text-xs text-blue-100">Students</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Elements -->
                            <div style="position: absolute; top: -10px; right: -10px; width: 60px; height: 60px; background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); border-radius: 50%; opacity: 0.7; animation: pulse 4s infinite;"></div>
                            <div style="position: absolute; bottom: -15px; left: -15px; width: 50px; height: 50px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 50%; opacity: 0.5; animation: pulse 6s infinite;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Section -->
        <div class="bg-white/15 backdrop-blur-sm mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-lg font-bold text-white">{{ $stats['total_courses'] }}+</div>
                        <div class="text-xs text-indigo-100">Courses</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">{{ $stats['total_students'] }}+</div>
                        <div class="text-xs text-indigo-100">Students</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">{{ $stats['total_teachers'] }}+</div>
                        <div class="text-xs text-indigo-100">Expert Teachers</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">{{ $stats['total_enrollments'] }}+</div>
                        <div class="text-xs text-indigo-100">Enrollments</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Courses Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Featured Courses</h2>
                <p class="text-xl text-gray-600">Discover our most popular healthcare and medical courses</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredCourses as $course)
                <div class="bg-white rounded-xl overflow-hidden transition duration-500 transform hover:scale-105 hover:rotate-1" style="box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important; border: 1px solid rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(10px) !important;" onmouseover="this.style.boxShadow='0 30px 60px rgba(0, 0, 0, 0.2) !important'; this.style.transform='scale(1.05) rotate(1deg) translateY(-10px) !important'" onmouseout="this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.1) !important'; this.style.transform='scale(1) rotate(0deg) translateY(0px) !important'">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-4xl mb-2">🏥</div>
                            <div class="text-sm font-medium">{{ $course->category }}</div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $course->description }}</p>
                        
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr($course->teacher->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $course->teacher->name }}</p>
                                <p class="text-sm text-gray-500">Instructor</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">({{ $course->reviews_count }})</span>
                            </div>
                            <div class="text-2xl font-bold text-indigo-600">₹{{ number_format($course->price) }}</div>
                        </div>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $course->enrollments_count }} students</span>
                            <span>{{ $course->duration }} hours</span>
                        </div>
                        
                        <a href="{{ route('courses.show', $course->id) }}" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-300 text-center block">
                            View Course
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('courses.index') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                    View All Courses
                </a>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Why Choose Paathshaala?</h2>
                <p class="text-xl text-gray-600">We provide the best learning experience for healthcare professionals</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Expert Instructors</h3>
                    <p class="text-gray-600">Learn from experienced healthcare professionals and medical experts</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Interactive Learning</h3>
                    <p class="text-gray-600">Engage with interactive content, live classes, and practical exercises</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Certified Programs</h3>
                    <p class="text-gray-600">Earn industry-recognized certificates upon course completion</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visual Wave Separator -->
    <div class="py-8" style="background: linear-gradient(45deg, #667eea 0%, #764ba2 100%) !important; position: relative; overflow: hidden;">
        <div style="position: absolute; bottom: 0; left: -10%; right: -10%; height: 20px; background: white; border-radius: 50% 50% 0 0 / 100% 100% 0 0;"></div>
        <div class="text-center">
            <div style="width: 60px; height: 4px; background: rgba(255,255,255,0.8); margin: 0 auto; border-radius: 2px;"></div>
        </div>
    </div>

    <!-- Testimonials Section -->
    @if($testimonials->count() > 0)
    <div class="py-16" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%) !important; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.9) !important;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">What Our Students Say</h2>
                <p class="text-xl text-gray-600">Hear from our successful healthcare professionals</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials->take(3) as $testimonial)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        @for($i = 1; $i <= $testimonial->rating; $i++)
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-4 italic">"{{ $testimonial->comment }}"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium">{{ substr($testimonial->user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $testimonial->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $testimonial->course->title }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- CTA Section -->
    <div class="bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white mb-4">Ready to Start Your Learning Journey?</h2>
                <p class="text-xl text-indigo-100 mb-8">Join thousands of healthcare professionals advancing their careers</p>
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Get Started Today
                </a>
            </div>
        </div>
    </div>

    <!-- Simple Clean Footer -->
    <footer style="background-color: #000000 !important; background-image: none !important; color: #ffffff !important; padding: 6rem 0; margin: 0 !important; margin-bottom: 0 !important; position: relative; z-index: 10; min-height: 200px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-center space-y-6 lg:space-y-0">
                <!-- Footer Links -->
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-8">
                    <a href="{{ route('about') }}" style="color: #ffffff !important; font-weight: 600 !important;" class="hover:text-gray-300 transition-colors duration-200 text-base">
                        About Health Boat Paathshaala
                    </a>
                    <a href="{{ route('about') }}" style="color: #ffffff !important; font-weight: 600 !important;" class="hover:text-gray-300 transition-colors duration-200 text-base">
                        About Paathshaala
                    </a>
                    <div class="relative group">
                        <button style="color: #ffffff !important; font-weight: 600 !important;" class="hover:text-gray-300 transition-colors duration-200 text-base flex items-center">
                            Policy
                            <svg class="w-4 h-4 ml-1" style="color: #ffffff !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute bottom-full left-0 mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Privacy Policy</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Terms & Conditions</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Cookie Policy</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Refund Policy</a>
                        </div>
                    </div>
                </div>

                <!-- Social Media Icons -->
                <div class="flex items-center space-x-4">
                    <a href="#" style="color: #ffffff !important; border-color: #ffffff !important;" class="hover:text-gray-300 transition-colors duration-200 p-2 border hover:border-gray-300 rounded">
                        <svg class="w-5 h-5" style="color: #ffffff !important;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" style="color: #ffffff !important; border-color: #ffffff !important;" class="hover:text-gray-300 transition-colors duration-200 p-2 border hover:border-gray-300 rounded">
                        <svg class="w-5 h-5" style="color: #ffffff !important;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" style="color: #ffffff !important; border-color: #ffffff !important;" class="hover:text-gray-300 transition-colors duration-200 p-2 border hover:border-gray-300 rounded">
                        <svg class="w-5 h-5" style="color: #ffffff !important;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <a href="#" style="color: #ffffff !important; border-color: #ffffff !important;" class="hover:text-gray-300 transition-colors duration-200 p-2 border hover:border-gray-300 rounded">
                        <svg class="w-5 h-5" style="color: #ffffff !important;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.749.097.118.112.222.082.343-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.749-1.378 0 0-.593 2.25-.737 2.81-.267 1.018-.99 2.304-1.474 3.085C9.23 23.65 10.554 24 12.017 24c6.624 0 11.990-5.367 11.990-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-6 pt-2" style="border-top: 1px solid #555555; text-align: center;">
                <p style="color: #ffffff !important; font-weight: 600 !important; font-size: 1rem;">
                    Copyright © 2025 Health Boat Foundation. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
