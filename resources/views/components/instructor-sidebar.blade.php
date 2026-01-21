<style>
    .instructor-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 16rem;
        height: 100vh;
        background: linear-gradient(180deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        color: white;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
        z-index: 50;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header {
        padding: 2rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 58, 138, 0.1));
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .sidebar-logo:hover {
        transform: scale(1.02);
    }

    .logo-badge {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.25rem;
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .logo-text h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .logo-text p {
        font-size: 0.75rem;
        color: #94a3b8;
        margin: 0.25rem 0 0 0;
        font-weight: 500;
    }

    .sidebar-nav {
        flex: 1;
        padding: 1.5rem 0.75rem;
        overflow-y: auto;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 2px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.5);
    }

    .nav-section-title {
        padding: 0.75rem 1rem;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
        font-size: 0.7rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: color 0.2s ease;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.875rem 1rem;
        border-radius: 0.65rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        color: #cbd5e1;
        text-decoration: none;
        margin: 0.25rem 0;
        font-weight: 500;
        font-size: 0.9375rem;
        border-left: 3px solid transparent;
        position: relative;
    }

    .nav-item:hover {
        background-color: rgba(59, 130, 246, 0.15);
        color: #e2e8f0;
        border-left-color: #3b82f6;
        transform: translateX(4px);
    }

    .nav-item.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(59, 130, 246, 0.15));
        color: #60a5fa;
        border-left-color: #3b82f6;
        box-shadow: inset 0 0 8px rgba(59, 130, 246, 0.15);
        font-weight: 600;
    }

    .nav-item .icon {
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.9;
    }

    .nav-item:hover .icon,
    .nav-item.active .icon {
        opacity: 1;
    }

    .sidebar-footer {
        padding: 1.25rem 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.2);
    }

    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.875rem 1rem;
        border-radius: 0.65rem;
        border: none;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
        color: #fca5a5;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
        text-align: left;
        font-size: 0.9375rem;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(220, 38, 38, 0.25));
        color: #fecaca;
        border-color: rgba(239, 68, 68, 0.4);
        transform: translateX(4px);
    }

    .logout-btn .icon {
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
    }
</style>

<div class="instructor-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-badge">
                IN
            </div>
            <div class="logo-text">
                <h1 class="text-xl font-bold text-white">
                    <span style="color: #ffffff;">Med</span><span style="color: #e53e3e;">N<span style="position: relative; display: inline-block;"><span style="color: #e53e3e;">i</span><span style="position: absolute; top: -2px; left: 50%; transform: translateX(-50%); color: #e53e3e; font-size: 0.7em;">+</span></span>ks</span>
                </h1>
                <p>Instructor</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line icon"></i>
            <span>Dashboard</span>
        </a>

        <!-- My Courses -->
        <a href="{{ route('instructor.courses.index') }}" class="nav-item {{ request()->routeIs('instructor.courses.*') ? 'active' : '' }}">
            <i class="fas fa-book icon"></i>
            <span>My Courses</span>
        </a>

        <!-- My Students -->
        <a href="{{ route('instructor.students.index') }}" class="nav-item {{ request()->routeIs('instructor.students.*') ? 'active' : '' }}">
            <i class="fas fa-users icon"></i>
            <span>My Students</span>
        </a>

        <!-- Online Classes -->
        <a href="{{ route('instructor.classes.index') }}" class="nav-item {{ request()->routeIs('instructor.classes.*') ? 'active' : '' }}">
            <i class="fas fa-laptop icon"></i>
            <span>Online Classes</span>
        </a>

        <!-- Live Classes -->
        <a href="{{ route('instructor.live-classes.index') }}" class="nav-item {{ request()->routeIs('instructor.live-classes.*') ? 'active' : '' }}">
            <i class="fas fa-video icon"></i>
            <span>Live Classes</span>
        </a>

        <!-- Wallet -->
        <a href="{{ route('instructor.wallet.index') }}" class="nav-item {{ request()->routeIs('instructor.wallet.*') ? 'active' : '' }}">
            <i class="fas fa-wallet icon"></i>
            <span>Wallet</span>
        </a>

        <!-- Subscription -->
        <a href="{{ route('instructor.subscription.show') }}" class="nav-item {{ request()->routeIs('instructor.subscription.*') ? 'active' : '' }}">
            <i class="fas fa-star icon"></i>
            <span>Subscription</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-circle icon"></i>
            <span>Profile</span>
        </a>
    </nav>

    <!-- Sidebar Footer - Logout -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt icon"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
