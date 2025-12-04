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
        display: flex;
        flex-direction: column;
        padding: 0.75rem 0;
        overflow-y: auto;
    }

    .nav-section {
        padding: 0.5rem 0;
        margin-top: 0.5rem;
    }

    .nav-section-title {
        padding: 0.5rem 1rem;
        color: rgba(255,255,255,0.45);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        padding: 0.9rem 1rem;
        color: rgba(255,255,255,0.85);
        text-decoration: none;
        transition: all 0.18s ease;
        margin: 0.25rem 0.5rem;
        border-radius: 0.75rem;
    }

    .nav-item .icon {
        width: 2.1rem;
        height: 2.1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: rgba(255,255,255,0.03);
        font-size: 1rem;
    }

    .nav-item:hover {
        transform: translateX(4px);
        background: rgba(99,102,241,0.08);
        color: #e6efff;
    }

    /* Active pill like the screenshot */
    .nav-item.active {
        background: linear-gradient(90deg, rgba(59,130,246,0.12), rgba(99,102,241,0.06));
        color: #dbeafe;
        box-shadow: 0 6px 18px rgba(15,23,42,0.25);
    }

    .nav-item.active .icon {
        background: linear-gradient(135deg,#3b82f6,#2563eb);
        color: white;
    }

    .logout-section {
        margin-top: auto;
        padding: 1rem 0.75rem;
        border-top: 1px solid rgba(255,255,255,0.04);
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 1rem;
        border-radius: 0.75rem;
        background: rgba(220,38,38,0.06);
        color: #fecaca;
        border: 1px solid rgba(220,38,38,0.08);
        margin: 0 0.5rem;
        font-weight: 600;
    }

    .logout-btn:hover { transform: translateX(4px); }
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
        <!-- Ordered Navigation -->
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-chart-line icon"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?php echo e(route('admin.courses.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.courses.*') ? 'active' : ''); ?>">
            <i class="fas fa-book icon"></i>
            <span>Courses</span>
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

        <a href="<?php echo e(route('admin.access-control.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.access-control.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'active' : ''); ?>">
            <i class="fas fa-shield-alt icon"></i>
            <span>Roles & Permissions</span>
        </a>

        <a href="<?php echo e(route('admin.accounts.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.accounts.*') ? 'active' : ''); ?>">
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