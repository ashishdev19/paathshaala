<?php if (isset($component)) { $__componentOriginal58498e54aa219fa993c439a2a6a862f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58498e54aa219fa993c439a2a6a862f5 = $attributes; } ?>
<?php $component = App\View\Components\Layouts\Student::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.student'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\Student::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Browse Courses
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            <div class="h-48 bg-gray-200 relative">
                <?php if($course->thumbnail): ?>
                    <img src="/storage/<?php echo e($course->thumbnail); ?>" alt="<?php echo e($course->title); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                <?php endif; ?>
                <!-- Enrolled Badge if already enrolled -->
                <?php if(in_array($course->id, $enrolledCourseIds)): ?>
                <span class="absolute top-2 right-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded">
                    Enrolled
                </span>
                <?php endif; ?>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded"><?php echo e($course->category->name ?? 'General'); ?></span>
                    <span class="text-sm text-gray-500"><?php echo e($course->level ?? 'All Levels'); ?></span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($course->title); ?></h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($course->description); ?></p>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <?php echo e($course->teacher->name ?? 'Unknown'); ?>

                </div>
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <span class="text-xl font-bold text-blue-600">₹<?php echo e(number_format($course->price, 2)); ?></span>
                    <a href="<?php echo e(route('student.courses.show', $course->id)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <p class="text-gray-500 text-lg mb-2">No courses available</p>
            <p class="text-gray-400 text-sm">Check back later for new courses!</p>
        </div>
        <?php endif; ?>
    </div>

    <?php if(isset($courses) && $courses->hasPages()): ?>
    <div class="mt-6">
        <?php echo e($courses->links()); ?>

    </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal58498e54aa219fa993c439a2a6a862f5)): ?>
<?php $attributes = $__attributesOriginal58498e54aa219fa993c439a2a6a862f5; ?>
<?php unset($__attributesOriginal58498e54aa219fa993c439a2a6a862f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal58498e54aa219fa993c439a2a6a862f5)): ?>
<?php $component = $__componentOriginal58498e54aa219fa993c439a2a6a862f5; ?>
<?php unset($__componentOriginal58498e54aa219fa993c439a2a6a862f5); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/student/courses/browse.blade.php ENDPATH**/ ?>