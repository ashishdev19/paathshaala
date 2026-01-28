<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become an Instructor - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .montserrat {
            font-family: 'Montserrat', sans-serif;
        }
        .site-header {
            background: #008080;
        }
        
        /* Footer Styling */
        .site-footer {
            background: #008080;
            color: #e6fffb;
            padding: 3rem 2rem 1rem;
        }
        
        .footer-links a {
            color: #c1f5ef;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #ffffff;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="site-header fixed top-0 left-0 right-0 text-white shadow-sm border-b border-teal-700 z-50">
        <div class="w-full px-6 lg:px-12">
            <div class="flex items-center justify-between h-16">
                <!-- Left Side: Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div>
                        <h1 class="text-xl font-bold text-white">
                            <span style="color: #2d3748;">Med</span><span style="color: #e53e3e;">N<span style="position: relative; display: inline-block;"><span style="color: #e53e3e;">i</span><span style="position: absolute; top: -2px; left: 50%; transform: translateX(-50%); color: #e53e3e; font-size: 0.7em;">+</span></span>ks</span>
                        </h1>
                    </div>
                </a>
                
                <!-- Center: Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ url('/') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Home</a>
                    <a href="{{ route('courses.index') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Courses</a>
                    <a href="{{ route('become-instructor') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Become Instructor</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">About</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Contact</a>
                </nav>
                
                <!-- Right Side: Auth Links -->
                <div class="flex items-center space-x-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 md:px-6 md:py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-base rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 md:px-6 md:py-2.5 bg-teal-600 text-white text-sm md:text-base rounded-full hover:bg-teal-700 transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02] whitespace-nowrap">Login/Register</a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 text-white hover:text-teal-200 focus:outline-none" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white/50 border-t border-gray-100 shadow-lg text-white">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ url('/') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Home</a>
                <a href="{{ route('courses.index') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
                <a href="{{ route('become-instructor') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Become Instructor</a>
                <a href="{{ route('about') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About</a>
                <a href="{{ route('contact') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Contact</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-gradient-to-br from-teal-50 via-white to-teal-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 montserrat">
                Share Your Medical Expertise
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                Join thousands of healthcare professionals teaching on our platform. Create courses, reach students worldwide, and earn while making an impact.
            </p>
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
                            class="block w-full text-center {{ $isPopular ? 'bg-gradient-to-r from-teal-600 to-teal-600 text-white hover:from-teal-700 hover:to-teal-900' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }} px-6 py-3.5 rounded-lg font-semibold transition-all transform hover:scale-105 mt-auto">
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
    

    <!-- Benefits Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 montserrat">Why Teach With Us?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 montserrat">Reach Global Audience</h3>
                    <p class="text-gray-600">Connect with thousands of healthcare professionals worldwide seeking quality medical education</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 montserrat">Earn While Teaching</h3>
                    <p class="text-gray-600">Get competitive revenue share and track your earnings with our transparent analytics</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 montserrat">Full Support</h3>
                    <p class="text-gray-600">Get dedicated instructor support, marketing assistance, and technical help</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-teal-500 to-teal-600">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 montserrat">
                Ready to Start Your Teaching Journey?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Join our community of expert instructors and make a difference in medical education
            </p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-teal-700 text-white font-semibold rounded-lg hover:bg-teal-900 transition-all duration-300 transform hover:scale-105 shadow-lg">
                Register as Instructor
            </a>
        </div>
    </section>

    @include('shared.partials.footer')
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
