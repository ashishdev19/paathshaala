<style>
    .admin-sidebar {
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

    .admin-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 2px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.5);
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

    .logo-text {
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
        letter-spacing: -0.5px;
    }

    .logo-text small {
        display: block;
        font-size: 0.625rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-top: 0.25rem;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
    }

    .nav-section {
        padding: 1rem 0;
    }

    .nav-section:not(:first-child) {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-section-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.75rem 1.5rem;
        margin-bottom: 0.5rem;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.5rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 3px solid transparent;
        margin: 0 0.75rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }

    .nav-item:hover {
        background-color: rgba(99, 102, 241, 0.15);
        color: #c7d2fe;
        border-left-color: #6366f1;
        transform: translateX(4px);
    }

    .nav-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(99, 102, 241, 0.15));
        color: #a5b4fc;
        border-left-color: #6366f1;
    }

    .nav-icon {
        width: 1.25rem;
        height: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .logout-section {
        padding: 1rem 0.75rem;
        margin-top: auto;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.5rem;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.1));
        color: #fca5a5;
        text-decoration: none;
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 0.5rem;
        font-weight: 600;
        margin: 0 0.75rem;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(220, 38, 38, 0.15));
        border-left-color: #ef4444;
        transform: translateX(4px);
    }
</style>

<div class="admin-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-badge">
                AD
            </div>
            <div class="logo-text">
                <h2>PaathShaala</h2>
                <p>Admin</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line icon"></i>
            <span>Dashboard</span>
        </a>

        <!-- User Management Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">User Management</p>
            
            <!-- Instructors -->
            <a href="{{ route('admin.teachers.index') }}" class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-user icon"></i>
                <span>Instructors</span>
            </a>

            <!-- Students -->
            <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="fas fa-users icon"></i>
                <span>Students</span>
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

            <!-- Approvals -->
            <a href="{{ route('admin.course-approvals.index') }}" class="nav-item {{ request()->routeIs('admin.course-approvals.*') ? 'active' : '' }}">
                <i class="fas fa-check-circle icon"></i>
                <span>Approvals</span>
            </a>
        </div>

        <!-- Business Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">Business</p>
            
            <!-- Subscriptions -->
            <a href="{{ route('admin.subscriptions.list') }}" class="nav-item {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card icon"></i>
                <span>Subscriptions</span>
            </a>

            <!-- Wallet -->
            <a href="{{ route('admin.wallet.index') }}" class="nav-item {{ request()->routeIs('admin.wallet.*') ? 'active' : '' }}">
                <i class="fas fa-wallet icon"></i>
                <span>Wallet</span>
            </a>

            <!-- Payments -->
            <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave icon"></i>
                <span>Payments</span>
            </a>
        </div>

        <!-- Reports Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">Analytics</p>
            
            <!-- Reports -->
            <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar icon"></i>
                <span>Reports</span>
            </a>
        </div>

        <!-- Access Control Section -->
        <div style="margin-top: 1rem;">
            <p class="nav-section-title">Access Control</p>
            
            <!-- Access Control Dashboard -->
            <a href="{{ route('admin.access-control.index') }}" class="nav-item {{ request()->routeIs('admin.access-control.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                <i class="fas fa-shield-alt icon"></i>
                <span>Roles & Permissions</span>
            </a>

            <!-- Admin Accounts -->
            <a href="{{ route('admin.accounts.index') }}" class="nav-item {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog icon"></i>
                <span>Admin Accounts</span>
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
</div>
