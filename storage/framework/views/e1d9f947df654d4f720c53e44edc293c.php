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

    /* tighter logo text */
    .logo-text {
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
        letter-spacing: -0.5px;
    }

    .logo-text p {
        margin: 0;
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 600;
    }

    /* Navigation layout */
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

    .nav-section {
        padding: 0.5rem 0;
        margin-top: 0.5rem;
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

    .nav-item .icon {
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.9;
    }

    .nav-item:hover {
        background-color: rgba(59, 130, 246, 0.15);
        color: #e2e8f0;
        border-left-color: #3b82f6;
        transform: translateX(4px);
    }

    .nav-item:hover .icon,
    .nav-item.active .icon {
        opacity: 1;
    }

    /* Active pill like the screenshot */
    .nav-item.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(59, 130, 246, 0.15));
        color: #60a5fa;
        border-left-color: #3b82f6;
        box-shadow: inset 0 0 8px rgba(59, 130, 246, 0.15);
        font-weight: 600;
    }

    /* Special styling for Roles & Permissions menu item */
    .nav-item.roles-permissions {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(168, 85, 247, 0.15));
        border-left-color: #a855f7;
        color: #c084fc;
    }

    .nav-item.roles-permissions:hover {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.25), rgba(168, 85, 247, 0.25));
        border-left-color: #c084fc;
        color: #e9d5ff;
    }

    .nav-item.roles-permissions.active {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(168, 85, 247, 0.3));
        border-left-color: #a855f7;
        color: #e9d5ff;
        box-shadow: inset 0 0 12px rgba(139, 92, 246, 0.2);
    }

    /* Special styling for Admin Accounts menu item */
    .nav-item.admin-accounts {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.15));
        border-left-color: #3b82f6;
        color: #60a5fa;
    }

    .nav-item.admin-accounts:hover {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(37, 99, 235, 0.25));
        border-left-color: #60a5fa;
        color: #93c5fd;
    }

    .nav-item.admin-accounts.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.3));
        border-left-color: #3b82f6;
        color: #93c5fd;
        box-shadow: inset 0 0 12px rgba(59, 130, 246, 0.2);
    }

    .logout-section {
        margin-top: auto;
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

<div class="admin-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-badge">
                AD
            </div>
            <div class="logo-text">
                <h2>Medniks</h2>
                <p>Admin</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <!-- Ordered Navigation -->
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-chart-line icon"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?php echo e(route('admin.courses.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.courses.*') ? 'active' : ''); ?>">
            <i class="fas fa-book icon"></i>
            <span>Courses</span>
        </a>

        <a href="<?php echo e(route('admin.course-categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.course-categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-folder-tree icon"></i>
            <span>Course Categories</span>
        </a>

        <a href="<?php echo e(route('admin.instructors.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.instructors.*') || request()->routeIs('admin.teachers.*') ? 'active' : ''); ?>">
            <i class="fas fa-chalkboard-user icon"></i>
            <span>Instructors</span>
        </a>

        <a href="<?php echo e(route('admin.students.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.students.*') ? 'active' : ''); ?>">
            <i class="fas fa-users icon"></i>
            <span>Students</span>
        </a>

        <a href="<?php echo e(route('admin.payments.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>">
            <i class="fas fa-money-bill-wave icon"></i>
            <span>Payments</span>
        </a>

        <a href="<?php echo e(route('admin.subscriptions.list')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.subscriptions.*') ? 'active' : ''); ?>">
            <i class="fas fa-credit-card icon"></i>
            <span>Subscription</span>
        </a>

        <a href="<?php echo e(route('admin.wallet.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.wallet.*') ? 'active' : ''); ?>">
            <i class="fas fa-wallet icon"></i>
            <span>Wallet</span>
        </a>

        <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
            <i class="fas fa-chart-bar icon"></i>
            <span>Reports</span>
        </a>

        <a href="<?php echo e(route('admin.access-control.index')); ?>" class="nav-item roles-permissions <?php echo e(request()->routeIs('admin.access-control.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'active' : ''); ?>">
            <i class="fas fa-shield-alt icon"></i>
            <span>Roles & Permissions</span>
        </a>

        <a href="<?php echo e(route('admin.accounts.index')); ?>" class="nav-item admin-accounts <?php echo e(request()->routeIs('admin.accounts.*') ? 'active' : ''); ?>">
            <i class="fas fa-user-cog icon"></i>
            <span>Admin Accounts</span>
        </a>
        <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
            <i class="fas fa-cog icon"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Sidebar Footer - Logout -->
    <div class="sidebar-footer">
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt icon"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/components/admin-sidebar.blade.php ENDPATH**/ ?>