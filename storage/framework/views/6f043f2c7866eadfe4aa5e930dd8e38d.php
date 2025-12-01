<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - Paathshaala</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Sign in to Paathshaala
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Welcome back! Please login to your account.
                </p>
            </div>

            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="rounded-md bg-green-50 p-4">
                    <div class="text-sm text-green-800">
                        <?php echo e(session('status')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if($errors->any()): ?>
                <div class="rounded-md bg-red-50 p-4">
                    <div class="text-sm text-red-800">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                               placeholder="Email address" value="<?php echo e(old('email')); ?>">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                               placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <?php if(Route::has('password.request')): ?>
                        <div class="text-sm">
                            <a href="<?php echo e(route('password.request')); ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot your password?
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>

                <?php if(Route::has('register')): ?>
                    <div class="text-center">
                        <span class="text-sm text-gray-600">Don't have an account?</span>
                        <a href="<?php echo e(route('register')); ?>" class="font-medium text-indigo-600 hover:text-indigo-500 ml-1">
                            Register here
                        </a>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="<?php echo e(route('home')); ?>" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Back to home
                    </a>
                </div>
            </form>

            <!-- Quick Login Credentials (for testing) -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-xs font-semibold text-blue-900 mb-2">Test Credentials:</p>
                <div class="text-xs text-blue-800 space-y-1">
                    <p><strong>Admin:</strong> admin@paathshaala.com / admin123</p>
                    <p><strong>Professor:</strong> professor@paathshaala.com / professor123</p>
                    <p><strong>Student:</strong> student@paathshaala.com / student123</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/auth/login.blade.php ENDPATH**/ ?>