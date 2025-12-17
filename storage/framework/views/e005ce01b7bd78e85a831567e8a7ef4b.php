
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

        </div>
        <span><?php echo e(Auth::user()->name); ?></span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
        <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
        <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
        <a href="<?php echo e(route('notifications.index')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notifications</a>
        <hr class="my-1">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/navbar/user-dropdown.blade.php ENDPATH**/ ?>