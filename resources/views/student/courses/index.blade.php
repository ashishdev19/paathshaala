<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            My Courses
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($enrollments as $enrollment)
        @php
            $course = $enrollment->course;
        @endphp
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            <div class="h-48 bg-gray-200 relative">
                @if($course->thumbnail)
                    <img src="/storage/{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                @endif
                <!-- Enrollment Status Badge -->
                <span class="absolute top-2 right-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded">
                    {{ ucfirst($enrollment->status) }}
                </span>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">{{ $course->category->name ?? 'General' }}</span>
                    <span class="text-sm text-gray-500">{{ $course->level ?? 'All Levels' }}</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $course->description }}</p>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ $course->teacher->name ?? 'Unknown' }}
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $enrollment->progress_percentage ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <span class="text-sm text-gray-500">Enrolled: {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : ($enrollment->created_at ? $enrollment->created_at->format('M d, Y') : 'N/A') }}</span>
                    <a href="{{ route('courses.show', $course->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Continue Learning
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <p class="text-gray-500 text-lg mb-2">No enrolled courses yet</p>
            <p class="text-gray-400 text-sm">Browse available courses and start learning!</p>
        </div>
        @endforelse
    </div>

    @if(isset($enrollments) && $enrollments->hasPages())
    <div class="mt-6">
        {{ $enrollments->links() }}
    </div>
    @endif
</x-layouts.student>
