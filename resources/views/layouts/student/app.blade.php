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
            text-decoration: none;
            display: flex;
            align-items: center;
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
            position: relative;
            cursor: pointer;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: #008080;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(0, 128, 128, 0.3);
            transition: transform 0.2s ease;
        }

        .user-profile:hover .user-avatar {
            transform: scale(1.05);
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

        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            min-width: 200px;
            display: none;
            flex-direction: column;
            z-index: 50;
            border: 1px solid #e5e7eb;
        }

        .profile-dropdown.active {
            display: flex;
        }

        .profile-dropdown-item {
            padding: 0.75rem 1rem;
            color: #1f2937;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .profile-dropdown-item:hover {
            background: #f3f4f6;
            color: #7c3aed;
        }

        .profile-dropdown-item:first-child {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }

        .profile-dropdown-item:last-child {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }

        .profile-dropdown-item.logout {
            color: #dc2626;
        }

        .profile-dropdown-item.logout:hover {
            background: #fee2e2;
            color: #991b1b;
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
                    <a href="{{ route('notifications.index') }}" class="notification-bell">
                        <i class="fas fa-bell"></i>
                        @php
                            $unreadCount = auth()->user()->unreadCustomNotifications()->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>

                    <div class="user-profile" id="profileDropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">Student</span>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="profile-dropdown" id="dropdownMenu">
                            <a href="#" class="profile-dropdown-item" style="cursor: not-allowed; opacity: 0.6;">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="#" class="profile-dropdown-item" style="cursor: not-allowed; opacity: 0.6;">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                                @csrf
                                <button type="submit" class="profile-dropdown-item logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
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

    <script>
        // Profile Dropdown Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdown = document.getElementById('profileDropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (profileDropdown && dropdownMenu) {
                profileDropdown.addEventListener('click', function(e) {
                    // Don't toggle if clicking the logout button or its container
                    if (e.target.closest('form') || e.target.closest('.logout')) {
                        return;
                    }
                    e.preventDefault();
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('active');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileDropdown.contains(e.target)) {
                        dropdownMenu.classList.remove('active');
                    }
                });

                // Close dropdown when clicking on a menu item (except logout form)
                const dropdownItems = dropdownMenu.querySelectorAll('a.profile-dropdown-item');
                dropdownItems.forEach(item => {
                    item.addEventListener('click', function() {
                        dropdownMenu.classList.remove('active');
                    });
                });

                // Handle logout form submission
                const logoutForm = dropdownMenu.querySelector('form');
                if (logoutForm) {
                    logoutForm.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            }
        });
    </script>
</body>
</html>
