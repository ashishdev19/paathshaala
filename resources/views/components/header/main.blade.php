{{-- Main Header Component --}}
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">Medniks</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="hidden md:flex space-x-8">
                {{ $slot }}
            </nav>

            {{-- User Menu --}}
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</a>
                @endguest

                @auth
                    @include('components.navbar.user-dropdown')
                @endauth
            </div>
        </div>
    </div>
</header>
