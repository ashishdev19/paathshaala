@extends('layouts.instructor.app')

@section('content')
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1e40af 100%);
        border-radius: 1.25rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-content h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .welcome-content p {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.85);
    }

    .welcome-icon {
        font-size: 3.5rem;
        opacity: 0.8;
    }

    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        border: 1px solid #e5e7eb;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    .stat-number {
        font-size: 2.25rem;
        font-weight: 800;
        color: #3b82f6;
        letter-spacing: -1px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-top: 1rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1.5rem;
        letter-spacing: -0.5px;
    }

    .action-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: white;
        border: 1px solid #f3f4f6;
        border-left: 3px solid transparent;
        border-radius: 0.75rem;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-link:hover {
        background: #f3f4f6;
        border-left-color: #3b82f6;
        transform: translateX(4px);
    }

    .action-icon {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .action-content h3 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .action-content p {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .section-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .learning-path {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .info-item {
        padding: 1.25rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        border-left: 3px solid #3b82f6;
    }

    .info-title {
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 0.25rem;
    }

    .info-text {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .stats-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-radius: 1rem;
        padding: 1.75rem;
        text-align: center;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0.5rem 0;
    }

    .stats-label {
        font-size: 0.875rem;
        color: rgba(30, 58, 138, 0.8);
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .welcome-banner {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr 1fr;
        }

        .section-title {
            font-size: 1.25rem;
        }

        .stat-number {
            font-size: 1.75rem;
        }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <h1 style="font-size: 2.25rem; font-weight: 800; color: #1f2937; margin-bottom: 0.5rem;">Instructor Dashboard</h1>
    <p style="color: #6b7280; font-size: 0.95rem;">Manage courses, students, and track progress</p>
</div>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-content">
        <h1>Welcome back, {{ auth()->user()->name }}!</h1>
        <p>Manage your courses and track student progress</p>
    </div>
    <div class="welcome-icon">🎓</div>
</div>

<!-- Statistics Grid -->
<div class="dashboard-grid">
    <!-- My Courses -->
    <div class="stat-card">
        <div class="stat-label">My Courses</div>
        <div class="stat-number">{{ $stats['courses'] ?? 0 }}</div>
        <div class="stat-icon">📚</div>
    </div>

    <!-- Total Students -->
    <div class="stat-card">
        <div class="stat-label">Total Students</div>
        <div class="stat-number">{{ $stats['students'] ?? 0 }}</div>
        <div class="stat-icon">👥</div>
    </div>

    <!-- Total Enrollments -->
    <div class="stat-card">
        <div class="stat-label">Enrollments</div>
        <div class="stat-number">{{ $stats['enrollments'] ?? 0 }}</div>
        <div class="stat-icon">📊</div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="content-grid">
    <!-- Course Management Section -->
    <div class="section-card">
        <h2 class="section-title">Course Management</h2>
        <div class="learning-path">
            <a href="{{ route('instructor.courses.index') }}" class="action-link">
                <div class="action-icon">📖</div>
                <div class="action-content">
                    <h3>My Courses</h3>
                    <p>View and manage all courses</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #3b82f6;"></i>
            </a>

            <a href="{{ route('instructor.courses.create.basics') }}" class="action-link">
                <div class="action-icon">➕</div>
                <div class="action-content">
                    <h3>Create Course</h3>
                    <p>Launch a new learning course</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #3b82f6;"></i>
            </a>

            <a href="{{ route('instructor.students.index') }}" class="action-link">
                <div class="action-icon">👨‍🎓</div>
                <div class="action-content">
                    <h3>Manage Students</h3>
                    <p>View enrolled students</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #3b82f6;"></i>
            </a>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Course Statistics -->
        <div class="section-card">
            <h2 class="section-title">Statistics</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div class="info-item">
                    <div class="info-title">Active Courses</div>
                    <div class="info-text">{{ $stats['active_courses'] ?? 0 }} courses running</div>
                </div>
                <div class="info-item">
                    <div class="info-title">Total Modules</div>
                    <div class="info-text">{{ $stats['modules'] ?? 0 }} course modules</div>
                </div>
                <div class="info-item">
                    <div class="info-title">Pending Reviews</div>
                    <div class="info-text">{{ $stats['pending'] ?? 0 }} assignments pending</div>
                </div>
            </div>
        </div>

        <!-- Course Overview -->
        <div class="stats-box">
            <div style="font-size: 2rem;">📈</div>
            <div class="stats-number">{{ $stats['courses'] ?? 0 }}</div>
            <div class="stats-label">Active Teaching Courses</div>
            <div style="font-size: 0.875rem; margin-top: 0.75rem; color: rgba(30, 58, 138, 0.7);">Manage and track all courses</div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="section-card" style="margin-top: 2rem;">
    <h2 class="section-title">About Your Dashboard</h2>
    <p style="color: #6b7280; line-height: 1.6; margin: 0;">
        Welcome to your Instructor Dashboard! Here you can manage all your courses, track student progress, and monitor course enrollments. 
        Use the navigation menu to access course creation tools, student management features, and detailed analytics to help you deliver the best educational experience.
    </p>
</div>

<!-- Footer -->
<x-dashboard-footer />

@endsection
