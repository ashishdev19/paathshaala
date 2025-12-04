{{-- DEPRECATED FILE --}}
{{-- This file is no longer used. Use /instructor/dashboard instead --}}
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">My Courses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['courses'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Students</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['students'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Enrollments Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Enrollments</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['enrollments'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a1 1 0 00-1-1h-1V9a6 6 0 00-12 0v6H2a1 1 0 00-1 1v2h17z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Actions -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">My Courses</h2>
            <div class="space-y-4">
                <a href="{{ route('professor.courses') }}" class="block p-4 border border-blue-200 rounded hover:bg-blue-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="text-2xl">📚</div>
                            <div>
                                <p class="font-medium text-gray-900">View All Courses</p>
                                <p class="text-sm text-gray-600">{{ $stats['courses'] ?? 0 }} courses</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('professor.students') }}" class="block p-4 border border-green-200 rounded hover:bg-green-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="text-2xl">👥</div>
                            <div>
                                <p class="font-medium text-gray-900">Manage Students</p>
                                <p class="text-sm text-gray-600">{{ $stats['students'] ?? 0 }} students total</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('teacher.subscription.create') }}" class="block p-4 border border-purple-200 rounded hover:bg-purple-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="text-2xl">📝</div>
                            <div>
                                <p class="font-medium text-gray-900">Create New Course</p>
                                <p class="text-sm text-gray-600">Add a new course</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Courses</span>
                        <span class="font-bold text-lg text-blue-600">{{ $stats['active_courses'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Modules</span>
                        <span class="font-bold text-lg text-green-600">{{ $stats['modules'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pending Assignments</span>
                        <span class="font-bold text-lg text-orange-600">{{ $stats['pending'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                <h3 class="text-lg font-bold text-blue-900 mb-2">💡 Tip</h3>
                <p class="text-sm text-blue-800">
                    Use the course management dashboard to view detailed analytics, student progress, and course materials.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
