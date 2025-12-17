<?php if (isset($component)) { $__componentOriginalb47a2f7b366fc021d22d4f04f0939d79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb47a2f7b366fc021d22d4f04f0939d79 = $attributes; } ?>
<?php $component = App\View\Components\Layouts\Auth::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\Auth::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 montserrat">Welcome Back</h2>
        <p class="text-gray-600 mt-2">Sign in to continue your learning journey</p>
    </div>

    <!-- Session Status -->
    <?php if(session('status')): ?>
        <div class="rounded-lg bg-green-50 p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div class="text-sm text-green-800">
                    <?php echo e(session('status')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Validation Errors -->
    <?php if($errors->any()): ?>
        <div class="rounded-lg bg-red-50 p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                <div class="text-sm text-red-800">
                    <ul class="space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>
        
        <!-- Email Input -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Address
            </label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="Enter your email">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Password Input -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lock text-gray-400 mr-2"></i>Password
            </label>
            <div class="relative">
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Enter your password">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i id="toggleIcon" class="fas fa-eye"></i>
                </button>
            </div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-700">
                    Remember me
                </label>
            </div>
            
            <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                    Forgot password?
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
        </button>
        
        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-600">
            Don't have an account? 
            <a href="<?php echo e(route('register')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold">
                Create one now
            </a>
        </p>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="<?php echo e(url('/')); ?>" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to home
            </a>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb47a2f7b366fc021d22d4f04f0939d79)): ?>
<?php $attributes = $__attributesOriginalb47a2f7b366fc021d22d4f04f0939d79; ?>
<?php unset($__attributesOriginalb47a2f7b366fc021d22d4f04f0939d79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb47a2f7b366fc021d22d4f04f0939d79)): ?>
<?php $component = $__componentOriginalb47a2f7b366fc021d22d4f04f0939d79; ?>
<?php unset($__componentOriginalb47a2f7b366fc021d22d4f04f0939d79); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/auth/login.blade.php ENDPATH**/ ?>