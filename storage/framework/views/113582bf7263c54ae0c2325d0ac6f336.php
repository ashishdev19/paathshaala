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
            My Enrollments
        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Filters -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg shadow-md p-6 mb-6 border border-indigo-200">
        <div class="flex space-x-4">
            <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold shadow-md hover:from-blue-700 hover:to-blue-800 transition duration-300">All</button>
            <button class="px-4 py-2 text-gray-700 hover:bg-white hover:shadow-sm rounded-lg font-medium border border-transparent hover:border-gray-200 transition duration-200">Active</button>
            <button class="px-4 py-2 text-gray-700 hover:bg-white hover:shadow-sm rounded-lg font-medium border border-transparent hover:border-gray-200 transition duration-200">Completed</button>
            <button class="px-4 py-2 text-gray-700 hover:bg-white hover:shadow-sm rounded-lg font-medium border border-transparent hover:border-gray-200 transition duration-200">Expired</button>
        </div>
    </div>

    <!-- Enrollments Grid -->
    <div class="grid grid-cols-1 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $enrollments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-indigo-200 hover:shadow-xl transition duration-300">
            <div class="md:flex">
                <!-- Course Image -->
                <div class="md:flex-shrink-0">
                    <div class="h-48 md:h-full md:w-48 bg-gradient-to-br from-indigo-100 to-purple-100 relative overflow-hidden">
                        <img src="<?php echo e($enrollment->course->thumbnail ? '/storage/' . $enrollment->course->thumbnail : 'https://via.placeholder.com/300x200'); ?>" alt="<?php echo e($enrollment->course->title); ?>" class="h-full w-full object-cover border-r-4 border-indigo-200">
                    </div>
                </div>
                <!-- Course Details -->
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900"><?php echo e($enrollment->course->title); ?></h3>
                            <p class="text-sm text-gray-600 mt-1 font-medium">by <?php echo e($enrollment->course->teacher->name ?? 'Unknown'); ?></p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border
                            <?php if($enrollment->status == 'active'): ?> bg-gradient-to-r from-green-100 to-green-200 text-green-800 border-green-300
                            <?php elseif($enrollment->status == 'completed'): ?> bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border-blue-300
                            <?php else: ?> bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-gray-300 <?php endif; ?>">
                            <?php echo e(ucfirst($enrollment->status)); ?>

                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-700">Course Progress</span>
                            <span class="text-sm font-bold text-indigo-600"><?php echo e($enrollment->progress ?? 0); ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full shadow-md transition-all duration-500" style="width: <?php echo e($enrollment->progress ?? 0); ?>%"></div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 text-sm">
                        <div>
                            <p class="font-semibold text-gray-700">Enrolled On</p>
                            <p class="text-gray-600"><?php echo e($enrollment->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Expires On</p>
                            <p class="text-gray-600"><?php echo e($enrollment->expires_at ? $enrollment->expires_at->format('M d, Y') : 'Lifetime'); ?></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Last Accessed</p>
                            <p class="text-gray-600"><?php echo e($enrollment->updated_at->diffForHumans()); ?></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Payment Status</p>
                            <p class="text-green-600 font-semibold">Paid</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold shadow-md transition duration-300">
                            Continue Learning
                        </a>
                        <?php if($enrollment->progress >= 100): ?>
                        <a href="<?php echo e(route('student.certificates.download', $enrollment)); ?>" class="border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 font-semibold shadow-sm transition duration-300">
                            Download Certificate
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center border border-indigo-200">
            <svg class="mx-auto h-16 w-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <p class="mt-4 text-lg text-gray-600 font-semibold">No enrollments yet</p>
            <p class="mt-2 text-sm text-gray-500">Start your learning journey by enrolling in a course</p>
            <a href="<?php echo e(route('student.courses.index')); ?>" class="mt-6 inline-block bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold shadow-md transition duration-300">
                Browse Courses
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if(isset($enrollments) && $enrollments->hasPages()): ?>
    <div class="mt-6">
        <?php echo e($enrollments->links()); ?>

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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/student/enrollments/index.blade.php ENDPATH**/ ?>