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

<?php
$config = match($role) {
    'admin' => [
        'title' => 'Admin Panel',
        'bgColor' => 'bg-gray-900',
        'activeColor' => 'bg-indigo-600',
        'hoverColor' => 'hover:bg-gray-800',
        'menuItems' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'dashboard'],
            ['label' => 'Courses', 'route' => 'admin.courses.index', 'icon' => 'courses', 'match' => 'admin.courses.*'],
            ['label' => 'Teachers', 'route' => 'admin.teachers.index', 'icon' => 'teachers', 'match' => 'admin.teachers.*'],
            ['label' => 'Students', 'route' => 'admin.students.index', 'icon' => 'students', 'match' => 'admin.students.*'],
            ['label' => 'Payments', 'route' => 'admin.payments.index', 'icon' => 'payments', 'match' => 'admin.payments.*'],
            ['label' => 'Subscriptions', 'route' => 'admin.subscriptions.plans.index', 'icon' => 'subscription', 'match' => 'admin.subscriptions.*'],
            ['label' => 'Wallet', 'route' => 'admin.wallet.index', 'icon' => 'wallet', 'match' => 'admin.wallet.*'],
            ['label' => 'Reports', 'route' => 'admin.reports.index', 'icon' => 'reports', 'match' => 'admin.reports.*'],
            ['label' => 'Settings', 'route' => 'admin.settings.index', 'icon' => 'settings', 'match' => 'admin.settings.*'],
        ]
    ],
    'instructor', 'professor', 'teacher' => [
        'title' => 'Instructor Panel',
        'bgColor' => 'bg-gray-900',
        'activeColor' => 'bg-indigo-600',
        'hoverColor' => 'hover:bg-gray-800',
        'menuItems' => [
            ['label' => 'Dashboard', 'route' => 'instructor.dashboard', 'icon' => 'dashboard'],
            ['label' => 'My Courses', 'route' => 'instructor.courses.index', 'icon' => 'courses', 'match' => 'instructor.courses*'],
            ['label' => 'My Students', 'route' => 'instructor.students.index', 'icon' => 'students', 'match' => 'instructor.students'],
            ['label' => 'Online Classes', 'route' => 'instructor.classes.index', 'icon' => 'classes', 'match' => 'instructor.classes'],
            ['label' => 'Live Classes', 'route' => 'instructor.live-classes.index', 'icon' => 'video', 'match' => 'instructor.live-classes*'],
            ['label' => 'Wallet', 'route' => 'instructor.wallet.index', 'icon' => 'wallet', 'match' => 'instructor.wallet.*'],
            ['label' => 'Subscription', 'route' => 'instructor.subscription.show', 'icon' => 'subscription', 'match' => 'instructor.subscription.*'],
            ['label' => 'Profile', 'route' => 'profile.edit', 'icon' => 'profile', 'match' => 'profile.*'],
        ]
    ],
    'student' => [
        'title' => 'Student Panel',
        'bgColor' => 'bg-gray-900',
        'activeColor' => 'bg-indigo-600',
        'hoverColor' => 'hover:bg-gray-800',
        'menuItems' => [
            ['label' => 'Dashboard', 'route' => 'student.dashboard', 'icon' => 'dashboard'],
            ['label' => 'My Courses', 'route' => 'student.courses.index', 'icon' => 'courses', 'match' => 'student.courses.index'],
            ['label' => 'Browse Courses', 'route' => 'student.courses.browse', 'icon' => 'search', 'match' => 'student.courses.browse'],
            ['label' => 'Live Classes', 'route' => 'student.live-classes.index', 'icon' => 'video', 'match' => 'student.live-classes*'],
            ['label' => 'Enrollments', 'route' => 'student.enrollments.index', 'icon' => 'enrollments', 'match' => 'student.enrollments.*'],
            ['label' => 'Wallet', 'route' => 'student.wallet.index', 'icon' => 'wallet', 'match' => 'student.wallet.*'],
            ['label' => 'Certificates', 'route' => 'student.certificates.index', 'icon' => 'certificates', 'match' => 'student.certificates.*'],
            ['label' => 'Profile', 'route' => 'profile.edit', 'icon' => 'profile', 'match' => 'profile.*'],
        ]
    ],
    default => [
        'title' => 'Dashboard',
        'bgColor' => 'bg-gray-900',
        'activeColor' => 'bg-indigo-600',
        'hoverColor' => 'hover:bg-gray-800',
        'menuItems' => []
    ]
};

$icons = [
    'dashboard' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    'courses' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
    'teachers' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
    'students' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    'payments' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
    'reports' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    'settings' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
    'classes' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
    'profile' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    'search' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
    'enrollments' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    'certificates' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
    'subscription' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
    'wallet' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
    'video' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
];
?>

<aside class="w-64 <?php echo e($config['bgColor']); ?> text-white h-screen fixed left-0 top-0 overflow-y-auto z-40">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-8"><?php echo e($config['title']); ?></h2>

        <nav class="space-y-2">
            <?php $__currentLoopData = $config['menuItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $matchRoute = $item['match'] ?? $item['route'];
                    $isActive = request()->routeIs($matchRoute);
                ?>
                <a href="<?php echo e(route($item['route'])); ?>" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg <?php echo e($isActive ? $config['activeColor'] : $config['hoverColor']); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($icons[$item['icon']] ?? $icons['dashboard']); ?>"></path>
                    </svg>
                    <span><?php echo e($item['label']); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
    </div>
</aside>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/shared/sidebar.blade.php ENDPATH**/ ?>