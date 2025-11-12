<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} - Paathshaala</title>
    
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
                            <a href="{{ route('courses.index') }}" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Courses</a>
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

    <!-- Breadcrumb -->
    <div class="bg-white pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('courses.index') }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">Courses</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $course->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Course Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="mb-4">
                        <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">{{ $course->category }}</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">{{ $course->title }}</h1>
                    <p class="text-xl text-indigo-100 mb-6">{{ $course->description }}</p>
                    
                    <div class="flex flex-wrap items-center gap-6 text-indigo-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $course->enrollments_count }} Students
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $course->duration }} Hours
                        </div>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                            <span class="ml-2">({{ $course->reviews_count }} reviews)</span>
                        </div>
                    </div>
                </div>
                
                <!-- Course Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-xl p-6 sticky top-24">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-indigo-600 mb-2">₹{{ number_format($course->price) }}</div>
                            <div class="text-gray-500">One-time payment</div>
                        </div>
                        
                        @if($isEnrolled)
                            <div class="text-center mb-6">
                                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-semibold">
                                    ✅ Already Enrolled
                                </div>
                            </div>
                            <a href="{{ route('student.courses.show', $course->id) }}" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 text-center block">
                                Go to Course
                            </a>
                        @else
                            @auth
                                <div class="mb-4">
                                    <a href="{{ route('enrollment.checkout', $course->id) }}" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 text-center block">
                                        Enroll Now
                                    </a>
                                </div>
                            @else
                                <div class="text-center mb-4">
                                    <p class="text-gray-600 mb-4">Please login to enroll in this course</p>
                                    <a href="{{ route('login') }}" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 text-center block">
                                        Login to Enroll
                                    </a>
                                </div>
                            @endauth
                        @endif
                        
                        <div class="border-t pt-6">
                            <h4 class="font-semibold text-gray-900 mb-4">This course includes:</h4>
                            <ul class="space-y-3 text-gray-600">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $course->duration }} hours of content
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Live online classes
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Certificate of completion
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Lifetime access
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <!-- Course Description -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">About This Course</h2>
                        <div class="prose max-w-none text-gray-600">
                            <p class="text-lg leading-relaxed">{{ $course->description }}</p>
                            <p class="mt-6">This comprehensive course is designed for healthcare professionals looking to advance their knowledge and skills in {{ $course->category }}. You'll learn from industry experts and gain practical experience through hands-on exercises and real-world case studies.</p>
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Meet Your Instructor</h2>
                        <div class="flex items-start space-x-4">
                            <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xl font-medium">{{ substr($course->teacher->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $course->teacher->name }}</h3>
                                <p class="text-gray-600 mb-2">Expert Healthcare Professional</p>
                                <p class="text-gray-600">{{ $course->teacher->name }} is a highly experienced healthcare professional with years of expertise in {{ $course->category }}. They have taught thousands of students and helped advance many healthcare careers.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews -->
                    @if($course->reviews->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Student Reviews</h2>
                        <div class="space-y-6">
                            @foreach($course->reviews->take(5) as $review)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-medium">{{ substr($review->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= $review->rating; $i++)
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Upcoming Classes -->
                    @if($course->onlineClasses->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Upcoming Classes</h3>
                        <div class="space-y-3">
                            @foreach($course->onlineClasses->where('scheduled_at', '>', now())->take(3) as $class)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $class->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $class->scheduled_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $class->scheduled_at->format('h:i A') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Related Courses -->
                    @if($relatedCourses->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Related Courses</h3>
                        <div class="space-y-4">
                            @foreach($relatedCourses as $relatedCourse)
                            <div class="flex space-x-3">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs">{{ substr($relatedCourse->category, 0, 2) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2">{{ $relatedCourse->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $relatedCourse->teacher->name }}</p>
                                    <p class="text-sm font-semibold text-indigo-600">₹{{ number_format($relatedCourse->price) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
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