@php
    // Handle both courseDetail and coursePreview contexts
    if (isset($enrollment)) {
        $course = $enrollment->course;
    }
@endphp

<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Course Details
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Course Header -->
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="h-64 bg-gray-200">
                    @if($course->thumbnail)
                        <img src="/storage/{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://via.placeholder.com/800x400" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-lg">{{ $course->category->name ?? 'General' }}</span>
                        <span class="ml-2 px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-lg">{{ ucfirst($course->level ?? 'beginner') }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->title }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600 mb-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $course->teacher->name ?? 'Unknown' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-400 fill-current mr-1" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            {{ number_format($course->rating ?? 4.5, 1) }} ({{ $course->reviews_count ?? 0 }} reviews)
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $course->enrollments_count ?? 0 }} students enrolled
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Description -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">About This Course</h2>
                <div class="text-gray-700 leading-relaxed">
                    {{ $course->description }}
                </div>
            </div>

            <!-- What You'll Learn -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">What You'll Learn</h2>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Comprehensive course content</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Live online classes with instructor</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Certificate upon completion</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Lifetime access to course materials</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Enrollment Card -->
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <div class="text-center mb-6">
                    <p class="text-gray-600 text-sm mb-2">Course Price</p>
                    <p class="text-4xl font-bold text-blue-600">₹{{ number_format($course->price, 2) }}</p>
                </div>
                <a href="{{ route('enrollment.checkout', $course->id) }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold mb-4 text-center">
                    Enroll Now
                </a>
                <div class="border-t border-gray-200 pt-4 space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $course->duration ?? '30' }} hours of content
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Live online classes
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Downloadable resources
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Certificate of completion
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.student>
