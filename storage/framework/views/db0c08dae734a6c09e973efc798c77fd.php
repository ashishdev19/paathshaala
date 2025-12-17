<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?> - Medical Education Platform</title>
    
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
            background: #2563EB;
            color: white;
            padding: 6rem 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.5;
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
    <header class="site-header sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <!-- Top Bar with Logo, CPD Badge, Social Links -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <!-- Logo Section -->
                <div class="logo-container">
                    <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-blue-600 montserrat">
                                <?php echo e(config('app.name', 'Medniks')); ?>

                            </h1>
                            <p class="text-xs text-gray-500">Medical Excellence</p>
                        </div>
                    </a>
                </div>
                
                <!-- CPD Badge -->
                <!-- <div class="cpd-badge hidden md:block">
                    <p class="text-xs font-semibold text-blue-600 montserrat">CPD Provider No. 60107</p>
                    <a href="https://www.cpdstandards.com" target="_blank" class="text-xs text-blue-500 underline">www.cpdstandards.com</a>
                </div> -->
                
                <!-- Social Links -->
                <!-- <div class="social-links hidden md:flex">
                    <a href="https://www.facebook.com" target="_blank" class="social-icon" aria-label="Facebook">
                        <i class="fab fa-facebook-f text-blue-600"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="social-icon" aria-label="Instagram">
                        <i class="fab fa-instagram text-pink-600"></i>
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="social-icon" aria-label="YouTube">
                        <i class="fab fa-youtube text-red-600"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" class="social-icon" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in text-blue-700"></i>
                    </a>
                    <a href="https://www.twitter.com" target="_blank" class="social-icon" aria-label="Twitter">
                        <i class="fab fa-twitter text-blue-400"></i>
                    </a>
                </div> -->
                
                <!-- Partner Logos -->
                <!-- <div class="hidden lg:flex items-center gap-3">
                    <img src="https://via.placeholder.com/80x30?text=Partner1" alt="Partner 1" class="partner-logo">
                    <img src="https://via.placeholder.com/80x30?text=Partner2" alt="Partner 2" class="partner-logo">
                    <img src="https://via.placeholder.com/80x30?text=Partner3" alt="Partner 3" class="partner-logo">
                </div> -->
                
                <!-- Auth Section -->
                <div class="flex items-center gap-2">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="relative group">
                            <button class="nav-button flex items-center gap-2">
                                <i class="fas fa-user"></i>
                                <?php echo e(Auth::user()->name); ?>

                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="<?php echo e(route('dashboard')); ?>" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item w-full text-left">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">Login/Register</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Navigation Buttons (Desktop) -->
            <nav class="nav-desktop hidden md:flex flex-wrap items-center justify-center gap-3">
                <a href="<?php echo e(url('/')); ?>" class="nav-button">
                    <i class="fas fa-home mr-2"></i>HOME
                </a>
                
               
               <div class="nav-menu">
    <a href="<?php echo e(route('courses.index')); ?>" class="nav-button flex items-center gap-2">
        <i class="fas fa-book-medical mr-2"></i>
        COURSES
    </a>
</div>
                <!-- <div class="dropdown-menu">

                     <button class="nav-button flex items-center gap-2">
                        <i class="fas fa-book-medical mr-2"></i>COURSES
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="<?php echo e(route('courses.index')); ?>" class="dropdown-item">All Courses</a>
                        <a href="#" class="dropdown-item">Aesthetic Medicine</a>
                        <a href="#" class="dropdown-item">Aesthetic Gynecology</a>
                        <a href="#" class="dropdown-item">Ultrasound</a>
                        <a href="#" class="dropdown-item">IVF & Reproductive Medicine</a>
                        <a href="#" class="dropdown-item">Surgical Courses</a>
                    </div>
                </div> -->
                
                <a href="<?php echo e(route('about')); ?>" class="nav-button">
                    <i class="fas fa-info-circle mr-2"></i>ABOUT US
                </a>
                
                               
                               
                <a href="<?php echo e(route('contact')); ?>" class="nav-button">
                    <i class="fas fa-envelope mr-2"></i>CONTACT US
                </a>
                
            </nav>
            
            <!-- Mobile Menu Toggle -->
            <div class="nav-mobile md:hidden">
                <button onclick="toggleMobileMenu()" class="nav-button w-full">
                    <i class="fas fa-bars mr-2"></i>MENU
                </button>
                
                <!-- Mobile Menu -->
                <div id="mobileMenu" class="hidden mt-4 space-y-2">
                    <a href="<?php echo e(url('/')); ?>" class="nav-button block w-full text-center">HOME</a>
                    <a href="<?php echo e(route('courses.index')); ?>" class="nav-button block w-full text-center">COURSES</a>
                    <a href="<?php echo e(route('about')); ?>" class="nav-button block w-full text-center">ABOUT US</a>
                    <a href="#faculty" class="nav-button block w-full text-center">FACULTY</a>
                    <a href="#gallery" class="nav-button block w-full text-center">GALLERY</a>
                    <a href="<?php echo e(route('contact')); ?>" class="nav-button block w-full text-center">CONTACT US</a>
                    <a href="#cancellation" class="nav-button block w-full text-center">CANCELLATION</a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero-section relative z-10">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 fade-in-up montserrat">
                Transform Your Medical Career
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto fade-in-up" style="animation-delay: 0.2s;">
                Advance your skills with world-class medical education programs
            </p>
            <div class="flex flex-wrap justify-center gap-4 fade-in-up" style="animation-delay: 0.4s;">
                <a href="<?php echo e(route('courses.index')); ?>" class="btn-primary text-lg">
                    <i class="fas fa-graduation-cap mr-2"></i>Explore Courses
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn-primary text-lg">
                    <i class="fas fa-user-plus mr-2"></i>Get Started
                </a>
            </div>
            
            <!-- Stats Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-sm opacity-90">Courses</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">50K+</div>
                    <div class="text-sm opacity-90">Students</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">200+</div>
                    <div class="text-sm opacity-90">Expert Instructors</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-sm opacity-90">Success Rate</div>
                </div>
            </div>
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
    
    <!-- Courses Section -->
    <section class="py-16 bg-white" id="courses">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 montserrat">Featured Courses</h2>
                <p class="text-xl text-gray-600">Discover our most popular medical education programs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Course Card 1 -->
                <div class="course-card">
                    <img src="https://via.placeholder.com/400x200?text=Aesthetic+Medicine" alt="Aesthetic Medicine" class="course-image">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 montserrat">Fundamentals of Aesthetic Medicine</h3>
                        <p class="text-gray-600 mb-4">Comprehensive introduction to aesthetic medicine techniques and practices</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>6 weeks
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i>250 enrolled
                            </span>
                        </div>
                        <a href="#" class="btn-primary w-full text-center">View Course</a>
                    </div>
                </div>
                
                <!-- Course Card 2 -->
                <div class="course-card">
                    <img src="https://via.placeholder.com/400x200?text=Ultrasound" alt="Ultrasound" class="course-image">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 montserrat">Advanced Ultrasound Training</h3>
                        <p class="text-gray-600 mb-4">Master diagnostic ultrasound techniques for various medical applications</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>8 weeks
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i>180 enrolled
                            </span>
                        </div>
                        <a href="#" class="btn-primary w-full text-center">View Course</a>
                    </div>
                </div>
                
                <!-- Course Card 3 -->
                <div class="course-card">
                    <img src="https://via.placeholder.com/400x200?text=IVF+Medicine" alt="IVF & Reproductive Medicine" class="course-image">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 montserrat">IVF & Reproductive Medicine</h3>
                        <p class="text-gray-600 mb-4">Comprehensive training in assisted reproductive technologies</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>10 weeks
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i>320 enrolled
                            </span>
                        </div>
                        <a href="#" class="btn-primary w-full text-center">View Course</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo e(route('courses.index')); ?>" class="btn-primary text-lg">
                    View All Courses <i class="fas fa-arrow-right ml-2"></i>
                </a>
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
                <!-- Sample Plan Cards - Replace with dynamic content as needed -->
                <div class="w-full max-w-sm bg-white border-2 border-gray-200 shadow-lg rounded-xl p-8 relative hover:shadow-xl transition-all flex flex-col min-h-[550px]">
                    <div class="text-center mb-5">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Starter Plan</h3>
                        <p class="text-gray-600 text-sm">Perfect for new instructors</p>
                    </div>

                    <div class="text-center mb-6">
                        <div class="mb-4">
                            <div class="text-4xl font-bold text-gray-900">
                                Free
                            </div>
                            <div class="text-gray-600 text-sm">forever</div>
                        </div>
                    </div>

                    <div class="text-center mb-5 pb-5 border-b border-gray-200">
                        <div class="text-3xl font-bold text-blue-600">2</div>
                        <div class="text-gray-600 text-sm">Active Courses</div>
                    </div>

                    <ul class="space-y-4 mb-6 flex-grow">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Up to 100 students per course</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Basic course builder</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Email support</span>
                        </li>
                    </ul>

                    <a href="<?php echo e(route('register')); ?>" 
                        class="block w-full text-center bg-gray-100 text-gray-900 hover:bg-gray-200 px-6 py-3.5 rounded-lg font-semibold transition-all transform hover:scale-105 mt-auto">
                        Get Started
                    </a>
                </div>

                <div class="w-full max-w-sm bg-white border-2 border-blue-600 shadow-2xl transform scale-105 rounded-xl p-8 relative hover:shadow-xl transition-all flex flex-col min-h-[550px]">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-1.5 rounded-full text-sm font-semibold">
                            Most Popular
                        </span>
                    </div>

                    <div class="text-center mb-5">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Professional Plan</h3>
                        <p class="text-gray-600 text-sm">Best for growing instructors</p>
                    </div>

                    <div class="text-center mb-6">
                        <div class="mb-4">
                            <div class="text-4xl font-bold text-gray-900">
                                ₹2,499
                            </div>
                            <div class="text-gray-600 text-sm">per month</div>
                        </div>
                        <div class="text-sm text-gray-600">
                            or ₹24,990/year
                            <span class="text-green-600 font-semibold">
                                (Save 17%)
                            </span>
                        </div>
                    </div>

                    <div class="text-center mb-5 pb-5 border-b border-gray-200">
                        <div class="text-3xl font-bold text-blue-600">10</div>
                        <div class="text-gray-600 text-sm">Active Courses</div>
                    </div>

                    <ul class="space-y-4 mb-6 flex-grow">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">All Starter Features</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Unlimited students</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Advanced analytics & reports</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Live class integration</span>
                        </li>
                    </ul>

                    <a href="<?php echo e(route('register')); ?>" 
                        class="block w-full text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:from-blue-700 hover:to-purple-700 px-6 py-3.5 rounded-lg font-semibold transition-all transform hover:scale-105 mt-auto">
                        Get Started
                    </a>
                </div>

                <div class="w-full max-w-sm bg-white border-2 border-gray-200 shadow-lg rounded-xl p-8 relative hover:shadow-xl transition-all flex flex-col min-h-[550px]">
                    <div class="text-center mb-5">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Premium Plan</h3>
                        <p class="text-gray-600 text-sm">For established instructors</p>
                    </div>

                    <div class="text-center mb-6">
                        <div class="mb-4">
                            <div class="text-4xl font-bold text-gray-900">
                                ₹4,999
                            </div>
                            <div class="text-gray-600 text-sm">per month</div>
                        </div>
                        <div class="text-sm text-gray-600">
                            or ₹49,990/year
                            <span class="text-green-600 font-semibold">
                                (Save 17%)
                            </span>
                        </div>
                    </div>

                    <div class="text-center mb-5 pb-5 border-b border-gray-200">
                        <div class="text-3xl font-bold text-blue-600">Unlimited</div>
                        <div class="text-gray-600 text-sm">Active Courses</div>
                    </div>

                    <ul class="space-y-4 mb-6 flex-grow">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">All Professional Features</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Priority listing in search</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Marketing & promotional support</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 text-base">Dedicated account manager</span>
                        </li>
                    </ul>

                    <a href="<?php echo e(route('register')); ?>" 
                        class="block w-full text-center bg-gray-100 text-gray-900 hover:bg-gray-200 px-6 py-3.5 rounded-lg font-semibold transition-all transform hover:scale-105 mt-auto">
                        Get Started
                    </a>
                </div>
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
                        <a href="<?php echo e(route('register')); ?>" 
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
                        <a href="<?php echo e(route('register')); ?>" 
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
                        <a href="<?php echo e(route('register')); ?>" 
                           class="block w-full bg-gradient-to-r from-green-500 to-green-700 text-white text-center font-semibold py-4 rounded-lg hover:from-green-600 hover:to-green-800 transition-all mt-auto">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Simple Application Process -->
            <div class="bg-white rounded-2xl shadow-lg p-10 text-center">
                <h3 class="text-3xl font-bold text-gray-900 mb-8">Simple Application Process</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                    <div class="px-4">
                        <div class="w-12 h-12 mx-auto rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-lg mb-4">1</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Submit Application</h4>
                        <p class="text-sm text-gray-600">Fill out our comprehensive application form with your details and credentials</p>
                    </div>

                    <div class="px-4">
                        <div class="w-12 h-12 mx-auto rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-lg mb-4">2</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Document Review</h4>
                        <p class="text-sm text-gray-600">Our team reviews your credentials and supporting documents thoroughly</p>
                    </div>

                    <div class="px-4">
                        <div class="w-12 h-12 mx-auto rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-lg mb-4">3</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Verification</h4>
                        <p class="text-sm text-gray-600">Quick verification process completed within 2-3 business days</p>
                    </div>

                    <div class="px-4">
                        <div class="w-12 h-12 mx-auto rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-lg mb-4">4</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Get Started</h4>
                        <p class="text-sm text-gray-600">Account setup and onboarding to help you start teaching immediately</p>
                    </div>
                </div>

                <p class="text-gray-600 mb-6">Questions about joining our platform?</p>

                <a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center px-6 py-3 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-700 font-medium hover:bg-gray-50 transition">
                    <svg class="mr-3 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Contact Us
                </a>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4 montserrat">Ready to Start Your Journey?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of medical professionals advancing their careers</p>
            <a href="<?php echo e(route('register')); ?>" class="btn-primary bg-white text-blue-700 hover:bg-gray-100">
                <i class="fas fa-rocket mr-2"></i>Get Started Today
            </a>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="site-footer">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 montserrat"><?php echo e(config('app.name')); ?></h3>
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
                        <li><a href="<?php echo e(route('courses.index')); ?>">Browse Courses</a></li>
                        <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                        <li><a href="#faculty">Our Faculty</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
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
    
    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/welcome.blade.php ENDPATH**/ ?>