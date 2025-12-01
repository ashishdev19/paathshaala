<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['role' => 'admin']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['role' => 'admin']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<footer class="bg-gray-800 text-white py-6 <?php echo e(isset($role) && in_array($role, ['admin', 'instructor', 'student']) ? '' : ''); ?>">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm">&copy; <?php echo e(date('Y')); ?> Paathshaala. All rights reserved.</p>
            </div>
            <div class="flex space-x-6 text-sm">
                <a href="<?php echo e(route('home')); ?>" class="hover:text-gray-300">Home</a>
                <a href="#" class="hover:text-gray-300">Privacy Policy</a>
                <a href="#" class="hover:text-gray-300">Terms of Service</a>
                <a href="#" class="hover:text-gray-300">Contact</a>
            </div>
        </div>
    </div>
</footer><?php /**PATH C:\laragon\www\paathshaala\resources\views/components/shared/footer.blade.php ENDPATH**/ ?>