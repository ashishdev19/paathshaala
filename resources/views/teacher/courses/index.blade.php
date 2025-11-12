<x-teacher-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Courses') }}
            </h2>
            <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Create New Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Courses Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($courses as $course)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                                <!-- Course Image -->
                                <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                    <h3 class="text-white text-xl font-bold text-center px-4">
                                        {{ $course->title }}
                                    </h3>
                                </div>
                                
                                <!-- Course Content -->
                                <div class="p-6">
                                    <div class="mb-4">
                                        <p class="text-gray-600 text-sm line-clamp-3">
                                            {{ Str::limit($course->description, 100) }}
                                        </p>
                                    </div>
                                    
                                    <!-- Course Stats -->
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-gray-900">{{ $course->enrollments_count }}</div>
                                                <div class="text-xs text-gray-500">Students</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-green-600">₹{{ number_format($course->price, 0) }}</div>
                                                <div class="text-xs text-gray-500">Price</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($course->status === 'active') bg-green-100 text-green-800
                                                @elseif($course->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($course->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="#" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                            View Details
                                        </a>
                                        <a href="#" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="max-w-md mx-auto">
                                    <div class="mb-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No courses yet</h3>
                                    <p class="text-gray-500 mb-6">Get started by creating your first course.</p>
                                    <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Create New Course
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($courses->hasPages())
                        <div class="mt-8">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>