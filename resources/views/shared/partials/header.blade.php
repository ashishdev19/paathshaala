<!-- Header -->
<header class="fixed top-0 left-0 right-0 text-white shadow-sm border-b border-teal-700 z-50" style="background-color: #008080;">
    <div class="w-full px-6 lg:px-12">
        <div class="flex items-center justify-between h-16">
            <!-- Left Side: Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        <span style="color: #034285;">Med</span><span style="color: #e53e3e;">N<span style="position: relative; display: inline-block;"><span style="color: #e53e3e;">i</span><span style="position: absolute; top: -2px; left: 50%; transform: translateX(-50%); color: #e53e3e; font-size: 0.7em;">+</span></span>ks</span>
                    </h1>
                </div>
            </a>
            
            <!-- Center: Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ url('/') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Home</a>
                <a href="{{ route('about') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">About Medniks</a>
                <a href="{{ route('contact') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">How can we help</a>
                <a href="{{ route('become-instructor') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Become Instructor</a>
                <a href="{{ route('courses.index') }}" class="px-4 py-2 text-lg text-white hover:text-teal-200 hover:bg-teal-700/40 rounded-lg transition-all font-medium">Courses</a>
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
            <a href="{{ route('about') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">About Medniks</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">How can we help</a>
            <a href="{{ route('become-instructor') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Become Instructor</a>
            <a href="{{ route('courses.index') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all font-medium">Courses</a>
        </div>
    </div>
</header>
