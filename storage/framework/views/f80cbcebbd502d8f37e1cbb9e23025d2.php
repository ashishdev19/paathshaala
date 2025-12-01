<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Paathshaala')); ?> - <?php echo $__env->yieldContent('title', 'Instructor Panel'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-gray-100 h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php echo $__env->make('components.shared.sidebar', ['role' => 'instructor'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content Area with Left Margin -->
    <div class="ml-64 h-screen flex flex-col">
        <!-- Header -->
        <?php echo $__env->make('components.shared.header', ['role' => 'instructor'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100">
            <div class="p-8">
                <?php if(isset($header)): ?>
                    <div class="mb-6">
                        <?php echo e($header); ?>

                    </div>
                <?php endif; ?>

                <?php echo e($slot); ?>

            </div>
        </main>

        <!-- Footer -->
        <?php echo $__env->make('components.shared.footer', ['role' => 'instructor'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/layouts/instructor.blade.php ENDPATH**/ ?>