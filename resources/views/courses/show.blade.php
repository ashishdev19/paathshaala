<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Course Header -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        @if($course->thumbnail)
                            <img class="h-48 w-full object-cover md:w-48" 
                                 src="/storage/{{ $course->thumbnail }}" 
                                 alt="{{ $course->title }}">
                        @else
                            <div class="h-48 w-full md:w-48 bg-blue-100 flex items-center justify-center">
                                <svg class="w-20 h-20 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-8 flex-1">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ $course->category->name ?? 'General' }}</div>
                        <h1 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            {{ $course->title }}
                        </h1>
                        <p class="mt-4 text-gray-600">{{ $course->description }}</p>
                        
                        <div class="mt-6 flex items-center gap-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $course->teacher->name ?? 'N/A' }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ number_format($course->reviews_avg_rating ?? 4.5, 1) }} ({{ $course->reviews_count ?? 0 }} reviews)
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                {{ $course->enrollments_count ?? 0 }} students
                            </div>
                            @php
                                // Support multiple possible DB field names for course start/end dates
                                $startRaw = $course->batch_start_date ?? $course->start_date ?? $course->course_start_date ?? $course->start ?? null;
                                $endRaw = $course->batch_end_date ?? $course->end_date ?? $course->course_end_date ?? $course->end ?? null;
                                $start = $startRaw ? \Carbon\Carbon::parse($startRaw)->format('d M Y') : null;
                                $end = $endRaw ? \Carbon\Carbon::parse($endRaw)->format('d M Y') : null;
                            @endphp

                            @if($start || $end)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @if($start && $end)
                                        {{ $start }} — {{ $end }}
                                    @elseif($start)
                                        Starts: {{ $start }}
                                    @else
                                        Ends: {{ $end }}
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <div class="text-3xl font-bold text-gray-900">
                                ₹{{ number_format($course->price, 2) }}
                            </div>
                            @if(!$isEnrolled)
                                @auth
                                    <a href="{{ route('enrollment.checkout', $course->id) }}" 
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Enroll Now
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Login to Enroll
                                    </a>
                                @endauth
                            @else
                                <a href="#course-content" 
                                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Already Enrolled - Go to Course
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8" id="course-content">
                    <!-- What you'll learn -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">What you'll learn</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    <!-- Course Content -->
                    @if($course->onlineClasses && $course->onlineClasses->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Course Content</h2>
                        <div class="space-y-2">
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
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Course Curriculum</h2>
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
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-700">{{ $lecture->title }}</span>
                                        </div>
                                        @if($isEnrolled && $lecture->video_url)
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Video</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Reviews Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Student Reviews</h2>
                        
                        {{-- Success/Error Messages --}}
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Review Form for Enrolled Students --}}
                        @auth
                            @if($isEnrolled)
                                @php
                                    $hasReviewed = $course->reviews->where('student_id', auth()->id())->count() > 0;
                                @endphp
                                
                                @if(!$hasReviewed)
                                    <div class="bg-gray-50 rounded-lg p-5 mb-6 border border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Write a Review</h3>
                                        <form action="{{ route('student.courses.review.store', $course->id) }}" method="POST">
                                            @csrf
                                            
                                            {{-- Star Rating --}}
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                                                <div class="flex items-center space-x-1" id="star-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="button" 
                                                            class="star-btn text-3xl focus:outline-none transition-colors duration-150 text-gray-300 hover:text-yellow-400"
                                                            data-rating="{{ $i }}"
                                                            onclick="setRating({{ $i }})">
                                                            ★
                                                        </button>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="rating-input" value="" required>
                                                @error('rating')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            {{-- Review Text --}}
                                            <div class="mb-4">
                                                <label for="review_text" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                                                <textarea 
                                                    name="review_text" 
                                                    id="review_text" 
                                                    rows="4" 
                                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Share your experience with this course..."
                                                    required
                                                    minlength="10"
                                                    maxlength="1000">{{ old('review_text') }}</textarea>
                                                @error('review_text')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <button type="submit" 
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-150">
                                                Submit Review
                                            </button>
                                        </form>
                                    </div>

                                    <script>
                                        function setRating(rating) {
                                            document.getElementById('rating-input').value = rating;
                                            const stars = document.querySelectorAll('.star-btn');
                                            stars.forEach((star, index) => {
                                                if (index < rating) {
                                                    star.classList.remove('text-gray-300');
                                                    star.classList.add('text-yellow-400');
                                                } else {
                                                    star.classList.remove('text-yellow-400');
                                                    star.classList.add('text-gray-300');
                                                }
                                            });
                                        }
                                    </script>
                                @else
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                        <p class="text-green-700">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            You have already reviewed this course. Thank you!
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                    <p class="text-blue-700">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Enroll in this course to leave a review.
                                    </p>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                                <p class="text-gray-700">
                                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a> to leave a review.
                                </p>
                            </div>
                        @endauth

                        {{-- Existing Reviews --}}
                        @if($course->reviews && $course->reviews->count() > 0)
                            <div class="space-y-4">
                                @foreach($course->reviews->take(5) as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">{{ $review->student->name ?? 'Student' }}</span>
                                        <span class="ml-2 text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700">{{ $review->review_text ?? $review->comment }}</p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No reviews yet. Be the first to review this course!</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Instructor -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Instructor</h3>
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-semibold text-lg">
                                    {{ substr($course->teacher->name ?? 'T', 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">{{ $course->teacher->name ?? 'Teacher' }}</p>
                                <p class="text-sm text-gray-600">{{ $course->teacher->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Course Features -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">This course includes</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">{{ $course->is_lifetime ? 'Lifetime' : $course->validity_period . ' ' . $course->validity_unit }} access</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Certificate of completion</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Access on mobile and desktop</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Related Courses -->
            @if($relatedCourses && $relatedCourses->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedCourses as $related)
                    <a href="{{ route('courses.show', $related->id) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($related->thumbnail)
                            <img class="h-48 w-full object-cover" src="/storage/{{ $related->thumbnail }}" alt="{{ $related->title }}">
                        @else
                            <div class="h-48 w-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $related->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($related->description, 80) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-gray-900">₹{{ number_format($related->price, 2) }}</span>
                                <span class="text-sm text-gray-600">{{ $related->enrollments_count }} students</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.student>
