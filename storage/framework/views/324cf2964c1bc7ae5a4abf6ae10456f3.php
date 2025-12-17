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
            Subscription Plans Management
        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-6 border border-indigo-200 shadow-md hover:shadow-lg transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Plans</p>
                    <p class="text-2xl font-bold text-indigo-600"><?php echo e($stats['totalPlans'] ?? 0); ?></p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200 shadow-md hover:shadow-lg transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Plans</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e($stats['activePlans'] ?? 0); ?></p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200 shadow-md hover:shadow-lg transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Subscriptions</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['totalSubscriptions'] ?? 0); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-indigo-100 overflow-hidden">
        <!-- Header with Add Button -->
        <div class="px-6 py-4 border-b border-indigo-100 bg-gradient-to-r from-indigo-50 to-purple-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-indigo-900">Subscription Plans</h3>
                <p class="text-sm text-gray-600">Manage Silver, Gold, and Platinum subscription plans for teachers</p>
            </div>
            <a href="<?php echo e(route('admin.subscriptions.plans.create')); ?>" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                <svg class="inline-block h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create New Plan
            </a>
        </div>

        <!-- Plans Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Plan Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Max Courses</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Max Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-indigo-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full 
                                    <?php if(strtolower($plan->name) == 'silver'): ?> bg-gradient-to-br from-gray-100 to-gray-200 border border-gray-300
                                    <?php elseif(strtolower($plan->name) == 'gold'): ?> bg-gradient-to-br from-yellow-100 to-yellow-200 border border-yellow-300
                                    <?php elseif(strtolower($plan->name) == 'platinum'): ?> bg-gradient-to-br from-purple-100 to-purple-200 border border-purple-300
                                    <?php else: ?> bg-gradient-to-br from-indigo-100 to-indigo-200 border border-indigo-300 <?php endif; ?> shadow-sm">
                                    <!-- <svg class="h-6 w-6 
                                        <?php if(strtolower($plan->name) == 'silver'): ?> text-gray-700
                                        <?php elseif(strtolower($plan->name) == 'gold'): ?> text-yellow-700
                                        <?php elseif(strtolower($plan->name) == 'platinum'): ?> text-purple-700
                                        <?php else: ?> text-indigo-700 <?php endif; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> -->
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($plan->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($plan->slug); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ₹<?php echo e(number_format($plan->price, 2)); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($plan->max_courses ?? 'Unlimited'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($plan->max_students ?? 'Unlimited'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($plan->priority ?? 0); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php if($plan->is_active): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e($plan->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="<?php echo e(route('admin.subscriptions.plans.edit', $plan)); ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="<?php echo e(route('admin.subscriptions.plans.destroy', $plan)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this plan?')" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <!-- <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg> -->
                            <p class="mt-2 text-lg">No subscription plans created yet</p>
                            <a href="<?php echo e(route('admin.subscriptions.plans.create')); ?>" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                Create Your First Plan
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($plans->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($plans->links()); ?>

        </div>
        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/admin/subscriptions/plans/index.blade.php ENDPATH**/ ?>