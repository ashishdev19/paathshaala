<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Course Details: ') . $course->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.courses.edit', $course) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Course
                </a>
                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out"
                            onclick="return confirm('Are you sure you want to delete {{ $course->title }}? This action cannot be undone.')">
                        <i class="fas fa-trash mr-2"></i>Delete Course
                    </button>
                </form>
                <a href="{{ route('admin.courses.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Courses
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Course Information Card -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Course Header -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="relative h-64 bg-gradient-to-br from-indigo-500 to-purple-600">
                            @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <i class="fas fa-book text-white text-6xl opacity-50"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-end">
                                <div class="p-6 text-white">
                                    <h1 class="text-3xl font-bold mb-2">{{ $course->title }}</h1>
                                    <div class="flex items-center space-x-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20">
                                            <i class="fas fa-user mr-2"></i>{{ $course->teacher->name ?? 'No instructor' }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20">
                                            <i class="fas fa-tag mr-2"></i>{{ $course->category }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Course Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
                        </div>
                    </div>

                    <!-- Course Enrollments -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Enrollments ({{ $course->enrollments->count() }})</h3>
                            
                            @if($course->enrollments->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled Date</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($course->enrollments as $enrollment)
                                                <tr>
                                                    <td class="px-4 py-4">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-8 w-8">
                                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                    <span class="text-indigo-600 font-medium text-xs">
                                                                        {{ strtoupper(substr($enrollment->user->name, 0, 2)) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-3">
                                                                <div class="text-sm font-medium text-gray-900">{{ $enrollment->user->name }}</div>
                                                                <div class="text-sm text-gray-500">{{ $enrollment->user->email }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if($enrollment->payment_status === 'paid') bg-green-100 text-green-800
                                                            @elseif($enrollment->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ ucfirst($enrollment->payment_status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4 text-sm text-gray-500">
                                                        {{ $enrollment->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <div class="flex items-center">
                                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                                                            </div>
                                                            <span class="ml-2 text-sm text-gray-500">{{ $enrollment->progress_percentage ?? 0 }}%</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">No student enrollments yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Course Reviews -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Reviews ({{ $course->reviews->count() }})</h3>
                            
                            @if($course->reviews->count() > 0)
                                <div class="space-y-4">
                                    @foreach($course->reviews as $review)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-indigo-600 font-medium text-xs">
                                                            {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-sm font-medium text-gray-900">{{ $review->user->name }}</h4>
                                                        <div class="flex items-center mt-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                            @endfor
                                                            <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 text-sm text-gray-700">{{ $review->review }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">No reviews yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Course Stats Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Course Statistics</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Price</span>
                                    <span class="text-lg font-bold text-green-600">${{ number_format($course->price, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Duration</span>
                                    <span class="text-sm text-gray-900">{{ $course->duration }} hours</span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Level</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($course->level === 'beginner') bg-green-100 text-green-800
                                        @elseif($course->level === 'intermediate') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Status</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($course->status === 'published') bg-green-100 text-green-800
                                        @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Featured</span>
                                    @if($course->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>Yes
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">No</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Total Enrollments</span>
                                    <span class="text-sm font-bold text-indigo-600">{{ $course->enrollments->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Average Rating</span>
                                    @if($course->reviews->count() > 0)
                                        <div class="flex items-center">
                                            <span class="text-sm font-bold text-yellow-600">{{ number_format($course->reviews->avg('rating'), 1) }}</span>
                                            <i class="fas fa-star text-yellow-400 ml-1 text-xs"></i>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">No ratings</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-sm font-medium text-gray-700">Created</span>
                                    <span class="text-sm text-gray-500">{{ $course->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    @if($course->teacher)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Instructor</h3>
                                <div class="text-center">
                                    <div class="mx-auto h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                        <span class="text-indigo-600 font-bold text-xl">
                                            {{ strtoupper(substr($course->teacher->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $course->teacher->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-3">{{ $course->teacher->email }}</p>
                                    @if($course->teacher->phone)
                                        <p class="text-sm text-gray-600">{{ $course->teacher->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>