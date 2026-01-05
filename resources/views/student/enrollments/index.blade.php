<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            My Enrollments
        </h2>
    </x-slot>

    <!-- Filters -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg shadow-md p-6 mb-6 border border-indigo-200">
        <div class="flex space-x-4">
            <a href="{{ route('student.enrollments.index') }}" 
               class="px-4 py-2 rounded-lg font-semibold shadow-md transition duration-300 {{ !$status ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white' : 'text-gray-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-200' }}">
                All
            </a>
            <a href="{{ route('student.enrollments.index', ['status' => 'active']) }}" 
               class="px-4 py-2 rounded-lg font-semibold shadow-md transition duration-300 {{ $status == 'active' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white' : 'text-gray-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-200' }}">
                Active
            </a>
            <a href="{{ route('student.enrollments.index', ['status' => 'completed']) }}" 
               class="px-4 py-2 rounded-lg font-semibold shadow-md transition duration-300 {{ $status == 'completed' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white' : 'text-gray-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-200' }}">
                Completed
            </a>
            <a href="{{ route('student.enrollments.index', ['status' => 'expired']) }}" 
               class="px-4 py-2 rounded-lg font-semibold shadow-md transition duration-300 {{ $status == 'expired' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white' : 'text-gray-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-200' }}">
                Expired
            </a>
        </div>
    </div>

    <!-- Enrollments Grid -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($enrollments ?? [] as $enrollment)
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-indigo-200 hover:shadow-xl transition duration-300">
            <div class="md:flex">
                <!-- Course Image -->
                <div class="md:flex-shrink-0">
                    <div class="w-full aspect-video md:w-64 bg-gray-100 relative overflow-hidden border-r border-gray-200">
                        <img src="{{ $enrollment->course->thumbnail ? '/storage/' . $enrollment->course->thumbnail : 'https://via.placeholder.com/300x200' }}" 
                             alt="{{ $enrollment->course->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
                <!-- Course Details -->
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $enrollment->course->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1 font-medium">by {{ $enrollment->course->teacher->name ?? 'Unknown' }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border
                            @if($enrollment->status == 'active') bg-gradient-to-r from-green-100 to-green-200 text-green-800 border-green-300
                            @elseif($enrollment->status == 'completed') bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border-blue-300
                            @else bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-gray-300 @endif">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-700">Course Progress</span>
                            <span class="text-sm font-bold text-indigo-600">{{ $enrollment->progress_percentage ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full shadow-md transition-all duration-500" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 text-sm">
                        <div>
                            <p class="font-semibold text-gray-700">Enrolled On</p>
                            <p class="text-gray-600">{{ $enrollment->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Expires On</p>
                            <p class="text-gray-600">{{ $enrollment->expires_at ? $enrollment->expires_at->format('M d, Y') : 'Lifetime' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Last Accessed</p>
                            <p class="text-gray-600">{{ $enrollment->updated_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Payment Status</p>
                            <p class="text-green-600 font-semibold">Paid</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <a href="{{ route('student.courses.show', $enrollment->course_id) }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold shadow-md transition duration-300">
                            Continue Learning
                        </a>
                        @if($enrollment->progress_percentage >= 100)
                        <a href="{{ route('student.certificates.download', $enrollment) }}" class="border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 font-semibold shadow-sm transition duration-300">
                            Download Certificate
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-md p-12 text-center border border-indigo-200">
            <svg class="mx-auto h-16 w-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <p class="mt-4 text-lg text-gray-600 font-semibold">No enrollments yet</p>
            <p class="mt-2 text-sm text-gray-500">Start your learning journey by enrolling in a course</p>
            <a href="{{ route('student.courses.index') }}" class="mt-6 inline-block bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold shadow-md transition duration-300">
                Browse Courses
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($enrollments) && $enrollments->hasPages())
    <div class="mt-6">
        {{ $enrollments->links() }}
    </div>
    @endif
</x-layouts.student>
