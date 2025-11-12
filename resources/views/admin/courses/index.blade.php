<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Courses Management') }}
            </h2>
            <a href="{{ route('admin.courses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Add New Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Courses Analytics Dashboard -->
            <div class="mb-8">
                <!-- <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Analytics Overview</h3> -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Total Courses Card -->
                    <div class="floating-card bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-book text-blue-600 text-lg"></i>
                                        </div>
                                        <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Total Courses</p>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($courses->total()) }}</p>
                                        <div class="flex items-center space-x-1">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <p class="text-gray-500 text-xs font-medium">All available courses</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-3 shadow-lg">
                                    <i class="fas fa-chart-bar text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                    </div>

                    <!-- Published Courses Card -->
                    <div class="floating-card bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                                        </div>
                                        <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Published</p>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($courses->where('status', 'published')->count()) }}</p>
                                        <div class="flex items-center space-x-1">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <p class="text-gray-500 text-xs font-medium">Live and available</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-full p-3 shadow-lg">
                                    <i class="fas fa-globe text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="h-2 bg-gradient-to-r from-green-500 to-green-600"></div>
                    </div>

                    <!-- Featured Courses Card -->
                    <div class="floating-card bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-star text-yellow-600 text-lg"></i>
                                        </div>
                                        <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Featured</p>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($courses->where('is_featured', 1)->count()) }}</p>
                                        <div class="flex items-center space-x-1">
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                            <p class="text-gray-500 text-xs font-medium">Highlighted courses</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full p-3 shadow-lg">
                                    <i class="fas fa-crown text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="h-2 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
                    </div>

                    <!-- Total Enrollments Card -->
                    <div class="floating-card bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-users text-purple-600 text-lg"></i>
                                        </div>
                                        <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Enrollments</p>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($courses->sum('enrollments_count')) }}</p>
                                        <div class="flex items-center space-x-1">
                                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                            <p class="text-gray-500 text-xs font-medium">Total student enrollments</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-full p-3 shadow-lg">
                                    <i class="fas fa-user-graduate text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="h-2 bg-gradient-to-r from-purple-500 to-purple-600"></div>
                    </div>
                </div>

                <!-- Quick Actions Bar -->

                <!-- <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <h4 class="text-sm font-medium text-gray-700">Quick Actions:</h4>
                            <a href="{{ route('admin.courses.create') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="fas fa-plus mr-2"></i>Add Course
                            </a>
                            <button onclick="window.print()" class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="fas fa-print mr-2"></i>Print Report
                            </button>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            Last updated: {{ now()->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Courses Grid --><br/>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Courses Directory</h3>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Showing {{ $courses->count() }} of {{ $courses->total() }} courses</span>
                        </div>
                    </div>
                </div>
                
                @if($courses->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($courses as $course)
                                <div class="floating-card bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 overflow-hidden group">
                                    <!-- Course Thumbnail -->
                                    <div class="relative h-48 bg-gradient-to-br from-indigo-500 to-purple-600 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 transition-all duration-300 group-hover:scale-110"></div>
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center h-full z-10">
                                                <i class="fas fa-book text-white text-4xl opacity-70 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Status Badge -->
                                        <div class="absolute top-3 left-3 z-20">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium backdrop-blur-sm transition-all duration-300 group-hover:scale-105
                                                @if($course->status === 'published') bg-green-100 text-green-800
                                                @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                @if($course->status === 'published') 
                                                    <i class="fas fa-check-circle mr-1"></i>Published
                                                @elseif($course->status === 'draft')
                                                    <i class="fas fa-edit mr-1"></i>Draft
                                                @else
                                                    <i class="fas fa-archive mr-1"></i>Archived
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Featured Badge -->
                                        @if($course->is_featured)
                                            <div class="absolute top-3 right-3 z-20">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 backdrop-blur-sm transition-all duration-300 group-hover:scale-105 group-hover:rotate-1">
                                                    <i class="fas fa-star mr-1"></i>Featured
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Course Content -->
                                    <div class="p-6">
                                        <div class="mb-3">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>
                                            <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit($course->description, 120) }}</p>
                                        </div>

                                        <!-- Course Meta -->
                                        <div class="space-y-2 mb-4">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-500">Instructor:</span>
                                                <span class="font-medium text-gray-900">{{ $course->teacher->name ?? 'No instructor assigned' }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-500">Category:</span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $course->category }}
                                                </span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-500">Level:</span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($course->level === 'beginner') bg-green-100 text-green-800
                                                    @elseif($course->level === 'intermediate') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($course->level) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Course Stats -->
                                        <div class="flex items-center justify-between mb-4 py-3 px-3 bg-gray-50 rounded-lg">
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-gray-900">₹{{ number_format($course->price, 2) }}</div>
                                                <div class="text-xs text-gray-500">Price</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-gray-900">{{ $course->enrollments_count }}</div>
                                                <div class="text-xs text-gray-500">Students</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-gray-900">{{ $course->duration }}h</div>
                                                <div class="text-xs text-gray-500">Duration</div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.courses.show', $course) }}" 
                                               class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 hover:text-indigo-800 rounded-md transition-all duration-150 ease-in-out text-sm font-medium transform hover:scale-105">
                                                <i class="fas fa-eye mr-2"></i>View
                                            </a>
                                            <a href="{{ route('admin.courses.edit', $course) }}" 
                                               class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 hover:text-green-800 rounded-md transition-all duration-150 ease-in-out text-sm font-medium transform hover:scale-105">
                                                <i class="fas fa-edit mr-2"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 rounded-md transition-all duration-150 ease-in-out text-sm font-medium transform hover:scale-105"
                                                        onclick="return confirm('Are you sure you want to delete {{ $course->title }}? This action cannot be undone.')"
                                                    <i class="fas fa-trash mr-2"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-12">
                        <div class="text-center">
                            <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                                <i class="fas fa-book text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No courses found</h3>
                            <p class="text-gray-500 mb-4">Get started by creating your first course.</p>
                            <a href="{{ route('admin.courses.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-plus mr-2"></i>Add First Course
                            </a>
                        </div>
                    </div>
                @endif
                
                @if($courses->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>