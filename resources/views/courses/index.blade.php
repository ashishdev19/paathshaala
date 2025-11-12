<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses - Paathshaala</title>
    
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
                            <a href="{{ route('courses.index') }}" class="text-indigo-600 px-3 py-2 text-sm font-medium border-b-2 border-indigo-600">Courses</a>
                            <a href="{{ route('about') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">About</a>
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

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
                    Healthcare & Medical Courses
                </h1>
                <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Discover comprehensive courses designed by healthcare experts to advance your medical career.
                </p>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-4 justify-center">
                    <button class="bg-indigo-600 text-white px-6 py-2 rounded-full text-sm font-medium">All Courses</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Nursing</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Medicine</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Pharmacy</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Surgery</button>
                </div>
            </div>

            <!-- Results Info -->
            <div class="mb-8">
                <p class="text-gray-600">Showing {{ $courses->count() }} of {{ $courses->total() }} courses</p>
            </div>
            
            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($courses as $course)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-40 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-3xl mb-2">🏥</div>
                            <div class="text-xs font-medium">{{ $course->category }}</div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $course->description }}</p>
                        
                        <div class="flex items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-medium">{{ substr($course->teacher->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-2">
                                <p class="text-sm font-medium text-gray-900">{{ $course->teacher->name }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                                <span class="ml-1 text-xs text-gray-600">({{ $course->reviews_count }})</span>
                            </div>
                            <div class="text-lg font-bold text-indigo-600">₹{{ number_format($course->price) }}</div>
                        </div>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span>{{ $course->enrollments_count }} students</span>
                            <span>{{ $course->duration }} hours</span>
                        </div>
                        
                        <a href="{{ route('courses.show', $course->id) }}" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-300 text-center block text-sm">
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($courses->hasPages())
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
            @endif

            <!-- Empty State -->
            @if($courses->count() === 0)
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">No courses found</h3>
                <p class="text-gray-600 mb-8">We couldn't find any courses matching your criteria.</p>
                <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                    Back to Home
                </a>
            </div>
            @endif
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