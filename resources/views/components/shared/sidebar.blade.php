@props(['role' => 'admin'])

@php
$config = match($role) {
    'admin' => [
        'title' => 'Admin Panel',
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
@endphp

<style>
    /* Reuse instructor sidebar styling to ensure consistent look */
    .shared-sidebar { /* container fallback */ }
    .instructor-sidebar { position: fixed; left: 0; top: 0; width: 16rem; height: 100vh; background: linear-gradient(180deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); color: white; box-shadow: 2px 0 8px rgba(0,0,0,0.3); z-index:50; display:flex;flex-direction:column;overflow-y:auto;border-right:1px solid rgba(255,255,255,0.1);} 
    .sidebar-header{ padding:2rem 1.5rem; border-bottom:1px solid rgba(255,255,255,0.1); background:linear-gradient(135deg, rgba(59,130,246,0.1), rgba(30,58,138,0.1)); }
    .sidebar-logo{ display:flex; align-items:center; gap:1rem; }
    .logo-badge{ width:2.75rem;height:2.75rem;border-radius:0.75rem;background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:1.25rem;color:white;box-shadow:0 4px 15px rgba(59,130,246,0.4); }
    .logo-text h2{ font-size:1.25rem;font-weight:700;color:white;margin:0 }
    .sidebar-nav{ flex:1; padding:1.5rem 0.75rem; }
    .nav-section-title{ padding:0.75rem 1rem; margin-top:1.25rem; margin-bottom:0.5rem; font-size:0.7rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.1em }
    .nav-item{ display:flex; align-items:center; gap:0.875rem; padding:0.875rem 1rem; border-radius:0.65rem; transition:all 0.25s; color:#cbd5e1; text-decoration:none; margin:0.25rem 0; font-weight:500; font-size:0.9375rem; border-left:3px solid transparent; }
    .nav-item:hover{ background-color: rgba(59,130,246,0.15); color:#e2e8f0; border-left-color:#3b82f6; transform:translateX(4px);} 
    .nav-item.active{ background:linear-gradient(135deg, rgba(59,130,246,0.25), rgba(59,130,246,0.15)); color:#60a5fa; border-left-color:#3b82f6; }
    .sidebar-footer{ padding:1.25rem 0.75rem; border-top:1px solid rgba(255,255,255,0.1); background:rgba(0,0,0,0.15)}
</style>

<aside class="instructor-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-badge">PS</div>
            <div class="logo-text">
                <h2>PaathShaala</h2>
                <p style="margin:0.25rem 0 0 0; color:#94a3b8; font-weight:500; font-size:0.75rem">{{ ucfirst($role) }}</p>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        @foreach($config['menuItems'] as $item)
            @php $match = $item['match'] ?? $item['route']; $active = request()->routeIs($match); @endphp
            <a href="{{ route($item['route']) }}" class="nav-item {{ $active ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:1.25rem;height:1.25rem;opacity:0.9;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$item['icon']] ?? $icons['dashboard'] }}"></path>
                </svg>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin:0">@csrf
            <button type="submit" class="logout-btn" style="width:100%;display:flex;align-items:center;gap:.875rem;padding:.875rem 1rem;border-radius:.65rem;background:linear-gradient(135deg, rgba(239,68,68,0.1), rgba(220,38,38,0.1));color:#fca5a5;border:1px solid rgba(239,68,68,0.2);">
                <i class="fas fa-sign-out-alt" style="width:1.25rem;height:1.25rem"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
