<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'PaathShaala')); ?> - <?php echo $__env->yieldContent('title', 'Admin Panel'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .top-nav {
            position: fixed;
            left: 16rem;
            top: 0;
            right: 0;
            height: 4rem;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            z-index: 40;
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #0f172a;
        }

        .user-role {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: capitalize;
        }

        .page-content {
            margin-left: 16rem;
            margin-top: 4rem;
            padding: 2rem;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .top-nav {
                left: 0;
            }

            .page-content {
                margin-left: 0;
                padding: 1rem;
            }

            .user-details {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Admin Sidebar -->
    <?php if (isset($component)) { $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $attributes = $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $component = $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>

    <!-- Top Navigation -->
    <div class="top-nav">
        <div class="nav-content">
            <div class="nav-left">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #0f172a;"><?php echo $__env->yieldContent('header', 'Dashboard'); ?></h2>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

                    </div>
                    <div class="user-details">
                        <div class="user-name"><?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
                        <div class="user-role">Admin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
        
        <!-- Footer -->
        <?php if (isset($component)) { $__componentOriginal13c317896897799077c93fa7c21afbaf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13c317896897799077c93fa7c21afbaf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer.admin','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13c317896897799077c93fa7c21afbaf)): ?>
<?php $attributes = $__attributesOriginal13c317896897799077c93fa7c21afbaf; ?>
<?php unset($__attributesOriginal13c317896897799077c93fa7c21afbaf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13c317896897799077c93fa7c21afbaf)): ?>
<?php $component = $__componentOriginal13c317896897799077c93fa7c21afbaf; ?>
<?php unset($__componentOriginal13c317896897799077c93fa7c21afbaf); ?>
<?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/layouts/admin/app.blade.php ENDPATH**/ ?>