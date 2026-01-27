@extends('layouts.admin.app')

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #cbd5e1;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.blue { background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05)); color: #3b82f6; }
    .stat-icon.green { background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05)); color: #22c55e; }
    .stat-icon.purple { background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(168, 85, 247, 0.05)); color: #a855f7; }
    .stat-icon.orange { background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(249, 115, 22, 0.05)); color: #f97316; }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0.5rem 0;
    }

    .welcome-banner {
        background: #008080;
        border-radius: 1.25rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-text h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .welcome-text p {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }

    .welcome-icon {
        font-size: 4rem;
        opacity: 0.3;
    }

    .section-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .section-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .section-header .icon {
        font-size: 1.5rem;
    }

    .action-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        margin-bottom: 0.5rem;
        background: #f8fafc;
        border-radius: 0.75rem;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .action-link:hover {
        background: #f1f5f9;
        border-left-color: #6366f1;
        transform: translateX(4px);
    }

    .action-link span:last-child {
        color: #94a3b8;
    }

    .info-grid {
        display: grid;
        gap: 1rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.875rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #64748b;
    }

    .info-value {
        font-weight: 600;
        color: #0f172a;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 3rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
    }
</style>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-text">
        <h2>Welcome, Admin! 👋</h2>
        <p>Manage platform content, users, courses and subscriptions.</p>
    </div>
    <div class="welcome-icon">
        ⚙️
    </div>
</div>

<!-- Stats Grid -->
<div class="dashboard-grid">
    <!-- Total Instructors -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Instructors</span>
            <div class="stat-icon blue">
                <i class="fas fa-chalkboard-user"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['professors'] ?? 0 }}</div>
    </div>

    <!-- Total Students -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Students</span>
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['students'] ?? 0 }}</div>
    </div>

    <!-- Total Courses -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Courses</span>
            <div class="stat-icon purple">
                <i class="fas fa-book"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['courses'] ?? 0 }}</div>
    </div>

    <!-- Total Enrollments -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Enrollments</span>
            <div class="stat-icon orange">
                <i class="fas fa-graduation-cap"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['enrollments'] ?? 0 }}</div>
    </div>
</div>

<!-- Main Grid Section -->
<div class="section-grid">
    <!-- Quick Actions -->
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-bolt" style="color: #f59e0b;"></i>
            <h3>Quick Actions</h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <a href="{{ route('admin.teachers.index') }}" class="action-link">
                <span>Manage Instructors</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
            <a href="{{ route('admin.students.index') }}" class="action-link">
                <span>Manage Students</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
            <a href="{{ route('admin.courses.index') }}" class="action-link">
                <span>Manage Courses</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
            <a href="{{ route('admin.course-approvals.index') }}" class="action-link">
                <span>Course Approvals</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
        </div>
    </div>

    <!-- System Information -->
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-info-circle" style="color: #6366f1;"></i>
            <h3>System Info</h3>
        </div>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Application Name:</span>
                <span class="info-value">{{ config('app.name', 'Medniks') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Environment:</span>
                <span class="info-value" style="color: #10b981;">{{ config('app.env') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Current User:</span>
                <span class="info-value">{{ auth()->user()->name ?? 'Unknown' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Pending Approvals:</span>
                <span class="info-value">{{ $stats['pending_approvals'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Additional Actions -->
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-cog" style="color: #8b5cf6;"></i>
            <h3>Additional Tools</h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <a href="{{ route('admin.subscriptions.list') }}" class="action-link">
                <span>Subscriptions</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
            <a href="{{ route('admin.wallet.index') }}" class="action-link">
                <span>Wallet Management</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="action-link">
                <span>Reports & Analytics</span>
                <span style="font-size: 1.25rem;">→</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="section-card" style="margin-top: 2rem;">
    <div class="section-header">
        <i class="fas fa-history" style="color: #ec4899;"></i>
        <h3>Recent Activity</h3>
    </div>
    <div class="empty-state">
        <div class="empty-state-icon">📭</div>
        <p>No recent activity to display</p>
    </div>
</div>
@endsection
