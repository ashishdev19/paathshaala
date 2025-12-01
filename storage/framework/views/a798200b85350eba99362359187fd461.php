

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Super Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">System Administration & Management</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_users'] ?? 0); ?></p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Admins Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Admins</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_admins'] ?? 0); ?></p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Professors Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Professors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_professors'] ?? 0); ?></p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5h7M6.5 10h7M6.5 13.5h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Students</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_students'] ?? 0); ?></p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5h7M6.5 10h7M6.5 13.5h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Courses Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Courses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_courses'] ?? 0); ?></p>
                </div>
                <div class="bg-indigo-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Enrollments Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Enrollments</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_enrollments'] ?? 0); ?></p>
                </div>
                <div class="bg-pink-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a1 1 0 00-1-1h-1V9a6 6 0 00-12 0v6H2a1 1 0 00-1 1v2h17z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="<?php echo e(route('superadmin.users.index')); ?>" class="block p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">Manage Users</span>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>

                <a href="<?php echo e(route('superadmin.roles.index')); ?>" class="block p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">Manage Roles</span>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>

                <a href="<?php echo e(route('superadmin.permissions.index')); ?>" class="block p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">Manage Permissions</span>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>

                <a href="<?php echo e(route('superadmin.settings')); ?>" class="block p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">System Settings</span>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>

                <a href="<?php echo e(route('superadmin.logs')); ?>" class="block p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">System Logs</span>
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">System Information</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Application Name</span>
                    <span class="font-medium text-gray-900">PaathShaala LMS</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Laravel Version</span>
                    <span class="font-medium text-gray-900"><?php echo e(app()->version()); ?></span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">PHP Version</span>
                    <span class="font-medium text-gray-900"><?php echo e(phpversion()); ?></span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Database</span>
                    <span class="font-medium text-gray-900"><?php echo e(config('database.default')); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Environment</span>
                    <span class="font-medium text-gray-900 bg-blue-100 text-blue-800 px-3 py-1 rounded"><?php echo e(app()->environment()); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\paathshaala\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>