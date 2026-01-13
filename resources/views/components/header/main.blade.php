{{-- Main Header Component --}}
<header class="shadow-sm border-b border-teal-700" style="background-color: #008080;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-white">Medniks</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="hidden md:flex space-x-8">
                {{ $slot }}
            </nav>

            {{-- User Menu --}}
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-teal-200">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-teal-700 px-4 py-2 rounded-md hover:bg-teal-100">Register</a>
                @endguest

                @auth
                    @include('components.navbar.user-dropdown')
                @endauth
            </div>
        </div>
    </div>
</header>
