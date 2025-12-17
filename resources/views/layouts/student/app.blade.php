<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Medniks</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f3e8ff 0%, #faf5ff 100%);
            color: #1f2937;
            overflow-x: hidden;
        }

        .main-content-wrapper {
            margin-left: 16rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            height: 4rem;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .navbar-content {
            height: 100%;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #7c3aed;
            letter-spacing: -0.5px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-bell {
            position: relative;
            font-size: 1.25rem;
            color: #6b7280;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .notification-bell:hover {
            color: #7c3aed;
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            font-weight: 700;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-left: 1rem;
            border-left: 1px solid #e5e7eb;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #a855f7 0%, #d946ef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(168, 85, 247, 0.3);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .page-content {
            flex: 1;
            padding: 2rem;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            letter-spacing: -1px;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-content-wrapper {
                margin-left: 0;
            }

            .student-sidebar {
                transform: translateX(-100%);
            }

            .student-sidebar.open {
                transform: translateX(0);
            }

            .navbar-content {
                padding: 0 1rem;
            }

            .page-content {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Student Sidebar Component -->
    <x-student-sidebar />

    <!-- Main Content Wrapper -->
    <div class="main-content-wrapper">
        <!-- Top Navigation Bar -->
        <nav class="top-navbar">
            <div class="navbar-content">
                <div class="navbar-left">
                    <h2 class="navbar-title">Student Portal</h2>
                </div>

                <div class="navbar-right">
                    <div class="notification-bell">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>

                    <div class="user-profile">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">Student</span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>
</body>
</html>
