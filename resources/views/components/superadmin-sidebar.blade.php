<style>
    .superadmin-sidebar {
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

<!-- SuperAdmin Sidebar Component -->
<aside class="superadmin-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-badge">
                SA
            </div>
            <div class="logo-text">
                <h2>PaathShaala</h2>
                <p>Super Admin</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}" class="nav-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line icon"></i>
            <span>Dashboard</span>
        </a>

        <!-- Management Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">Management</p>
            
            <!-- Manage Admins -->
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-user-tie icon"></i>
                <span>Manage Admins</span>
            </a>

            <!-- Instructors -->
            <a href="{{ route('admin.instructors.index') }}" class="nav-item {{ request()->routeIs('admin.instructors.*') || request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-user icon"></i>
                <span>Manage Instructors</span>
            </a>

            <!-- Manage Students -->
            <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="fas fa-users icon"></i>
                <span>Manage Student</span>
            </a>
        </div>

        <!-- Content Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">Content</p>
            
            <!-- Courses -->
            <a href="{{ route('admin.courses.index') }}" class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="fas fa-book icon"></i>
                <span>Courses</span>
            </a>

            <!-- Transactions -->
            <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt icon"></i>
                <span>Transactions</span>
            </a>
        </div>

        <!-- Settings Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">System</p>
            
            <!-- System Settings -->
            <a href="{{ route('superadmin.settings') }}" class="nav-item {{ request()->routeIs('superadmin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog icon"></i>
                <span>System Settings</span>
            </a>
        </div>
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
</aside>
