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
        <h2 class='font-semibold text-2xl text-gray-800'>Instructor Dashboard</h2>
     <?php $__env->endSlot(); ?>
    <div class='bg-green-50 p-6 rounded-lg mb-6'>
        <h1 class='text-2xl font-bold text-green-800'>Welcome, <?php echo e(Auth::user()->name); ?>!</h1>
        <p class='text-green-600'>Manage your courses and students from here.</p>
    </div>
    <div class='grid grid-cols-1 md:grid-cols-3 gap-6'>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>My Courses</h3><p class='text-3xl font-bold text-green-600'><?php echo e($stats['total_courses'] ?? 0); ?></p></div>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>My Students</h3><p class='text-3xl font-bold text-blue-600'><?php echo e($stats['total_students'] ?? 0); ?></p></div>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>Online Classes</h3><p class='text-3xl font-bold text-purple-600'><?php echo e($stats['total_classes'] ?? 0); ?></p></div>
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/instructor/dashboard/index.blade.php ENDPATH**/ ?>