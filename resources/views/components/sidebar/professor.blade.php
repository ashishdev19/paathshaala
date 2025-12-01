{{-- Professor/Teacher Sidebar Component --}}
<aside class="w-64 bg-green-900 text-white min-h-screen">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-8">Professor Panel</h2>

        <nav class="space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('instructor.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('instructor.dashboard') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- My Courses --}}
            <a href="{{ route('instructor.courses.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('instructor.courses*') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>My Courses</span>
            </a>

            {{-- My Students --}}
            <a href="{{ route('instructor.students.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('instructor.students') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>My Students</span>
            </a>

            {{-- Classes --}}
            <a href="{{ route('instructor.classes.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('instructor.classes') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span>Online Classes</span>
            </a>

            {{-- Profile --}}
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profile</span>
            </a>
        </nav>
    </div>
</aside>
