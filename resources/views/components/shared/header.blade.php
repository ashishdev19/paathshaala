@props(['role' => 'admin'])

@php
$bgColor = match($role) {
    'admin' => 'bg-gray-900',
    'professor', 'teacher' => 'bg-gray-900',
    'student' => 'bg-gray-900',
    default => 'bg-gray-900'
};

$dashboardRoute = match($role) {
    'admin' => 'admin.dashboard',
    'professor', 'teacher' => 'instructor.dashboard',
    'student' => 'student.dashboard',
    default => 'dashboard'
};
@endphp

<header class="{{ $bgColor }} text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <!-- Logo/Title can be added here if needed -->
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route($dashboardRoute) }}" class="hover:text-indigo-300">Dashboard</a>
                <!-- <a href="{{ route('home') }}" class="hover:text-indigo-300" target="_blank">View Site</a> -->
                
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 hover:text-indigo-300">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
