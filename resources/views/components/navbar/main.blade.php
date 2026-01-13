{{-- Main Navigation Bar --}}
<nav class="flex items-center space-x-6">
    <a href="{{ route('home') }}" class="text-white hover:text-teal-200 font-medium {{ request()->routeIs('home') ? 'text-teal-200' : '' }}">
        Home
    </a>
    <a href="{{ route('courses.index') }}" class="text-white hover:text-teal-200 font-medium {{ request()->routeIs('courses.*') ? 'text-teal-200' : '' }}">
        Courses
    </a>
    <a href="{{ route('about') }}" class="text-white hover:text-teal-200 font-medium {{ request()->routeIs('about') ? 'text-teal-200' : '' }}">
        About
    </a>
    <a href="{{ route('contact') }}" class="text-white hover:text-teal-200 font-medium {{ request()->routeIs('contact') ? 'text-teal-200' : '' }}">
        Contact
    </a>
</nav>
