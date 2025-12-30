<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Medical Education Platform</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        .montserrat {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Header Styling */
        .site-header {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #e5e7eb;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .cpd-badge {
            background: white;
            border-radius: 8px;
            padding: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .social-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .social-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            transition: transform 0.3s;
        }
        
        .social-icon:hover {
            transform: translateY(-2px);
        }
        
        .partner-logo {
            height: 30px;
            object-fit: contain;
            opacity: 0.9;
            transition: opacity 0.3s;
        }
        
        .partner-logo:hover {
            opacity: 1;
        }
        
        .nav-button {
            background: transparent;
            color: #374151;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .nav-button:hover {
            color: #2563EB;
            background: #f3f4f6;
        }
        
        .dropdown-menu {
            position: relative;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            top: calc(100% + 0.25rem);
            right: 0;
            background: white;
            min-width: 220px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 0.5rem 0;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
            pointer-events: none;
        }
        
        .dropdown-menu:hover .dropdown-content,
        .group:hover .dropdown-content {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.75rem 1.5rem;
            color: #333;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .dropdown-item:hover {
            background: #f3f4f6;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
            color: white;
            padding: 4rem 2rem;
            padding-top: 6rem;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin-top: 64px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.5;
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 0 2rem;
        }
        
        .hero-illustration {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        
        .search-box {
            background: white;
            border-radius: 50px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 2rem;
        }
        
        .search-box input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            outline: none;
            font-size: 1rem;
            color: #333;
        }
        
        .search-box input::placeholder {
            color: #9ca3af;
        }
        
        .search-box button {
            background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
            border: none;
            padding: 1rem 2.5rem;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1.2rem;
        }
        
        .search-box button:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #4f46e5 100%);
        }
        
        .floating-icon {
            position: absolute;
            background: white;
            border-radius: 12px;
            padding: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .icon-1 { top: 10%; left: 5%; animation-delay: 0s; }
        .icon-2 { top: 20%; right: 10%; animation-delay: 0.5s; }
        .icon-3 { bottom: 20%; left: 10%; animation-delay: 1s; }
        .icon-4 { top: 50%; left: 0%; animation-delay: 1.5s; }
        
        /* Statistics Section */
        .stats-section {
            background: #f9fafb;
            padding: 5rem 2rem;
        }
        
        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }
        
        .stat-card {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-icon-wrapper {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            border: 3px solid #d1d5db;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover .stat-icon-wrapper {
            border-color: #6366f1;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .stat-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 1rem;
        }
        
        .stat-description {
            color: #6b7280;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        /* Specialties Section */
        .specialties-section {
            background: #f3f4f6;
            padding: 5rem 2rem;
        }
        
        .specialties-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .specialties-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 1rem;
        }
        
        .specialties-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1.5rem;
        }
        
        .specialty-card {
            background: white;
            border-radius: 12px;
            padding: 2.5rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .specialty-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: #6366f1;
        }
        
        .specialty-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .specialty-icon i {
            font-size: 3rem;
            color: #374151;
        }
        
        .specialty-name {
            font-size: 1.05rem;
            font-weight: 500;
            color: #4b5563;
            line-height: 1.4;
        }
        
        /* Popular Courses Section */
        .popular-courses-section {
            background: white;
            padding: 5rem 2rem;
        }
        
        .popular-courses-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }
        
        .popular-courses-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #4b5563;
        }
        
        .popular-courses-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
        
        .popular-course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .popular-course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .popular-course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .popular-course-content {
            padding: 1.5rem;
        }
        
        .popular-course-title {
            font-size: 1.05rem;
            font-weight: 500;
            color: #374151;
            line-height: 1.5;
            margin-bottom: 1rem;
            min-height: 3rem;
        }
        
        .popular-course-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .popular-course-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .rating-stars {
            display: flex;
            gap: 0.15rem;
        }
        
        .rating-stars i {
            color: #fbbf24;
            font-size: 1rem;
        }
        
        .rating-count {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .course-free-badge {
            background: #f3f4f6;
            color: #4b5563;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        @media (max-width: 1200px) {
            .specialties-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            .popular-courses-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 968px) {
            .stats-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .specialties-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .popular-courses-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .hero-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .hero-illustration {
                order: -1;
                height: 250px;
            }
            .floating-icon {
                display: none;
            }
        }
        
        @media (max-width: 640px) {
            .specialties-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .specialties-title, .popular-courses-title {
                font-size: 1.75rem;
            }
            .popular-courses-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Course Card Styling */
        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }
        
        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .btn-primary {
            background: #2563EB;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
        }
        
        /* Footer Styling */
        .site-footer {
            background: #1f2937;
            color: white;
            padding: 3rem 2rem 1rem;
        }
        
        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-desktop {
                display: none;
            }
            
            .hero-section {
                padding: 4rem 1rem;
            }
        }
        
        @media (min-width: 769px) {
            .nav-mobile {
                display: none;
            }
        }
        
        /* Animation */
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
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-lg shadow-sm border-b border-gray-100 z-50">
        <div class="w-full px-6 lg:px-12">
            <div class="flex items-center justify-between h-16">
                <!-- Left Side: Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
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
                
                <!-- Center: Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ url('/') }}" class="px-4 py-2 text-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Home</a>
                    <a href="{{ route('courses.index') }}" class="px-4 py-2 text-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 text-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 text-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Contact</a>
                </nav>
                
                <!-- Right Side: Auth Links -->
                <div class="flex items-center space-x-2">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative">
                            <button onclick="toggleUserDropdown()" class="flex items-center space-x-2 px-4 py-2 md:px-6 md:py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-base rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50">
                                <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors">
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
                                <form action="{{ route('logout') }}" method="POST" class="inline w-full">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 md:px-6 md:py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-base rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02] whitespace-nowrap">Login/Register</a>
                    @endauth
                    
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
                <a href="{{ url('/') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Home</a>
                <a href="{{ route('courses.index') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                <a href="{{ route('about') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                <a href="{{ route('contact') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Contact</a>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero-section relative z-10">
        <div class="hero-content relative z-10">
            <!-- Left Side - Illustration -->
            <div class="hero-illustration">
                <svg width="100%" height="350" viewBox="0 0 500 350" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Healthcare Professionals Illustration -->
                    <circle cx="150" cy="120" r="30" fill="#60A5FA"/>
                    <rect x="130" y="150" width="40" height="60" rx="5" fill="#3B82F6"/>
                    <circle cx="150" cy="105" r="5" fill="#1E40AF"/>
                    
                    <circle cx="250" cy="140" r="35" fill="#FCD34D"/>
                    <rect x="225" y="175" width="50" height="70" rx="5" fill="#F59E0B"/>
                    <circle cx="250" cy="123" r="6" fill="#B45309"/>
                    
                    <circle cx="350" cy="130" r="32" fill="#34D399"/>
                    <rect x="328" y="162" width="44" height="65" rx="5" fill="#10B981"/>
                    <circle cx="350" cy="115" r="5" fill="#065F46"/>
                    
                    <rect x="50" y="80" width="50" height="35" rx="8" fill="white" opacity="0.9"/>
                    <circle cx="75" cy="97" r="8" fill="#3B82F6"/>
                    
                    <rect x="400" y="60" width="50" height="35" rx="8" fill="white" opacity="0.9"/>
                    <path d="M420 75 L425 85 L430 75" stroke="#F59E0B" stroke-width="3" fill="none"/>
                    
                    <rect x="80" y="220" width="45" height="35" rx="8" fill="white" opacity="0.9"/>
                    <circle cx="102" cy="238" r="6" fill="#10B981"/>
                    
                    <rect x="380" y="180" width="60" height="45" rx="5" fill="white" opacity="0.95"/>
                    <rect x="385" y="185" width="50" height="30" rx="2" fill="#60A5FA"/>
                    
                    <circle cx="450" cy="120" r="20" fill="white" opacity="0.9"/>
                    <rect x="445" y="110" width="10" height="20" fill="#EF4444"/>
                    <rect x="440" y="115" width="20" height="10" fill="#EF4444"/>
                </svg>
                
                <div class="floating-icon icon-1">
                    <i class="fas fa-laptop text-blue-600 text-xl"></i>
                </div>
                <div class="floating-icon icon-2">
                    <i class="fas fa-trophy text-yellow-500 text-xl"></i>
                </div>
                <div class="floating-icon icon-3">
                    <i class="fas fa-tasks text-green-500 text-xl"></i>
                </div>
                <div class="floating-icon icon-4">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
            </div>
            
            <!-- Right Side - Content -->
            <div class="hero-text">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 fade-in-up montserrat leading-tight">
                    Discover the best online learning for healthcare professionals
                </h1>
                
                <form action="{{ route('courses.index') }}" method="GET" class="search-box">
                    <input type="text" name="search" placeholder="What do you want to learn about?" class="flex-1">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <div class="grid grid-cols-3 gap-4 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold">500+</div>
                        <div class="text-sm opacity-90">Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">50K+</div>
                        <div class="text-sm opacity-90">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">200+</div>
                        <div class="text-sm opacity-90">Experts</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon-wrapper">
                    <svg class="stat-icon" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="60" cy="35" r="12" fill="#F59E0B" stroke="#F59E0B" stroke-width="2"/>
                        <path d="M60 50 C50 50, 45 55, 45 65 L75 65 C75 55, 70 50, 60 50 Z" fill="#F59E0B"/>
                        
                        <circle cx="35" cy="40" r="10" fill="#3B82F6" stroke="#3B82F6" stroke-width="2"/>
                        <path d="M35 52 C27 52, 23 56, 23 64 L47 64 C47 56, 43 52, 35 52 Z" fill="#3B82F6"/>
                        
                        <circle cx="85" cy="40" r="10" fill="#10B981" stroke="#10B981" stroke-width="2"/>
                        <path d="M85 52 C77 52, 73 56, 73 64 L97 64 C97 56, 93 52, 85 52 Z" fill="#10B981"/>
                    </svg>
                </div>
                <div class="stat-number">1m learners</div>
                <p class="stat-description">
                    Join our community of Healthcare Professionals who have improved their knowledge with our online learning platform.
                </p>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon-wrapper">
                    <svg class="stat-icon" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="25" y="35" width="50" height="40" rx="8" fill="#60A5FA" stroke="#3B82F6" stroke-width="2"/>
                        <line x1="35" y1="45" x2="60" y2="45" stroke="white" stroke-width="3" stroke-linecap="round"/>
                        <line x1="35" y1="55" x2="55" y2="55" stroke="white" stroke-width="3" stroke-linecap="round"/>
                        <line x1="35" y1="65" x2="60" y2="65" stroke="white" stroke-width="3" stroke-linecap="round"/>
                        
                        <rect x="45" y="50" width="50" height="40" rx="8" fill="#93C5FD" stroke="#3B82F6" stroke-width="2"/>
                        <line x1="55" y1="60" x2="80" y2="60" stroke="white" stroke-width="3" stroke-linecap="round"/>
                        <line x1="55" y1="70" x2="75" y2="70" stroke="white" stroke-width="3" stroke-linecap="round"/>
                        <line x1="55" y1="80" x2="80" y2="80" stroke="white" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="stat-number">900+ courses</div>
                <p class="stat-description">
                    Get unlimited access to evidence-based courses that are continuously updated based on the latest guidance.
                </p>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon-wrapper">
                    <svg class="stat-icon" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M35 30 L35 45 C35 55, 45 60, 60 60 C75 60, 85 55, 85 45 L85 30 Z" fill="#FBBF24" stroke="#F59E0B" stroke-width="2"/>
                        <rect x="45" y="25" width="30" height="10" fill="#F59E0B"/>
                        <path d="M55 60 L55 75 L65 75 L65 60" fill="#FBBF24" stroke="#F59E0B" stroke-width="2"/>
                        <rect x="50" y="75" width="20" height="8" rx="2" fill="#F59E0B"/>
                        
                        <polygon points="60,35 63,43 71,43 65,48 67,56 60,51 53,56 55,48 49,43 57,43" fill="#FDE68A"/>
                        
                        <path d="M35 35 C25 35, 20 40, 20 45 C20 50, 25 53, 30 53" stroke="#F59E0B" stroke-width="2" fill="none"/>
                        <path d="M85 35 C95 35, 100 40, 100 45 C100 50, 95 53, 90 53" stroke="#F59E0B" stroke-width="2" fill="none"/>
                    </svg>
                </div>
                <div class="stat-number">6m CPD points</div>
                <p class="stat-description">
                    Have been claimed through our platform. All courses are accredited and recognised by leading professional bodies.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Browse Popular Specialties Section -->
    <section class="specialties-section">
        <div class="specialties-header">
            <h2 class="specialties-title">Browse popular specialties</h2>
        </div>
        
        <div class="specialties-grid">
            @forelse($categories as $category)
            <a href="{{ route('courses.index') }}?category={{ $category->id }}" class="specialty-card">
                <div class="specialty-icon">
                    <i class="fas {{ $category->icon_class }}" style="font-size: 2.5rem; color: #4B5563;"></i>
                </div>
                <div class="specialty-name">{{ $category->name }}</div>
            </a>
            @empty
            <div class="col-span-full text-center text-gray-500 py-8">
                No specialties available at the moment.
            </div>
            @endforelse
        </div>
    </section>
    
    <!-- Most Popular Courses Section -->
    <section class="popular-courses-section">
        <div class="popular-courses-header">
            <h2 class="popular-courses-title">Most popular courses</h2>
        </div>
        
        <div class="popular-courses-grid">
            <a href="{{ route('courses.index') }}" class="popular-course-card">
                <img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=400&h=250&fit=crop" alt="Hyponatraemia Course" class="popular-course-image">
                <div class="popular-course-content">
                    <h3 class="popular-course-title">Reducing the risk of hyponatraemia when administering intravenous fluids to children</h3>
                    <div class="popular-course-footer">
                        <div class="popular-course-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-count">(2,982)</span>
                        </div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('courses.index') }}" class="popular-course-card">
                <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=400&h=250&fit=crop" alt="Heart Failure Diagnosis" class="popular-course-image">
                <div class="popular-course-content">
                    <h3 class="popular-course-title">Step by step: A guide to diagnosing heart failure</h3>
                    <div class="popular-course-footer">
                        <div class="popular-course-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(1,294)</span>
                        </div>
                        <span class="course-free-badge">FREE</span>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('courses.index') }}" class="popular-course-card">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=250&fit=crop" alt="Pain Assessment" class="popular-course-image">
                <div class="popular-course-content">
                    <h3 class="popular-course-title">Assessing pain and using the analgesic ladder</h3>
                    <div class="popular-course-footer">
                        <div class="popular-course-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(1,164)</span>
                        </div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('courses.index') }}" class="popular-course-card">
                <img src="https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=400&h=250&fit=crop" alt="Hyponatraemia Principles" class="popular-course-image">
                <div class="popular-course-content">
                    <h3 class="popular-course-title">Hyponatraemia: basic principles, types and causes</h3>
                    <div class="popular-course-footer">
                        <div class="popular-course-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(1,340)</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 montserrat">Why Choose Us</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-video text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 montserrat">Live Interactive Classes</h3>
                    <p class="text-gray-600">Engage with expert instructors in real-time through our interactive virtual classrooms</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book-open text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 montserrat">Comprehensive Courses</h3>
                    <p class="text-gray-600">Access a wide range of medical specializations and certification programs</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 montserrat">Certifications & Support</h3>
                    <p class="text-gray-600">Earn globally recognized certifications with continuous learning support</p>
                </div>
            </div>
        </div>
    </section>
    


    <!-- Plans Section -->
    <section id="plans" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium mb-3">
                    Choose Your Plan
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-3">
                    Flexible Plans for Instructors
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Select the perfect plan to start teaching. All plans include course creation tools, analytics dashboard, and instructor support.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 max-w-7xl mx-auto">
                @forelse($subscriptionPlans as $index => $plan)
                    @php
                        $isPopular = $index === 1; // Middle plan is most popular
                        $isFree = $plan->price == 0;
                    @endphp
                    <div class="w-full max-w-sm bg-white border-2 {{ $isPopular ? 'border-blue-600 shadow-2xl transform scale-105' : 'border-gray-200 shadow-lg' }} rounded-xl p-8 relative hover:shadow-xl transition-all flex flex-col min-h-[550px]">
                        @if($isPopular)
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-1.5 rounded-full text-sm font-semibold">
                                    Most Popular
                                </span>
                            </div>
                        @endif

                        <div class="text-center mb-5">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $plan->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $plan->description ?? 'Perfect for instructors' }}</p>
                        </div>

                        <div class="text-center mb-6">
                            <div class="mb-4">
                                @if($isFree)
                                    <div class="text-4xl font-bold text-gray-900">Free</div>
                                    <div class="text-gray-600 text-sm">forever</div>
                                @else
                                    <div class="text-4xl font-bold text-gray-900">₹{{ number_format($plan->price, 0) }}</div>
                                    <div class="text-gray-600 text-sm">per month</div>
                                    @php
                                        $yearlyPrice = $plan->price * 12 * 0.83; // 17% discount
                                    @endphp
                                    <div class="text-sm text-gray-600 mt-2">
                                        or ₹{{ number_format($yearlyPrice, 0) }}/year
                                        <span class="text-green-600 font-semibold">(Save 17%)</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="text-center mb-5 pb-5 border-b border-gray-200">
                            <div class="text-3xl font-bold text-blue-600">
                                {{ $plan->max_courses == -1 || $plan->max_courses > 100 ? 'Unlimited' : $plan->max_courses }}
                            </div>
                            <div class="text-gray-600 text-sm">Active Courses</div>
                        </div>

                        <ul class="space-y-4 mb-6 flex-grow">
                            @if(is_array($plan->features))
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700 text-base">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @endif
                            @if($plan->max_students)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700 text-base">
                                        {{ $plan->max_students == -1 ? 'Unlimited students' : 'Up to ' . number_format($plan->max_students) . ' students' }}
                                    </span>
                                </li>
                            @endif
                        </ul>

                        <a href="{{ route('register') }}" 
                            class="block w-full text-center {{ $isPopular ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:from-blue-700 hover:to-purple-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }} px-6 py-3.5 rounded-lg font-semibold transition-all transform hover:scale-105 mt-auto">
                            Get Started
                        </a>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        <p>No subscription plans available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-600 text-sm mb-3">All plans include:</p>
                <div class="flex flex-wrap justify-center gap-4 text-xs text-gray-700">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Course Creation Tools
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Student Management
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Revenue Tracking
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Instructor Community
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Join as Professional Section -->
    <section class="py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Become an Instructor
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Share your medical expertise with thousands of eager learners. Join our teaching community and make an impact.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Doctor/Instructor Registration -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:-translate-y-2 flex flex-col min-h-[480px]">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-8 text-white">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-5 mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-center">Join as Instructor</h3>
                    </div>
                    <div class="p-10 flex flex-col flex-grow">
                        <ul class="space-y-5 mb-10 flex-grow">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Reach thousands of students nationwide</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Flexible teaching hours</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Share your medical expertise</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" 
                           class="block w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white text-center font-semibold py-4 rounded-lg hover:from-blue-600 hover:to-blue-800 transition-all mt-auto">
                            Apply Now
                        </a>
                    </div>
                </div>

                <!-- Agency Registration -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:-translate-y-2 flex flex-col min-h-[480px]">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-700 p-8 text-white">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-5 mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-center">Join as Institution</h3>
                    </div>
                    <div class="p-10 flex flex-col flex-grow">
                        <ul class="space-y-5 mb-10 flex-grow">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Manage multiple instructors</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Expand your digital presence</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Centralized dashboard</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" 
                           class="block w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white text-center font-semibold py-4 rounded-lg hover:from-purple-600 hover:to-purple-800 transition-all mt-auto">
                            Apply Now
                        </a>
                    </div>
                </div>

                <!-- Hospital/Provider Registration -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all transform hover:-translate-y-2 flex flex-col min-h-[480px]">
                    <div class="bg-gradient-to-r from-green-500 to-green-700 p-8 text-white">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-5 mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-center">Join as Hospital</h3>
                    </div>
                    <div class="p-10 flex flex-col flex-grow">
                        <ul class="space-y-5 mb-10 flex-grow">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Register your hospital/clinic</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Host medical training programs</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Partner for medical education</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" 
                           class="block w-full bg-gradient-to-r from-green-500 to-green-700 text-white text-center font-semibold py-4 rounded-lg hover:from-green-600 hover:to-green-800 transition-all mt-auto">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Get Started for Free Section -->
    <section class="py-20 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Left Content -->
                <div class="lg:w-1/2 text-white">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">Get started</h2>
                    <p class="text-lg md:text-xl mb-8 text-gray-200 leading-relaxed">
                        Empower your healthcare career today, sign up for a free account to access some of our most popular courses.
                    </p>
                    <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Create account
                    </a>
                </div>
                
                <!-- Right Illustration -->
                <div class="lg:w-1/2 flex justify-center">
                    <svg width="520" height="280" viewBox="0 0 520 280" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Floating Certificate Icon (top left) -->
                        <g transform="translate(30, 20)">
                            <rect x="0" y="0" width="70" height="60" rx="6" fill="#234D6E" stroke="#3B5F7D" stroke-width="2"/>
                            <rect x="8" y="8" width="54" height="35" rx="3" fill="#10B981"/>
                            <circle cx="35" cy="25" r="8" fill="white" opacity="0.9"/>
                            <path d="M35 20 L35 30 M30 25 L40 25" stroke="#10B981" stroke-width="2.5" stroke-linecap="round"/>
                            <rect x="12" y="48" width="46" height="3" rx="1.5" fill="#3B5F7D"/>
                        </g>
                        
                        <!-- Floating PPE Icon (left middle) -->
                        <g transform="translate(15, 115)">
                            <rect x="0" y="0" width="55" height="65" rx="6" fill="#234D6E" stroke="#3B5F7D" stroke-width="2"/>
                            <rect x="12" y="10" width="30" height="40" rx="15" fill="#F59E0B"/>
                            <circle cx="27" cy="20" r="5" fill="white" opacity="0.8"/>
                            <rect x="17" y="35" width="20" height="20" rx="4" fill="white" opacity="0.6"/>
                        </g>
                        
                        <!-- Computer Monitor -->
                        <rect x="200" y="100" width="260" height="155" rx="10" fill="white" stroke="#D1D5DB" stroke-width="4"/>
                        <rect x="215" y="115" width="230" height="120" rx="6" fill="#F3F4F6"/>
                        
                        <!-- Screen Content - Certificate -->
                        <circle cx="330" cy="165" r="25" fill="#10B981" opacity="0.15"/>
                        <circle cx="330" cy="165" r="28" stroke="#10B981" stroke-width="3" fill="none"/>
                        <path d="M330 150 L330 180 M315 165 L345 165" stroke="#10B981" stroke-width="4" stroke-linecap="round"/>
                        
                        <!-- Monitor Stand -->
                        <rect x="305" y="255" width="50" height="10" rx="3" fill="#9CA3AF"/>
                        <rect x="318" y="245" width="24" height="15" fill="#D1D5DB"/>
                        
                        <!-- Healthcare Professional -->
                        <!-- Head/Face -->
                        <circle cx="180" cy="150" r="35" fill="#8B6F47"/>
                        
                        <!-- White Hair (sides) -->
                        <ellipse cx="155" cy="145" rx="12" ry="18" fill="#E5E7EB"/>
                        <ellipse cx="205" cy="145" rx="12" ry="18" fill="#E5E7EB"/>
                        
                        <!-- Top of head/forehead -->
                        <ellipse cx="180" cy="125" rx="30" ry="20" fill="#8B6F47"/>
                        
                        <!-- Glasses Frame -->
                        <circle cx="170" cy="150" r="10" fill="none" stroke="#D97706" stroke-width="3"/>
                        <circle cx="190" cy="150" r="10" fill="none" stroke="#D97706" stroke-width="3"/>
                        <line x1="180" y1="150" x2="180" y2="150" stroke="#D97706" stroke-width="3"/>
                        <path d="M160 148 L155 145" stroke="#D97706" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M200 148 L205 145" stroke="#D97706" stroke-width="2.5" stroke-linecap="round"/>
                        
                        <!-- Eyes behind glasses -->
                        <circle cx="170" cy="150" r="4" fill="#1F2937"/>
                        <circle cx="190" cy="150" r="4" fill="#1F2937"/>
                        <circle cx="171" cy="149" r="1.5" fill="white"/>
                        <circle cx="191" cy="149" r="1.5" fill="white"/>
                        
                        <!-- Smile -->
                        <path d="M170 165 Q180 170 190 165" stroke="#5D4E37" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        
                        <!-- Body - Blue Scrubs -->
                        <path d="M145 185 L145 270 L215 270 L215 185 Q215 180 210 178 L180 175 L150 178 Q145 180 145 185 Z" fill="#1E40AF"/>
                        
                        <!-- Lanyard -->
                        <rect x="175" y="185" width="10" height="15" fill="#1E40AF"/>
                        
                        <!-- Medical Badge -->
                        <rect x="170" y="200" width="28" height="35" rx="3" fill="white" stroke="#D1D5DB" stroke-width="2"/>
                        <rect x="176" y="206" width="16" height="12" rx="2" fill="#EF4444"/>
                        <path d="M184 210 L184 214 M182 212 L186 212" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <rect x="174" y="222" width="20" height="2" rx="1" fill="#9CA3AF"/>
                        <rect x="174" y="227" width="16" height="2" rx="1" fill="#9CA3AF"/>
                        
                        <!-- Arms -->
                        <rect x="125" y="190" width="22" height="60" rx="11" fill="#1E40AF"/>
                        <rect x="213" y="190" width="22" height="60" rx="11" fill="#1E40AF"/>
                        
                        <!-- Hands -->
                        <ellipse cx="137" cy="250" rx="11" ry="9" fill="#A67C52"/>
                        <ellipse cx="223" cy="250" rx="11" ry="9" fill="#A67C52"/>
                        
                        <!-- Keyboard Area -->
                        <rect x="130" y="255" width="100" height="8" rx="3" fill="#4B5563" opacity="0.6"/>
                        <rect x="135" y="258" width="8" height="3" rx="1" fill="#9CA3AF" opacity="0.8"/>
                        <rect x="146" y="258" width="8" height="3" rx="1" fill="#9CA3AF" opacity="0.8"/>
                        <rect x="157" y="258" width="8" height="3" rx="1" fill="#9CA3AF" opacity="0.8"/>
                        <rect x="168" y="258" width="8" height="3" rx="1" fill="#9CA3AF" opacity="0.8"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="site-footer">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 montserrat">{{ config('app.name') }}</h3>
                    <p class="text-gray-400 mb-4">Empowering medical professionals through quality education and training</p>
                    <div class="flex gap-3">
                        <a href="#" class="social-icon bg-gray-700 hover:bg-blue-600">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="social-icon bg-gray-700 hover:bg-pink-600">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="social-icon bg-gray-700 hover:bg-red-600">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                        <a href="#" class="social-icon bg-gray-700 hover:bg-blue-700">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="footer-links">
                    <h4 class="text-lg font-semibold mb-4 montserrat">Platform</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('courses.index') }}">Browse Courses</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="#faculty">Our Faculty</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Specializations -->
                <div class="footer-links">
                    <h4 class="text-lg font-semibold mb-4 montserrat">Specializations</h4>
                    <ul class="space-y-2">
                        <li><a href="#">Aesthetic Medicine</a></li>
                        <li><a href="#">Aesthetic Gynecology</a></li>
                        <li><a href="#">Ultrasound</a></li>
                        <li><a href="#">IVF & Reproductive Medicine</a></li>
                        <li><a href="#">Surgical Courses</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 montserrat">Contact Us</h4>
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
    
    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
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
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add scroll effect to header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.site-header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.2)';
            } else {
                header.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>
