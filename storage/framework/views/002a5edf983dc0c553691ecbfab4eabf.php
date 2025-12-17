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
            My Certificates
        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Certificates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $certificates ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            <!-- Certificate Preview -->
            <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-8 text-white relative">
                <div class="absolute top-4 right-4">
                    <svg class="h-12 w-12 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium mb-2 opacity-90">Certificate of Completion</h3>
                <h2 class="text-xl font-bold mb-4"><?php echo e($certificate->course->title); ?></h2>
                <p class="text-sm opacity-90">Issued: <?php echo e($certificate->issued_date->format('M d, Y')); ?></p>
            </div>
            
            <!-- Certificate Details -->
            <div class="p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Certificate ID</p>
                    <p class="text-sm font-mono text-gray-900"><?php echo e($certificate->certificate_number); ?></p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Instructor</p>
                    <p class="text-sm text-gray-900"><?php echo e($certificate->course->teacher->name ?? 'Unknown'); ?></p>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('student.certificates.view', $certificate)); ?>" target="_blank" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        View
                    </a>
                    <a href="<?php echo e(route('student.certificates.download', $certificate)); ?>" class="flex-1 border border-blue-600 text-blue-600 text-center px-4 py-2 rounded-lg hover:bg-blue-50 text-sm">
                        Download
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No certificates yet</h3>
            <p class="mt-2 text-sm text-gray-500">Complete courses to earn certificates</p>
            <a href="<?php echo e(route('student.enrollments.index')); ?>" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                View My Enrollments
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if(isset($certificates) && $certificates->hasPages()): ?>
    <div class="mt-6">
        <?php echo e($certificates->links()); ?>

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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/student/certificates/index.blade.php ENDPATH**/ ?>