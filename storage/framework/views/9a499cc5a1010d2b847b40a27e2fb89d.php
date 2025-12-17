
<aside class="w-64 min-h-screen fixed left-0 top-0 overflow-y-auto pb-20" style="background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);">
    
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                AD
            </div>
            <div>
                <h2 class="text-white font-bold text-lg">Medniks</h2>
                <p class="text-slate-400 text-xs">Admin</p>
            </div>
        </div>
    </div>

    <nav class="px-4 py-6 space-y-1">
        
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Dashboard</span>
        </a>

        
        <a href="<?php echo e(route('admin.courses.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.courses.*') && !request()->routeIs('admin.course-categories.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span>Courses</span>
        </a>

        
        <a href="<?php echo e(route('admin.course-categories.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.course-categories.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <span>Course Categories</span>
        </a>

        
        <a href="<?php echo e(route('admin.instructors.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.instructors.*') || request()->routeIs('admin.teachers.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Instructors</span>
        </a>

        
        <a href="<?php echo e(route('admin.students.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.students.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span>Students</span>
        </a>

        
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.payments.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Payments</span>
        </a>

        
        <a href="<?php echo e(route('admin.subscriptions.list')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.subscriptions.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <span>Subscription</span>
        </a>

        
        <a href="<?php echo e(route('admin.wallet.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.wallet.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <span>Wallet</span>
        </a>

        
        <a href="<?php echo e(route('admin.reports.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.reports.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Reports</span>
        </a>

        
        <a href="<?php echo e(route('admin.access-control.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.access-control.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15V3m0 18a9 9 0 100-18 9 9 0 000 18z"></path>
            </svg>
            <span>Roles & Permissions</span>
        </a>

        
        <a href="<?php echo e(route('admin.accounts.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.accounts.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804z"></path>
            </svg>
            <span>Admin Accounts</span>
        </a>

        
        <a href="<?php echo e(route('admin.settings.index')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 transition-all <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700 hover:text-white'); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            </svg>
            <span>Settings</span>
        </a>
    </nav>

    
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full flex items-center justify-start gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/sidebar/admin.blade.php ENDPATH**/ ?>