<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Medniks')); ?> - Admin Panel</title>

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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #1f2937;
            overflow-x: hidden;
        }

        .main-content-wrapper {
            margin-left: 16rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            height: 4rem;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .navbar-content {
            height: 100%;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #4f46e5;
            letter-spacing: -0.5px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-bell {
            position: relative;
            font-size: 1.25rem;
            color: #6b7280;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .notification-bell:hover {
            color: #4f46e5;
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            font-weight: 700;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-left: 1rem;
            border-left: 1px solid #e5e7eb;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .page-content {
            flex: 1;
            padding: 2rem;
            padding-bottom: 3rem;
            overflow-y: auto;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            margin-bottom: 2rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-content-wrapper {
                margin-left: 0;
            }

            .navbar-content {
                padding: 0 1rem;
            }

            .page-content {
                padding: 1rem;
            }
        }

        /* Footer full width */
        .admin-footer {
            margin-left: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Admin Sidebar -->
    <?php if (isset($component)) { $__componentOriginal6702637fcda68559f293a0e6ab31b9f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6702637fcda68559f293a0e6ab31b9f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar.admin','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6702637fcda68559f293a0e6ab31b9f6)): ?>
<?php $attributes = $__attributesOriginal6702637fcda68559f293a0e6ab31b9f6; ?>
<?php unset($__attributesOriginal6702637fcda68559f293a0e6ab31b9f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6702637fcda68559f293a0e6ab31b9f6)): ?>
<?php $component = $__componentOriginal6702637fcda68559f293a0e6ab31b9f6; ?>
<?php unset($__componentOriginal6702637fcda68559f293a0e6ab31b9f6); ?>
<?php endif; ?>

    <!-- Main Content Wrapper -->
    <div class="main-content-wrapper">
        <!-- Top Navigation Bar -->
        <nav class="top-navbar">
            <div class="navbar-content">
                <div class="navbar-left">
                    <h2 class="navbar-title">Admin Panel</h2>
                </div>

                <div class="navbar-right">
                    <div class="notification-bell">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>

                    <div class="user-profile">
                        <div class="user-avatar">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                        <div class="user-info">
                            <span class="user-name"><?php echo e(auth()->user()->name); ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            <?php if(isset($header)): ?>
                <div class="page-header">
                    <?php echo e($header); ?>

                </div>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/layouts/admin.blade.php ENDPATH**/ ?>