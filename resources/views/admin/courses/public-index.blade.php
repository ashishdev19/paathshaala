<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses - {{ config('app.name', 'Medniks') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
@php
    use Illuminate\Support\Facades\Storage;
@endphp
<body class="bg-gray-50">
    @include('shared.partials.header')
<div class="min-h-screen bg-gray-50 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Browse Courses</h1>
            <p class="text-lg text-gray-600">Explore our comprehensive collection of courses and start learning today</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('courses.index') }}" id="course-filters">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="search">Search</label>
                        <input id="search" name="search" type="text" placeholder="Search courses"
                            value="{{ request('search') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="category">Category</label>
                        <select id="category" name="category"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 auto-submit">
                            <option value="">All Categories</option>
                            <option value="Medical" {{ request('category') === 'Medical' ? 'selected' : '' }}>Medical</option>
                            <option value="Nursing" {{ request('category') === 'Nursing' ? 'selected' : '' }}>Nursing</option>
                            <option value="Pharmacy" {{ request('category') === 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="level">Level</label>
                        <select id="level" name="level"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 auto-submit">
                            <option value="">All Levels</option>
                            <option value="Beginner" {{ request('level') === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ request('level') === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ request('level') === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="sort">Sort By</label>
                        <select id="sort" name="sort"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 auto-submit">
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Courses Grid -->
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden flex flex-col h-full">
                        <!-- Course Image -->
                        <div class="relative bg-gray-200 h-48">
                            @if($course->thumbnail)
                                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.querySelector('.fallback-icon').style.display='flex';">
                                <div class="fallback-icon w-full h-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 absolute inset-0" style="display: none;">
                                    <i class="fas fa-book text-white text-6xl opacity-50"></i>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">
                                    <i class="fas fa-book text-white text-6xl opacity-50"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $course->level ?? 'Beginner' }}
                                </span>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-4 flex flex-col flex-grow">
                            <!-- Teacher -->
                            <div class="flex items-center mb-2">
                                @if($course->teacher->profile_photo_path)
                                    <img src="{{ Storage::url($course->teacher->profile_photo_path) }}" alt="{{ $course->teacher->name }}" class="w-8 h-8 rounded-full mr-2 object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-8 h-8 rounded-full mr-2 bg-gradient-to-br from-blue-500 to-indigo-600 items-center justify-center text-white text-sm font-semibold" style="display: none;">
                                        {{ strtoupper(substr($course->teacher->name, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full mr-2 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-semibold">
                                        {{ strtoupper(substr($course->teacher->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-sm text-gray-600">{{ $course->teacher->name }}</span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $course->description }}</p>

                            <!-- Rating -->
                            <div class="flex items-center mb-3">
                                @if($course->reviews_count > 0)
                                    @php
                                        $avgRating = $course->reviews->avg('rating');
                                    @endphp
                                    <div class="flex text-yellow-400">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < round($avgRating))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600 ml-2">({{ $course->reviews_count }})</span>
                                @else
                                    <span class="text-sm text-gray-500">No ratings yet</span>
                                @endif
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4 py-2 border-y mt-auto">
                                <span><i class="fas fa-users mr-1"></i>{{ $course->enrollments_count ?? 0 }} students</span>
                                <span><i class="fas fa-clock mr-1"></i>{{ $course->duration ?? 0 }} hours</span>
                            </div>

                            <!-- Price and Button -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-bold text-gray-900">₹{{ number_format($course->price ?? 0, 0) }}</span>
                                    @if($course->original_price && $course->original_price > $course->price)
                                        <span class="text-sm text-gray-500 line-through ml-2">₹{{ number_format($course->original_price, 0) }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="{{ route('courses.show', $course->id) }}" class="block w-full mt-4 bg-blue-600 text-white py-2 rounded-lg text-center hover:bg-blue-700 transition font-semibold">
                                View Course
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $courses->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-book fa-4x text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Courses Found</h3>
                <p class="text-gray-600 mb-6">We couldn't find any courses matching your criteria. Try adjusting your filters.</p>
                <a href="{{ route('courses.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Browse All Courses
                </a>
            </div>
        @endif
    </div>
</div>

<footer>
    <!-- Newsletter Section -->
    <div class="py-16" style="background-color: #008080;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-4xl font-bold mb-4 text-white">Stay Updated with Medical Insights</h3>
            <p class="text-xl text-teal-100 mb-8 max-w-2xl mx-auto">Get the latest medical research updates, course announcements, and exclusive healthcare content delivered to your inbox.</p>
            <div class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-2xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-teal-300">
                <button class="px-8 py-4 bg-white text-teal-700 rounded-2xl font-semibold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">Subscribe</button>
            </div>
        </div>
    </div>
    
    <div class="text-white py-12 mt-0" style="background-color: #008080;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white">{{ config('app.name') }}</h3>
                    <p class="text-teal-100 mb-4">Empowering medical professionals through quality education and training</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="Facebook">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="Instagram">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="YouTube">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Platform</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('courses.index') }}" class="hover:text-teal-50 transition-colors">Browse Courses</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-teal-50 transition-colors">About Us</a></li>
                        <li><a href="#faculty" class="hover:text-teal-50 transition-colors">Our Faculty</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-teal-50 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Specializations -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Specializations</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-teal-50 transition-colors">Aesthetic Medicine</a></li>
                        <li><a href="#" class="hover:text-teal-50 transition-colors">Aesthetic Gynecology</a></li>
                        <li><a href="#" class="hover:text-teal-50 transition-colors">Ultrasound</a></li>
                        <li><a href="#" class="hover:text-teal-50 transition-colors">IVF & Reproductive Medicine</a></li>
                        <li><a href="#" class="hover:text-teal-50 transition-colors">Surgical Courses</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Contact Us</h4>
                    <ul class="space-y-2 text-teal-100">
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
            <div class="border-t border-teal-200/60 pt-6 text-center text-teal-50">
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
    </div>
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

    // Auto-submit select filters for quicker interactions
    document.querySelectorAll('#course-filters .auto-submit').forEach(function(select) {
        select.addEventListener('change', function() {
            document.getElementById('course-filters').submit();
        });
    });

    // Auto-submit search with a small debounce so typing feels responsive
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                document.getElementById('course-filters').submit();
            }, 400);
        });

        // Submit immediately on Enter key for accessibility
        searchInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('course-filters').submit();
            }
        });
    }
</script>

    </body>
    </html>
