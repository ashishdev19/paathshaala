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
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 montserrat">Create Account</h2>
        <p class="text-gray-600 mt-2">Join Medniks to connect with professionals and advance your medical education.</p>
    </div>
    
    <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4" id="registerForm">
        <?php echo csrf_field(); ?>
        
        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-user text-gray-400 mr-2"></i>Full Name
            </label>
            <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="Enter your full name">
            <?php $__errorArgs = ['name'];
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
        
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
            </label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="your.email@example.com">
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
        
        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-phone text-gray-400 mr-2"></i>Phone Number
            </label>
            <input id="phone" type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="+91 XXXXX XXXXX">
            <?php $__errorArgs = ['phone'];
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
        
        <!-- User Type -->
        <div>
            <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-user-tag text-gray-400 mr-2"></i>Who are you?
            </label>
            <select id="user_type" name="user_type" required onchange="toggleProfessionField()"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <option value="">Select user type</option>
                <option value="instructor" <?php echo e(old('user_type') == 'instructor' ? 'selected' : ''); ?>>Instructor/Professional</option>
                <option value="student" <?php echo e(old('user_type') == 'student' ? 'selected' : ''); ?>>Student/Learner</option>
            </select>
            <?php $__errorArgs = ['user_type'];
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
        
        <!-- Profession Type (shown for instructors) -->
        <div id="professionField" style="display: <?php echo e(old('user_type') == 'instructor' ? 'block' : 'none'); ?>;">
            <label for="profession_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-briefcase text-gray-400 mr-2"></i>Profession Type
            </label>
            <select id="profession_type" name="profession_type"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <option value="">Select profession</option>
                <option value="doctor" <?php echo e(old('profession_type') == 'doctor' ? 'selected' : ''); ?>>Doctor</option>
                <option value="nurse" <?php echo e(old('profession_type') == 'nurse' ? 'selected' : ''); ?>>Nurse</option>
                <option value="medical_researcher" <?php echo e(old('profession_type') == 'medical_researcher' ? 'selected' : ''); ?>>Medical Researcher</option>
                <option value="healthcare_consultant" <?php echo e(old('profession_type') == 'healthcare_consultant' ? 'selected' : ''); ?>>Healthcare Consultant</option>
                <option value="pharmacist" <?php echo e(old('profession_type') == 'pharmacist' ? 'selected' : ''); ?>>Pharmacist</option>
                <option value="other" <?php echo e(old('profession_type') == 'other' ? 'selected' : ''); ?>>Other Medical Professional</option>
            </select>
        </div>
        
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-lock text-gray-400 mr-2"></i>Password
            </label>
            <input id="password" type="password" name="password" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="Create a strong password">
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
        
        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-lock text-gray-400 mr-2"></i>Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                   placeholder="Re-enter your password">
        </div>
        
        <!-- Location Fields in Grid -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">
                    <i class="fas fa-city text-gray-400 mr-2"></i>City
                </label>
                <input id="city" type="text" name="city" value="<?php echo e(old('city')); ?>"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                       placeholder="City">
            </div>
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-1.5">
                    State
                </label>
                <input id="state" type="text" name="state" value="<?php echo e(old('state')); ?>"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                       placeholder="State">
            </div>
        </div>
        
        <div>
            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-map-pin text-gray-400 mr-2"></i>PIN Code
            </label>
            <input id="pincode" type="text" name="pincode" value="<?php echo e(old('pincode')); ?>" maxlength="6"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                   placeholder="PIN Code">
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300 mt-6">
            <i class="fas fa-user-plus mr-2"></i>Create Account
        </button>
        
        <!-- Login Link -->
        <p class="mt-6 text-center text-gray-600 text-sm">
            Already have an account? 
            <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold">
                Sign In
            </a>
        </p>
    </form>
    
    <script>
        function toggleProfessionField() {
            const userType = document.getElementById('user_type').value;
            const professionField = document.getElementById('professionField');
            const professionSelect = document.getElementById('profession_type');
            
            if (userType === 'instructor') {
                professionField.style.display = 'block';
                professionSelect.required = true;
            } else {
                professionField.style.display = 'none';
                professionSelect.required = false;
                professionSelect.value = '';
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/auth/register.blade.php ENDPATH**/ ?>