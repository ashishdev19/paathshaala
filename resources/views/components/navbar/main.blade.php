{{-- Main Navigation Bar --}}
<nav class="flex items-center space-x-6">
    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 font-medium {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">
        Home
    </a>
    <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium {{ request()->routeIs('courses.*') ? 'text-indigo-600' : '' }}">
        Courses
    </a>
    <a href="{{ route('about') }}" class="text-gray-700 hover:text-indigo-600 font-medium {{ request()->routeIs('about') ? 'text-indigo-600' : '' }}">
        About
    </a>
    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-indigo-600 font-medium {{ request()->routeIs('contact') ? 'text-indigo-600' : '' }}">
        Contact
    </a>
</nav>
