{{-- Student Sidebar Component --}}
<aside class="w-64 bg-blue-900 text-white min-h-screen">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-8">Student Panel</h2>

        <nav class="space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-blue-600' : 'hover:bg-blue-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- My Courses --}}
            <a href="{{ route('student.courses') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('student.courses') ? 'bg-blue-600' : 'hover:bg-blue-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>My Courses</span>
            </a>

            {{-- Browse Courses --}}
            <a href="{{ route('student.courses.browse') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('student.courses.browse') ? 'bg-blue-600' : 'hover:bg-blue-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span>Browse Courses</span>
            </a>

            {{-- Enrollments --}}
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Enrollments</span>
            </a>

            {{-- Certificates --}}
            <a href="{{ route('student.certificates') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('student.certificates') ? 'bg-blue-600' : 'hover:bg-blue-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <span>Certificates</span>
            </a>

            {{-- Profile --}}
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-blue-600' : 'hover:bg-blue-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profile</span>
            </a>
        </nav>
    </div>
</aside>
