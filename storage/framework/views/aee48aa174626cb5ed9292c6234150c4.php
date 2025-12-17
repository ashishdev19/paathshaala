
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">Medniks</span>
                </a>
            </div>

            
            <nav class="hidden md:flex space-x-8">
                <?php echo e($slot); ?>

            </nav>

            
            <div class="flex items-center space-x-4">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-indigo-600">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</a>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <?php echo $__env->make('components.navbar.user-dropdown', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/header/main.blade.php ENDPATH**/ ?>