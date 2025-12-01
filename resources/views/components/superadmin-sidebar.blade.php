<!-- SuperAdmin Sidebar Component -->
<aside class="fixed left-0 top-0 w-64 h-screen bg-gray-900 text-white shadow-lg z-50">
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center font-bold text-lg">
                SA
            </div>
            <div>
                <h2 class="text-lg font-bold">PaathShaala</h2>
                <p class="text-xs text-gray-400">Super Admin</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
            <i class="fas fa-chart-line w-5 h-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Management Section -->
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Management</p>
            
            <!-- Manage Admins -->
            <a href="{{ route('superadmin.admins.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.admins.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-user-tie w-5 h-5"></i>
                <span class="font-medium">Manage Admins</span>
            </a>

            <!-- Manage Instructors -->
            <a href="{{ route('superadmin.instructors.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.instructors.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-chalkboard-user w-5 h-5"></i>
                <span class="font-medium">Manage Instructors</span>
            </a>

            <!-- Manage Students -->
            <a href="{{ route('superadmin.students.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.students.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-users w-5 h-5"></i>
                <span class="font-medium">Manage Student</span>
            </a>
        </div>

        <!-- Content Section -->
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Content</p>
            
            <!-- Courses -->
            <a href="{{ route('superadmin.courses.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.courses.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-book w-5 h-5"></i>
                <span class="font-medium">Courses</span>
            </a>

            <!-- Transactions -->
            <a href="{{ route('superadmin.transactions.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.transactions.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-exchange-alt w-5 h-5"></i>
                <span class="font-medium">Transactions</span>
            </a>
        </div>

        <!-- Settings Section -->
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">System</p>
            
            <!-- System Settings -->
            <a href="{{ route('superadmin.settings.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('superadmin.settings.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-cog w-5 h-5"></i>
                <span class="font-medium">System Settings</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer - Logout -->
    <div class="p-4 border-t border-gray-800">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition-all duration-200 group">
                <i class="fas fa-sign-out-alt w-5 h-5 group-hover:rotate-180 transition-transform duration-300"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>
