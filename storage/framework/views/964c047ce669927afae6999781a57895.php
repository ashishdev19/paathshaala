<?php if (isset($component)) { $__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.instructor','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.instructor'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Online Classes
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header with Schedule Button -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Courses</option>
                    <?php $__currentLoopData = $courses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <a href="<?php echo e(route('online-classes.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <svg class="inline-block h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Schedule New Class
            </a>
        </div>

        <!-- Classes Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $classes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($class->course->title ?? 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo e($class->topic); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(optional($class->scheduled_at)->format('M d, Y h:i A') ?? 'TBD'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($class->duration); ?> mins
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($class->students_count ?? 0); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php if($class->status == 'completed'): ?> bg-green-100 text-green-800
                                <?php elseif($class->status == 'scheduled'): ?> bg-blue-100 text-blue-800
                                <?php elseif($class->status == 'cancelled'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e(ucfirst($class->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <?php if($class->status == 'scheduled'): ?>
                            <a href="<?php echo e($class->meeting_link); ?>" target="_blank" class="text-green-600 hover:text-green-900">Join</a>
                            <?php endif; ?>
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <button class="text-red-600 hover:text-red-900">Cancel</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-lg">No classes scheduled yet</p>
                            <a href="#" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                Schedule Your First Class
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if(isset($classes) && $classes->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($classes->links()); ?>

        </div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc)): ?>
<?php $attributes = $__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc; ?>
<?php unset($__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc)): ?>
<?php $component = $__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc; ?>
<?php unset($__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/instructor/classes/index.blade.php ENDPATH**/ ?>