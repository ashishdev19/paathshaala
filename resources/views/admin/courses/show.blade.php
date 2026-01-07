<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Course Header -->
            <div class="relative bg-gray-200">
                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-auto">
            </div>

            <!-- Course Details -->
            <div class="p-8">
                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Price Card -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                        <div class="text-sm text-gray-600 mb-2">Price</div>
                        <div class="text-2xl font-bold text-green-600">₹{{ number_format($course->price ?? 0, 2) }}</div>
                    </div>

                    <!-- Category Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                        <div class="text-sm text-gray-600 mb-2">Category</div>
                        <div class="text-lg font-semibold text-blue-600">{{ $course->category->name ?? 'General' }}</div>
                    </div>

                    <!-- Enrollments Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                        <div class="text-sm text-gray-600 mb-2">Enrollments</div>
                        <div class="text-2xl font-bold text-purple-600">{{ $course->enrollments->count() }}</div>
                    </div>

                    <!-- Status Card -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 border border-orange-200">
                        <div class="text-sm text-gray-600 mb-2">Status</div>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if($course->status === 'published') bg-green-100 text-green-800
                            @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($course->status ?? 'draft') }}
                        </span>
                    </div>
                </div>

                <!-- Instructor Info -->
                @if($course->teacher)
                <div class="mb-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Instructor</h3>
                    <div class="flex items-center">
                        @if($course->teacher->profile_photo_url)
                            <img src="{{ $course->teacher->profile_photo_url }}" 
                                 alt="{{ $course->teacher->name }}" 
                                 class="w-16 h-16 rounded-full mr-4">
                        @else
                            <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mr-4">
                                {{ $course->teacher->initials }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $course->teacher->name }}</h4>
                            <p class="text-gray-600">{{ $course->teacher->email }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $course->description ?? 'No description provided.' }}</p>
                </div>

                <!-- Course Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @if($course->duration_hours)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Duration</h4>
                        <p class="text-gray-600">{{ $course->duration_hours }} hours</p>
                    </div>
                    @endif

                    @if($course->level)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Level</h4>
                        <p class="text-gray-600">{{ ucfirst($course->level) }}</p>
                    </div>
                    @endif

                    @if($course->language)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Language</h4>
                        <p class="text-gray-600">{{ $course->language }}</p>
                    </div>
                    @endif

                    @if($course->is_active !== null)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Active Status</h4>
                        <p class="text-gray-600">
                            <span class="px-2 py-1 rounded text-sm {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Created</h4>
                        <p class="text-gray-600">{{ $course->created_at->format('M d, Y') }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Last Updated</h4>
                        <p class="text-gray-600">{{ $course->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Reviews Summary -->
                @if($course->reviews->count() > 0)
                <div class="mb-8 bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Reviews</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Reviews</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $course->reviews->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Average Rating</p>
                            <div class="flex items-center">
                                <p class="text-2xl font-bold text-yellow-600">{{ number_format($course->reviews->avg('rating'), 1) }}</p>
                                <span class="ml-2 text-yellow-400">★</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Syllabus -->
                @if($course->syllabus && isset($course->syllabus['pdf']))
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Course Syllabus</h3>
                    <a href="{{ asset('storage/' . $course->syllabus['pdf']) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z" clip-rule="evenodd"></path>
                        </svg>
                        Download Syllabus PDF
                    </a>
                </div>
                @endif

                <!-- Video URL -->
                @if($course->video_url)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Course Video</h3>
                    <a href="{{ $course->video_url }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                        </svg>
                        Watch Video
                    </a>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex gap-3 border-t border-gray-200 pt-6">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-center font-medium">
                        Edit Course
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 text-center font-medium">
                        Back to Courses
                    </a>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this course?')" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium">
                            Delete Course
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
