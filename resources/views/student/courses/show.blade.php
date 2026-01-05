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

            <!-- Course Content -->
            <div id="course-content" class="space-y-6">
                @php
                    $mainVideo = $course->video_url ?: ($course->video_file ?: $course->promo_video_url);
                    $isYouTube = str_contains($mainVideo, 'youtube.com') || str_contains($mainVideo, 'youtu.be');
                @endphp
                @if($isEnrolled && ($mainVideo || ($course->syllabus && isset($course->syllabus['pdf'])) || $course->demo_pdf || $course->demo_lecture))
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Course Materials</h2>
                    <div class="space-y-6">
                        @if($mainVideo)
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">Course Video</h3>
                            <div class="aspect-video bg-black rounded-lg overflow-hidden shadow-lg">
                                @if($isYouTube)
                                    @php
                                        $videoId = '';
                                        if (str_contains($mainVideo, 'youtu.be/')) {
                                            $videoId = explode('youtu.be/', $mainVideo)[1];
                                            if (str_contains($videoId, '?')) {
                                                $videoId = explode('?', $videoId)[0];
                                            }
                                        } else {
                                            parse_str(parse_url($mainVideo, PHP_URL_QUERY), $params);
                                            $videoId = $params['v'] ?? '';
                                        }
                                    @endphp
                                    @if($videoId)
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full min-h-[400px]"></iframe>
                                    @else
                                        <div class="flex items-center justify-center h-full text-white p-12 text-center">
                                            <div>
                                                <p class="mb-4">Video link detected but could not be embedded.</p>
                                                <a href="{{ $mainVideo }}" target="_blank" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">Watch on YouTube</a>
                                            </div>
                                        </div>
                                    @endif
                                @elseif($course->video_file)
                                    @php
                                        $videoPath = $course->video_file;
                                        if (!str_starts_with($videoPath, 'storage/') && !str_starts_with($videoPath, '/storage/')) {
                                            $videoPath = 'storage/' . $videoPath;
                                        }
                                        if (!str_starts_with($videoPath, '/')) {
                                            $videoPath = '/' . $videoPath;
                                        }
                                    @endphp
                                    <video src="{{ $videoPath }}" controls class="w-full h-full"></video>
                                @else
                                    <video src="{{ $mainVideo }}" controls class="w-full h-full"></video>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($course->syllabus && isset($course->syllabus['pdf']))
                            <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg border border-indigo-100">
                                <div class="flex items-center">
                                    <svg class="h-8 w-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-indigo-900">Course Syllabus</p>
                                        <p class="text-sm text-indigo-700">PDF Document</p>
                                    </div>
                                </div>
                                <a href="/storage/{{ $course->syllabus['pdf'] }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold transition">
                                    View
                                </a>
                            </div>
                            @endif

                            @if($course->demo_pdf)
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-100">
                                <div class="flex items-center">
                                    <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-green-900">Study Material</p>
                                        <p class="text-sm text-green-700">PDF Document</p>
                                    </div>
                                </div>
                                <a href="{{ str_starts_with($course->demo_pdf, 'storage/') ? '/' . $course->demo_pdf : '/storage/' . $course->demo_pdf }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-semibold transition">
                                    View
                                </a>
                            </div>
                            @endif
                        </div>

                        @if($course->demo_lecture)
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">Demo Lecture</h3>
                            <div class="aspect-video bg-black rounded-lg overflow-hidden shadow-lg">
                                @if(str_contains($course->demo_lecture, 'youtube.com') || str_contains($course->demo_lecture, 'youtu.be'))
                                    @php
                                        $demoVideoId = '';
                                        if (str_contains($course->demo_lecture, 'youtu.be/')) {
                                            $demoVideoId = explode('youtu.be/', $course->demo_lecture)[1];
                                            if (str_contains($demoVideoId, '?')) {
                                                $demoVideoId = explode('?', $demoVideoId)[0];
                                            }
                                        } else {
                                            parse_str(parse_url($course->demo_lecture, PHP_URL_QUERY), $demoParams);
                                            $demoVideoId = $demoParams['v'] ?? '';
                                        }
                                    @endphp
                                    @if($demoVideoId)
                                        <iframe src="https://www.youtube.com/embed/{{ $demoVideoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full min-h-[400px]"></iframe>
                                    @endif
                                @else
                                    <video src="{{ $course->demo_lecture }}" controls class="w-full h-full"></video>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($course->onlineClasses && $course->onlineClasses->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Online Classes</h2>
                    <div class="space-y-3">
                        @foreach($course->onlineClasses as $class)
                        <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $class->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $class->description }}</p>
                            </div>
                            @if($isEnrolled)
                                <div class="flex space-x-2">
                                    @if($class->type == 'recorded' && $class->video_url)
                                        <a href="{{ route('online-classes.watch', $class->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">
                                            Watch Recording
                                        </a>
                                    @elseif($class->type == 'live' && $class->meeting_link)
                                        <a href="{{ $class->meeting_link }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-semibold">
                                            Join Live Class
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Course Curriculum -->
                @if($course->sections && $course->sections->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Course Curriculum</h2>
                    <div class="space-y-4">
                        @foreach($course->sections as $section)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="font-bold text-gray-800">{{ $section->title }}</h3>
                                <span class="text-sm text-gray-500">{{ $section->lectures->count() }} lectures</span>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @foreach($section->lectures as $lecture)
                                <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                                    <div class="flex items-center">
                                        @if($lecture->type == 'video')
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($lecture->type == 'pdf')
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @endif
                                        
                                        @if($isEnrolled)
                                            <a href="{{ route('student.lectures.watch', $lecture->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                {{ $lecture->title }}
                                            </a>
                                        @else
                                            <span class="text-gray-700">{{ $lecture->title }}</span>
                                        @endif
                                    </div>
                                    @if($isEnrolled)
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded uppercase">{{ $lecture->type }}</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($isEnrolled && 
                    (!$course->sections || $course->sections->count() == 0) && 
                    (!$course->onlineClasses || $course->onlineClasses->count() == 0) &&
                    !$mainVideo &&
                    !($course->syllabus && isset($course->syllabus['pdf'])) &&
                    !$course->demo_pdf &&
                    !$course->demo_lecture)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Course Content Coming Soon</h3>
                    <p class="text-blue-700">The instructor hasn't uploaded the curriculum yet. Please check back later or contact support if you have questions.</p>
                </div>
                @endif
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
                @if(!$isEnrolled)
                    <a href="{{ route('enrollment.checkout', $course->id) }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold mb-4 text-center">
                        Enroll Now
                    </a>
                @else
                    <a href="#course-content" class="block w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold mb-4 text-center">
                        Already Enrolled - Go to Course
                    </a>
                @endif
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
