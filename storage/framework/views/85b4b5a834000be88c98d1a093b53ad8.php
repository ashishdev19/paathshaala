<?php if (isset($component)) { $__componentOriginalaf25f15ef26fc3d179956a9918eaad4d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaf25f15ef26fc3d179956a9918eaad4d = $attributes; } ?>
<?php $component = App\View\Components\Layouts\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\Admin::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Reports & Analytics
        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Date Range Filter -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg shadow-md p-6 mb-6 border border-indigo-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                <input type="date" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                <input type="date" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                <select class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    <option>Revenue Report</option>
                    <option>Enrollment Report</option>
                    <option>Course Performance</option>
                    <option>Teacher Performance</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 font-semibold shadow-md transition duration-300">
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-md p-6 border border-green-200 hover:shadow-lg transition duration-300">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-green-600">₹<?php echo e(number_format(250000, 2)); ?></p>
            <p class="text-sm text-green-700 mt-2 font-semibold">↑ 12% from last month</p>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border border-blue-200 hover:shadow-lg transition duration-300">
            <h3 class="text-sm font-medium text-gray-600 mb-2">New Enrollments</h3>
            <p class="text-3xl font-bold text-blue-600">145</p>
            <p class="text-sm text-blue-700 mt-2 font-semibold">↑ 8% from last month</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-md p-6 border border-purple-200 hover:shadow-lg transition duration-300">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Active Courses</h3>
            <p class="text-3xl font-bold text-purple-600">32</p>
            <p class="text-sm text-gray-600 mt-2">5 new this month</p>
        </div>
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg shadow-md p-6 border border-indigo-200 hover:shadow-lg transition duration-300">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Completion Rate</h3>
            <p class="text-3xl font-bold text-indigo-600">78%</p>
            <p class="text-sm text-indigo-700 mt-2 font-semibold">↑ 3% from last month</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-indigo-200">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-indigo-200">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
            </div>
            <div class="p-6">
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <p>Chart will be displayed here</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-indigo-200">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-indigo-200">
                <h3 class="text-lg font-semibold text-gray-900">Enrollment Trend</h3>
            </div>
            <div class="p-6">
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <p>Chart will be displayed here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performing Courses -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-indigo-200">
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-indigo-200">
            <h3 class="text-lg font-semibold text-gray-900">Top Performing Courses</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Enrollments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Completion</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <p>No data available</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaf25f15ef26fc3d179956a9918eaad4d)): ?>
<?php $attributes = $__attributesOriginalaf25f15ef26fc3d179956a9918eaad4d; ?>
<?php unset($__attributesOriginalaf25f15ef26fc3d179956a9918eaad4d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaf25f15ef26fc3d179956a9918eaad4d)): ?>
<?php $component = $__componentOriginalaf25f15ef26fc3d179956a9918eaad4d; ?>
<?php unset($__componentOriginalaf25f15ef26fc3d179956a9918eaad4d); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>