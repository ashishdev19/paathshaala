<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - {{ config('app.name', 'Medniks') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover { transition: all 0.4s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); }
        .feature-icon { background: linear-gradient(135deg, #2563EB 0%, #1d4ed8 100%); }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .float-animation { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-lg shadow-sm border-b border-gray-100 z-50">
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

    <!-- Hero -->
    <div class="relative overflow-hidden bg-blue-600 text-white py-32 pt-40">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-6xl md:text-7xl font-black mb-8">About <span class="text-white">{{ config('app.name', 'Medniks') }}</span></h1>
            <p class="text-2xl max-w-4xl mx-auto leading-relaxed font-light">Transforming medical education through innovative technology, expert instructors, and excellence in healthcare learning.</p>
            <div class="mt-12 flex justify-center gap-6">
                <a href="/courses" class="bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition">Explore Courses</a>
                <a href="/contact" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-blue-600 transition">Contact Us</a>
            </div>
        </div>
    </div>

    <!-- Platform Features -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center mb-16">
            <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider">What We Provide</span>
            <h2 class="text-5xl font-black text-gray-900 mt-4 mb-4">Platform Features & Benefits</h2>
            <p class="text-xl text-gray-600">Comprehensive features designed for medical professionals</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Live Classes -->
            <div class="card-hover bg-white rounded-2xl shadow-xl border overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between mb-4">
                        <div class="h-16 w-16 rounded-2xl feature-icon text-white flex items-center justify-center shadow-lg"><i class="fas fa-video text-2xl"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Live Interactive Classes</h3>
                    <p class="text-gray-600">Real-time learning with expert instructors</p>
                </div>
                <div class="bg-blue-50 px-8 pb-8">
                    <div class="space-y-3 pt-4">
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>HD video streaming with crystal clear audio</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Real-time Q&A with instructors</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Screen sharing and whiteboard tools</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Record sessions for later review</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Interactive polls and quizzes</p>
                    </div>
                </div>
            </div>
            <!-- Courses -->
            <div class="card-hover bg-white rounded-2xl shadow-xl border overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between mb-4">
                        <div class="h-16 w-16 rounded-2xl feature-icon text-white flex items-center justify-center shadow-lg"><i class="fas fa-book-open text-2xl"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Comprehensive Courses</h3>
                    <p class="text-gray-600">100+ medical courses across specialties</p>
                </div>
                <div class="bg-blue-50 px-8 pb-8">
                    <div class="space-y-3 pt-4">
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>MBBS, MD, MS specialty courses</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>NEET PG, INICET, FMGE preparation</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Clinical skills and practical training</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Regular content updates and revisions</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Downloadable study materials and notes</p>
                    </div>
                </div>
            </div>
            <!-- Certifications -->
            <div class="card-hover bg-white rounded-2xl shadow-xl border overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between mb-4">
                        <div class="h-16 w-16 rounded-2xl feature-icon text-white flex items-center justify-center shadow-lg"><i class="fas fa-certificate text-2xl"></i></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Certifications & Support</h3>
                    <p class="text-gray-600">Recognized certificates with lifetime access</p>
                </div>
                <div class="bg-blue-50 px-8 pb-8">
                    <div class="space-y-3 pt-4">
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Industry-recognized certificates</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Lifetime course access with updates</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>24/7 student support and mentorship</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Community forums and peer learning</p>
                        <p class="flex items-start text-gray-700"><i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>Career guidance and placement support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-blue-600 text-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black mb-4">Our Impact in Numbers</h2>
                <p class="text-xl opacity-90">Trusted by thousands worldwide</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center bg-white/10 backdrop-blur-md rounded-2xl p-8">
                    <div class="text-6xl font-black mb-3">100+</div>
                    <div class="text-xl font-semibold">Premium Courses</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-2xl p-8">
                    <div class="text-6xl font-black mb-3">50+</div>
                    <div class="text-xl font-semibold">Expert Instructors</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-2xl p-8">
                    <div class="text-6xl font-black mb-3">10K+</div>
                    <div class="text-xl font-semibold">Active Students</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-2xl p-8">
                    <div class="text-6xl font-black mb-3">95%</div>
                    <div class="text-xl font-semibold">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructors -->
    @if($teachers && $teachers->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black text-gray-900 mb-4">Meet Our Expert Instructors</h2>
            <p class="text-xl text-gray-600">Learn from board-certified professionals</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($teachers as $teacher)
            <div class="card-hover bg-white rounded-2xl shadow-xl border">
                <div class="p-8">
                    <div class="w-28 h-28 mx-auto mb-6 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-4xl font-black text-white">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 text-center mb-2">{{ $teacher->name }}</h3>
                    <p class="text-sm text-gray-500 text-center mb-6">{{ $teacher->email }}</p>
                    <div class="flex justify-center">
                        <div class="px-4 py-2 rounded-full bg-blue-50 border border-blue-200">
                            <span class="text-sm font-bold text-blue-600"><i class="fas fa-book mr-2"></i>{{ $teacher->active_courses_count ?? 0 }} Courses</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- CTA -->
    <div class="bg-blue-600 py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-black text-white mb-6">Ready to Start Learning?</h2>
            <p class="text-xl text-white opacity-90 mb-10">Join thousands of healthcare professionals advancing their careers</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/register" class="bg-white text-blue-600 px-10 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition">Create Free Account</a>
                <a href="/courses" class="bg-transparent border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-blue-600 transition">Browse Courses</a>
            </div>
        </div>
    </div>

    <footer class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white">
        <!-- Newsletter Section -->
        <div class="bg-blue-600 py-16">
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
            
                <!-- Bottom Section -->
               
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
    <footer class="bg-gray-900 text-gray-300 py-12 mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white">{{ config('app.name') }}</h3>
                    <p class="text-gray-400 mb-4">Empowering medical professionals through quality education and training</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-blue-600 flex items-center justify-center transition-colors" aria-label="Facebook">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-pink-600 flex items-center justify-center transition-colors" aria-label="Instagram">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-red-600 flex items-center justify-center transition-colors" aria-label="YouTube">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 hover:bg-blue-700 flex items-center justify-center transition-colors" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Platform</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('courses.index') }}" class="hover:text-blue-400 transition-colors">Browse Courses</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition-colors">About Us</a></li>
                        <li><a href="#faculty" class="hover:text-blue-400 transition-colors">Our Faculty</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-blue-400 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Specializations -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Specializations</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Aesthetic Medicine</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Aesthetic Gynecology</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Ultrasound</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">IVF & Reproductive Medicine</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Surgical Courses</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Contact Us</h4>
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
</body>
</html>
