<x-layouts.superadmin.app>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900">Welcome to SuperAdmin Dashboard</h1>
    </x-slot>

    <div class="px-6 py-8">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-4xl font-bold mb-2">Welcome, {{ auth()->user()->name ?? 'Super Admin' }}! 👋</h2>
                    <p class="text-blue-100 text-lg">You have full control over the entire PaathShaala platform.</p>
                </div>
                <div class="w-24 h-24 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-crown text-5xl"></i>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Admins -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Admins</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">--</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user-tie text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Instructors -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Instructors</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">--</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-chalkboard-user text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Students</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">--</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Courses</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">--</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-book text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('superadmin.admins.index') }}" 
                       class="block px-4 py-3 bg-gray-50 hover:bg-blue-50 rounded-lg text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center justify-between group">
                        <span class="font-medium">Manage Admins</span>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-blue-600 transition-colors"></i>
                    </a>
                    <a href="{{ route('superadmin.instructors.index') }}" 
                       class="block px-4 py-3 bg-gray-50 hover:bg-green-50 rounded-lg text-gray-700 hover:text-green-600 transition-colors duration-200 flex items-center justify-between group">
                        <span class="font-medium">Manage Instructors</span>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-green-600 transition-colors"></i>
                    </a>
                    <a href="{{ route('superadmin.students.index') }}" 
                       class="block px-4 py-3 bg-gray-50 hover:bg-purple-50 rounded-lg text-gray-700 hover:text-purple-600 transition-colors duration-200 flex items-center justify-between group">
                        <span class="font-medium">Manage Students</span>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-purple-600 transition-colors"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    System Information
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Application Name:</span>
                        <span class="font-medium text-gray-900">{{ config('app.name', 'PaathShaala') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Environment:</span>
                        <span class="font-medium text-gray-900">{{ config('app.env') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Current User:</span>
                        <span class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Last Login:</span>
                        <span class="font-medium text-gray-900">Today</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity (Placeholder) -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-history text-indigo-500 mr-3"></i>
                Recent Activity
            </h3>
            <div class="text-center py-8">
                <i class="fas fa-inbox text-gray-300 text-4xl mb-3 block"></i>
                <p class="text-gray-500">No recent activity to display</p>
            </div>
        </div>
    </div>
</x-layouts.superadmin.app>
