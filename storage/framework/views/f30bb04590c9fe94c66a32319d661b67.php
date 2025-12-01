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
            System Settings
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto">
        <!-- General Settings -->
        <div class="bg-white rounded-lg shadow-md mb-6 border border-indigo-200">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-indigo-200">
                <h3 class="text-lg font-semibold text-gray-900">General Settings</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                    <input type="text" value="Paathshaala" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                    <textarea rows="3" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">Your trusted online medical education platform</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                    <input type="email" value="info@paathshaala.com" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Support Phone</label>
                    <input type="tel" value="+91 9999999999" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                </div>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="bg-white rounded-lg shadow-md mb-6 border border-green-200">
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                <h3 class="text-lg font-semibold text-gray-900">Payment Settings</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                        <span class="ml-2 text-sm text-gray-700 font-medium">Enable Online Payments</span>
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <select class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                        <option>INR (₹)</option>
                        <option>USD ($)</option>
                        <option>EUR (€)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tax Percentage (%)</label>
                    <input type="number" value="18" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-white rounded-lg shadow-md mb-6 border border-blue-200">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                <h3 class="text-lg font-semibold text-gray-900">Email Settings</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                        <span class="ml-2 text-sm text-gray-700 font-medium">Send Welcome Email to New Users</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                        <span class="ml-2 text-sm text-gray-700 font-medium">Send Enrollment Confirmation</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700 font-medium">Send Course Completion Certificate</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Course Settings -->
        <div class="bg-white rounded-lg shadow-md mb-6 border border-purple-200">
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                <h3 class="text-lg font-semibold text-gray-900">Course Settings</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Course Validity (days)</label>
                    <input type="number" value="365" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                        <span class="ml-2 text-sm text-gray-700 font-medium">Require Admin Approval for New Courses</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700 font-medium">Allow Free Course Enrollment</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 font-semibold shadow-md transition duration-300">
                Save Settings
            </button>
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>