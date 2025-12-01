<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Paathshaala - Your trusted online medical education platform. Learn from expert instructors and advance your medical career.">
    
    <title>Paathshaala - Your Trusted Online Medical Education Platform</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Success Modal Animation */
        #successModal {
            animation: fadeInModal 0.3s ease-out;
        }
        
        #successModal > div {
            animation: slideInModal 0.3s ease-out;
        }
        
        @keyframes fadeInModal {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInModal {
            from { 
                opacity: 0;
                transform: scale(0.8) translateY(-20px);
            }
            to { 
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>
</head>
<body class="font-sans text-slate-800 bg-white overflow-x-hidden">
    <!-- Success Popup Modal -->
    <?php if(session('show_success_popup')): ?>
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]">
        <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
            <!-- Success Icon -->
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <!-- Success Message -->
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Account Created Successfully!</h3>
            <p class="text-gray-600 mb-6">Welcome to Paathshaala! Your account has been created and you're now logged in.</p>
            
            <!-- Close Button -->
            <button onclick="closeSuccessModal()" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition-all">
                Continue
            </button>
        </div>
    </div>
    <?php endif; ?>
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
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Paathshaala</h1>
                        <p class="text-xs text-gray-500 font-medium">Medical Excellence</p>
                    </div>
                </a>
                
                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="<?php echo e(route('courses.index')); ?>" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                    <a href="<?php echo e(route('about')); ?>" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                    <a href="#instructors" class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Instructors</a>
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
                <a href="<?php echo e(route('courses.index')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                <a href="<?php echo e(route('about')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                <a href="#instructors" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Instructors</a>
                <a href="<?php echo e(route('contact')); ?>" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Contact</a>
            </div>
        </div>
    </header>

    <!-- Service Quick Links -->
    <section class="pt-16 pb-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Explore Our Services</h2>
                <p class="text-gray-600">Comprehensive medical education solutions at your fingertips</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <a href="<?php echo e(route('courses.index')); ?>" class="group flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-book-medical text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 text-center">Medical Courses</span>
                    <span class="text-xs text-gray-500 mt-1">1,200+ Courses</span>
                </a>
                
                <a href="#live-classes" class="group flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-video text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 text-center">Live Classes</span>
                    <span class="text-xs text-gray-500 mt-1">Interactive Sessions</span>
                </a>
                
                <a href="#expert-consultation" class="group flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-user-md text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 text-center">Expert Consultation</span>
                    <span class="text-xs text-gray-500 mt-1">1-on-1 Guidance</span>
                </a>
                
                <a href="#certifications" class="group flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-certificate text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 text-center">Certifications</span>
                    <span class="text-xs text-gray-500 mt-1">Industry Recognized</span>
                </a>
                
                <a href="#study-materials" class="group flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-file-medical text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 text-center">Study Materials</span>
                    <span class="text-xs text-gray-500 mt-1">Comprehensive Library</span>
                </a>
                
                <a href="#career-guidance" class="group flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-user-graduate text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 text-center">Career Guidance</span>
                    <span class="text-xs text-gray-500 mt-1">Expert Mentorship</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-16 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23f1f5f9" fill-opacity="0.4"%3E%3Ccircle cx="7" cy="7" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        
        <!-- Single Container -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-lg rounded-3xl p-12 shadow-2xl border border-white/20">
                <div class="grid lg:grid-cols-2 gap-24 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div class="space-y-6">
                           
                            
                            <!-- Main Heading -->
                            <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-gray-900">
                                Transform Your 
                                <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">Medical Career</span>
                            </h1>
                            
                            <!-- Description -->
                            <p class="text-lg lg:text-xl text-gray-600 leading-relaxed">
                                Join 50,000+ healthcare professionals learning from world-renowned experts. Access premium courses, live mentorship, and industry-recognized certifications.
                            </p>
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="<?php echo e(route('courses.index')); ?>" class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl font-semibold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <span>Start Learning Today</span>
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-8 pt-8">
                            <div class="text-center">
                                <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">1,200+</div>
                                <div class="text-sm text-gray-600 font-medium">Premium Courses</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">50k+</div>
                                <div class="text-sm text-gray-600 font-medium">Active Students</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">98%</div>
                                <div class="text-sm text-gray-600 font-medium">Success Rate</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Content - Feature Cards -->
                    <div class="relative">
                        <div class="space-y-6">
                            <!-- Feature Item 1 -->
                            <div class="flex items-center gap-5 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 shadow-md">
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Expert-Led Courses</h3>
                                    <p class="text-gray-600">Learn from top medical professionals</p>
                                </div>
                            </div>
                            
                            <!-- Feature Item 2 -->
                            <div class="flex items-center gap-5 p-5 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-100 shadow-md">
                                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-video text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Live Interactive Sessions</h3>
                                    <p class="text-gray-600">Real-time Q&A with instructors</p>
                                </div>
                            </div>
                            
                            <!-- Feature Item 3 -->
                            <div class="flex items-center gap-5 p-5 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-100 shadow-md">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-certificate text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Industry Certifications</h3>
                                    <p class="text-gray-600">Recognized by healthcare institutions</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg animate-bounce">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                        
                        <div class="absolute -bottom-4 -left-4 w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg animate-pulse">
                            <i class="fas fa-award text-white text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Medical Specializations -->
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-stethoscope mr-2"></i>
                    Medical Specializations
                </div>
                <h2 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Choose Your <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Specialty</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                    Master your field with comprehensive courses designed by leading specialists. Each program includes practical case studies, latest research, and hands-on training.
                </p>
            </div>
            
            <!-- Specialization Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-16">
                <!-- Cardiology -->
                <a href="#cardiology" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-blue-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-heartbeat text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Cardiology</span>
                        <div class="text-xs text-gray-500 mt-1">120+ Courses</div>
                    </div>
                </a>
                
                <!-- Neurology -->
                <a href="#neurology" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-red-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-brain text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Neurology</span>
                        <div class="text-xs text-gray-500 mt-1">95+ Courses</div>
                    </div>
                </a>
                
                <!-- Pediatrics -->
                <a href="#pediatrics" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-child text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-green-600 transition-colors">Pediatrics</span>
                        <div class="text-xs text-gray-500 mt-1">85+ Courses</div>
                    </div>
                </a>
                
                <!-- Surgery -->
                <a href="#surgery" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-orange-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-yellow-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-user-md text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors">Surgery</span>
                        <div class="text-xs text-gray-500 mt-1">150+ Courses</div>
                    </div>
                </a>
                
                <!-- Psychiatry -->
                <a href="#psychiatry" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-head-side-virus text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Psychiatry</span>
                        <div class="text-xs text-gray-500 mt-1">70+ Courses</div>
                    </div>
                </a>
                
                <!-- Dermatology -->
                <a href="#dermatology" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-teal-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-cyan-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-hand-holding-medical text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-teal-600 transition-colors">Dermatology</span>
                        <div class="text-xs text-gray-500 mt-1">65+ Courses</div>
                    </div>
                </a>
                
                <!-- Radiology -->
                <a href="#radiology" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-indigo-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-x-ray text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">Radiology</span>
                        <div class="text-xs text-gray-500 mt-1">80+ Courses</div>
                    </div>
                </a>
                
                <!-- Oncology -->
                <a href="#oncology" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-pink-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-rose-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-ribbon text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-pink-600 transition-colors">Oncology</span>
                        <div class="text-xs text-gray-500 mt-1">90+ Courses</div>
                    </div>
                </a>
                
                <!-- Orthopedics -->
                <a href="#orthopedics" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-amber-200 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-bone text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors">Orthopedics</span>
                        <div class="text-xs text-gray-500 mt-1">110+ Courses</div>
                    </div>
                </a>
                
                <!-- General Medicine -->
                <a href="#general-medicine" class="group relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-gray-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-slate-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-gray-600 to-slate-700 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-stethoscope text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-900 group-hover:text-gray-700 transition-colors">General Medicine</span>
                        <div class="text-xs text-gray-500 mt-1">200+ Courses</div>
                    </div>
                </a>
            </div>
            
            <!-- View All Specializations Button -->
            <div class="text-center">
                <a href="<?php echo e(route('courses.index')); ?>" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-2xl font-semibold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <span>View All Specializations</span>
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-award mr-2"></i>
                    Why Paathshaala?
                </div>
                <h2 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    India's Leading <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Medical Platform</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                    Trusted by 50,000+ healthcare professionals nationwide. Experience world-class medical education with cutting-edge technology and personalized learning paths.
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Expert Faculty -->
                <div class="group relative bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-xl">
                            <i class="fas fa-graduation-cap text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">World-Class Faculty</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">Learn from internationally renowned medical experts, department heads, and practicing specialists with decades of experience.</p>
                        <div class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full inline-block">500+ Expert Instructors</div>
                    </div>
                </div>
                
                <!-- Industry Recognition -->
                <div class="group relative bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-xl">
                            <i class="fas fa-certificate text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition-colors">Globally Recognized</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">Industry-accredited certifications accepted by top hospitals, medical institutions, and healthcare organizations worldwide.</p>
                        <div class="text-sm font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full inline-block">WHO & AMA Approved</div>
                    </div>
                </div>
                
                <!-- 24/7 Support -->
                <div class="group relative bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-xl">
                            <i class="fas fa-headset text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-purple-600 transition-colors">Premium Support</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">Round-the-clock academic mentorship, technical assistance, and personalized career guidance from dedicated support teams.</p>
                        <div class="text-sm font-semibold text-purple-600 bg-purple-50 px-3 py-1 rounded-full inline-block">24/7 Live Chat</div>
                    </div>
                </div>
                
                <!-- Advanced Technology -->
                <div class="group relative bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-xl">
                            <i class="fas fa-mobile-alt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors">Advanced Learning</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">AI-powered learning paths, virtual simulations, interactive case studies, and seamless multi-device accessibility.</p>
                        <div class="text-sm font-semibold text-orange-600 bg-orange-50 px-3 py-1 rounded-full inline-block">AI-Powered Platform</div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Banner -->
            <div class="mt-20 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-12 text-center text-white">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-4xl font-bold mb-2">98%</div>
                        <div class="text-blue-200">Success Rate</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">50k+</div>
                        <div class="text-blue-200">Active Students</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">1,200+</div>
                        <div class="text-blue-200">Expert Courses</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">24/7</div>
                        <div class="text-blue-200">Support Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Platform Services Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-2 bg-green-50 text-green-600 rounded-full text-sm font-semibold mb-4">Platform Services</span>
                <h2 class="font-display text-4xl lg:text-5xl font-bold">How We Serve You</h2>
                <p class="text-lg text-slate-600 mt-4">Comprehensive medical education solutions designed for students, professionals, and healthcare organizations</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="service-card bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl overflow-hidden shadow-md border border-blue-100 transition-all hover:-translate-y-2 hover:shadow-2xl">
                    <div class="p-10">
                        <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="8.5" cy="7" r="4" stroke="white" stroke-width="2"/>
                                <path d="M20 8v6M23 11h-6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">For Students</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">Access quality medical education with ease. Enroll in courses, attend live classes, manage your learning journey, and track your progress.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Comprehensive course library</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Live interactive classes</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Digital certificates</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Progress tracking</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Expert consultation</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Career guidance</li>
                        </ul>
                        <a href="<?php echo e(url('/register?type=student')); ?>" class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-lg transition-all hover:from-purple-700 hover:to-indigo-700 hover:translate-x-1 shadow-md hover:shadow-lg">Get Started →</a>
                    </div>
                </div>
                
                <div class="service-card bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl overflow-hidden shadow-md border border-green-100 transition-all hover:-translate-y-2 hover:shadow-2xl">
                    <div class="p-10">
                        <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mb-6">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M2 12l10 5 10-5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">For Instructors</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">Share your expertise with aspiring medical professionals. Create courses, conduct live sessions, and build your teaching portfolio.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Course creation tools</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Live teaching platform</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Student management</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Revenue analytics</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Assessment tools</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Professional profile</li>
                        </ul>
                        <a href="<?php echo e(url('/register?type=teacher')); ?>" class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-lg transition-all hover:from-purple-700 hover:to-indigo-700 hover:translate-x-1 shadow-md hover:shadow-lg">Join as Instructor →</a>
                    </div>
                </div>
                
                <div class="service-card bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl overflow-hidden shadow-md border border-purple-100 transition-all hover:-translate-y-2 hover:shadow-2xl">
                    <div class="p-10">
                        <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mb-6">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                <path d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="12" cy="7" r="4" stroke="white" stroke-width="2"/>
                                <path d="M19 8v6M22 11h-6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">For Institutions</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">Partner with us to expand your educational reach. Manage multiple courses, instructors, and students on our platform.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Multi-course management</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Instructor network</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Analytics dashboard</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Revenue management</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Quality assurance</li>
                            <li class="flex items-start text-slate-600 pl-7 relative before:content-['✓'] before:absolute before:left-0 before:text-green-500 before:font-bold">Branding options</li>
                        </ul>
                        <a href="<?php echo e(url('/register?type=institution')); ?>" class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-lg transition-all hover:from-purple-700 hover:to-indigo-700 hover:translate-x-1 shadow-md hover:shadow-lg">Partner With Us →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
        <div class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                    <!-- Company Info -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-graduation-cap text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">Paathshaala</h3>
                                <p class="text-blue-300 text-sm">Medical Education Excellence</p>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-8 text-lg leading-relaxed max-w-lg">Transforming medical education in India through innovative online learning experiences. Join 50,000+ healthcare professionals advancing their careers with us.</p>
                        
                        <!-- Social Links -->
                        <div class="flex gap-4 mb-8">
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center hover:from-blue-500 hover:to-blue-600 transition-all transform hover:scale-110 shadow-lg" aria-label="Facebook">
                                <i class="fab fa-facebook-f text-white"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-sky-600 to-sky-700 rounded-2xl flex items-center justify-center hover:from-sky-500 hover:to-sky-600 transition-all transform hover:scale-110 shadow-lg" aria-label="Twitter">
                                <i class="fab fa-twitter text-white"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-pink-600 to-pink-700 rounded-2xl flex items-center justify-center hover:from-pink-500 hover:to-pink-600 transition-all transform hover:scale-110 shadow-lg" aria-label="Instagram">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center hover:from-indigo-500 hover:to-indigo-600 transition-all transform hover:scale-110 shadow-lg" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                        </div>
                        
                        <!-- Trust Badges -->
                        <div class="flex gap-4 text-sm text-gray-400">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                <span>SSL Secured</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-award text-yellow-500"></i>
                                <span>ISO Certified</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-xl font-bold mb-6 text-white">Platform</h4>
                        <ul class="space-y-4">
                            <li><a href="<?php echo e(route('courses.index')); ?>" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>Browse Courses</a></li>
                            <li><a href="<?php echo e(route('about')); ?>" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>About Us</a></li>
                            <li><a href="#instructors" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>Expert Faculty</a></li>
                            <li><a href="<?php echo e(route('contact')); ?>" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>Contact Support</a></li>
                            <li><a href="#certifications" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>Certifications</a></li>
                            <li><a href="#careers" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>Careers</a></li>
                        </ul>
                    </div>
                    
                    <!-- Medical Specializations -->
                    <div>
                        <h4 class="text-xl font-bold mb-6 text-white">Specializations</h4>
                        <ul class="space-y-4">
                            <li><a href="#cardiology" class="text-gray-300 hover:text-red-400 transition-colors flex items-center gap-2 group"><i class="fas fa-heartbeat text-red-500 text-xs"></i>Cardiology</a></li>
                            <li><a href="#neurology" class="text-gray-300 hover:text-blue-400 transition-colors flex items-center gap-2 group"><i class="fas fa-brain text-blue-500 text-xs"></i>Neurology</a></li>
                            <li><a href="#surgery" class="text-gray-300 hover:text-orange-400 transition-colors flex items-center gap-2 group"><i class="fas fa-user-md text-orange-500 text-xs"></i>Surgery</a></li>
                            <li><a href="#pediatrics" class="text-gray-300 hover:text-green-400 transition-colors flex items-center gap-2 group"><i class="fas fa-child text-green-500 text-xs"></i>Pediatrics</a></li>
                            <li><a href="#radiology" class="text-gray-300 hover:text-indigo-400 transition-colors flex items-center gap-2 group"><i class="fas fa-x-ray text-indigo-500 text-xs"></i>Radiology</a></li>
                            <li><a href="#general-medicine" class="text-gray-300 hover:text-gray-400 transition-colors flex items-center gap-2 group"><i class="fas fa-stethoscope text-gray-500 text-xs"></i>General Medicine</a></li>
                        </ul>
                        
                        <!-- Contact Info -->
                        <div class="mt-12">
                            <h4 class="text-xl font-bold mb-6 text-white">Contact</h4>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3 text-gray-300">
                                    <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <i class="fas fa-envelope text-blue-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">Email Support</div>
                                        <div class="text-sm">support@paathshaala.com</div>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3 text-gray-300">
                                    <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <i class="fas fa-phone text-green-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">24/7 Helpline</div>
                                        <div class="text-sm">+91-800-MEDICAL</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Section -->
                <div class="pt-8 border-t border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-gray-400 text-center md:text-left">
                            <p>&copy; <?php echo e(date('Y')); ?> Paathshaala Medical Education Platform. All rights reserved.</p>
                        </div>
                        <div class="flex gap-6 text-sm">
                            <a href="#privacy" class="text-gray-400 hover:text-blue-400 transition-colors">Privacy Policy</a>
                            <a href="#terms" class="text-gray-400 hover:text-blue-400 transition-colors">Terms of Service</a>
                            <a href="#cookies" class="text-gray-400 hover:text-blue-400 transition-colors">Cookie Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Simple smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
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

        // Success modal functions
        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.style.opacity = '0';
                modal.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        // Auto-close success modal after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = document.getElementById('successModal');
            console.log('Checking for success modal...', successModal);
            <?php if(session('show_success_popup')): ?>
                console.log('Session has show_success_popup flag');
            <?php endif; ?>
            
            if (successModal) {
                console.log('Success modal found, auto-closing in 5 seconds');
                setTimeout(() => {
                    closeSuccessModal();
                }, 5000);
            } else {
                console.log('No success modal found');
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/welcome.blade.php ENDPATH**/ ?>