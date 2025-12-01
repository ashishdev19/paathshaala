<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Paathshaala')); ?> - <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-white">
    <!-- Header -->
    <?php if (isset($component)) { $__componentOriginal6b6d5c174c12f8b9f1b338104ec23140 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6b6d5c174c12f8b9f1b338104ec23140 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header.main','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header.main'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6b6d5c174c12f8b9f1b338104ec23140)): ?>
<?php $attributes = $__attributesOriginal6b6d5c174c12f8b9f1b338104ec23140; ?>
<?php unset($__attributesOriginal6b6d5c174c12f8b9f1b338104ec23140); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6b6d5c174c12f8b9f1b338104ec23140)): ?>
<?php $component = $__componentOriginal6b6d5c174c12f8b9f1b338104ec23140; ?>
<?php unset($__componentOriginal6b6d5c174c12f8b9f1b338104ec23140); ?>
<?php endif; ?>

    <!-- Page Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <?php echo $__env->make('components.footer.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/layouts/app.blade.php ENDPATH**/ ?>