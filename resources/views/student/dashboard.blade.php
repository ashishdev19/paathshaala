@extends('layouts.student.app')

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 50%, #6d28d9 100%);
        border-radius: 1.25rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
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
        border: 1px solid #e9d5ff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #d8b4fe;
    }

    .stat-number {
        font-size: 2.25rem;
        font-weight: 800;
        color: #7c3aed;
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
        background: linear-gradient(135deg, #d8b4fe 0%, #c4b5fd 100%);
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
        border: 1px solid #f3e8ff;
        border-left: 3px solid transparent;
        border-radius: 0.75rem;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-link:hover {
        background: #f3e8ff;
        border-left-color: #a855f7;
        transform: translateX(4px);
    }

    .action-icon {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #d8b4fe 0%, #c4b5fd 100%);
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
        border: 1px solid #e9d5ff;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .learning-path {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .recommendation-item {
        padding: 1.25rem;
        background: #f3e8ff;
        border: 1px solid #d8b4fe;
        border-radius: 0.75rem;
        border-left: 3px solid #a855f7;
    }

    .recommendation-title {
        font-weight: 700;
        color: #6b21a8;
        margin-bottom: 0.25rem;
    }

    .recommendation-text {
        font-size: 0.875rem;
        color: #7c3aed;
    }

    .streak-box {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border-radius: 1rem;
        padding: 1.75rem;
        text-align: center;
    }

    .streak-number {
        font-size: 3rem;
        font-weight: 800;
        margin: 0.5rem 0;
    }

    .streak-label {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.85);
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

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-content">
        <h1>Welcome back, {{ auth()->user()->name }}!</h1>
        <p>Keep up your learning journey and achieve your goals</p>
    </div>
    <div class="welcome-icon">🎓</div>
</div>

<!-- Statistics Grid -->
<div class="dashboard-grid">
    <!-- Total Enrollments -->
    <div class="stat-card">
        <div class="stat-label">Enrolled Courses</div>
        <div class="stat-number">{{ $stats['total_enrollments'] ?? 0 }}</div>
        <div class="stat-icon">📚</div>
    </div>

    <!-- Active Courses -->
    <div class="stat-card">
        <div class="stat-label">In Progress</div>
        <div class="stat-number">{{ $stats['active_courses'] ?? 0 }}</div>
        <div class="stat-icon">▶️</div>
    </div>

    <!-- Completed Courses -->
    <div class="stat-card">
        <div class="stat-label">Completed</div>
        <div class="stat-number">{{ $stats['completed_courses'] ?? 0 }}</div>
        <div class="stat-icon">✓</div>
    </div>

    <!-- Average Progress -->
    <div class="stat-card">
        <div class="stat-label">Avg Progress</div>
        <div class="stat-number">{{ round($stats['average_progress'] ?? 0) }}%</div>
        <div class="stat-icon">📊</div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="content-grid">
    <!-- Learning Path Section -->
    <div class="section-card">
        <h2 class="section-title">My Learning Path</h2>
        <div class="learning-path">
            <a href="{{ route('student.courses') }}" class="action-link">
                <div class="action-icon">📖</div>
                <div class="action-content">
                    <h3>My Courses</h3>
                    <p>View and access enrolled courses</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #a855f7;"></i>
            </a>

            <a href="{{ route('student.courses.browse') }}" class="action-link">
                <div class="action-icon">🔍</div>
                <div class="action-content">
                    <h3>Explore Courses</h3>
                    <p>Discover new learning opportunities</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #a855f7;"></i>
            </a>

            <a href="#" class="action-link" style="cursor: not-allowed; opacity: 0.6;">
                <div class="action-icon">📈</div>
                <div class="action-content">
                    <h3>My Progress</h3>
                    <p>Track your learning performance</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #a855f7;"></i>
            </a>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Recommendations -->
        <div class="section-card">
            <h2 class="section-title">Recommendations</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div class="recommendation-item">
                    <div class="recommendation-title">Python Fundamentals</div>
                    <div class="recommendation-text">Perfect next step for your learning path</div>
                </div>
                <div class="recommendation-item">
                    <div class="recommendation-title">Web Development Path</div>
                    <div class="recommendation-text">Build modern, responsive applications</div>
                </div>
                <div class="recommendation-item">
                    <div class="recommendation-title">Data Science Basics</div>
                    <div class="recommendation-text">Start your data science journey</div>
                </div>
            </div>
        </div>

        <!-- Learning Streak -->
        <div class="streak-box">
            <div style="font-size: 2rem;">🔥</div>
            <div class="streak-number">{{ $stats['streak'] ?? 0 }}</div>
            <div class="streak-label">Learning Streak - Days in a Row</div>
            <div style="font-size: 0.875rem; margin-top: 0.75rem; color: rgba(255, 255, 255, 0.8);">Keep it up! You're doing amazing 🚀</div>
        </div>
    </div>
</div>

<!-- Footer -->
<x-dashboard-footer />

@endsection
