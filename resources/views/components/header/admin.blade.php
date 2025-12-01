{{-- Admin Header Component --}}
<header class="bg-gray-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <!-- <span class="text-2xl font-bold">Admin Panel</span> -->
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-300">Dashboard</a>
                <!-- <a href="{{ route('home') }}" class="hover:text-indigo-300" target="_blank">View Site</a> -->
                
                <div class="relative">
                    <button class="flex items-center space-x-2 hover:text-indigo-300">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
