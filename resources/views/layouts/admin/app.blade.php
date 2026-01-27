<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Medniks') }} - @yield('title', 'Admin Panel')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .top-nav {
            position: fixed;
            left: 16rem;
            top: 0;
            right: 0;
            height: 4rem;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            z-index: 40;
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            cursor: pointer;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
            transition: transform 0.2s ease;
        }

        .user-info:hover .user-avatar {
            transform: scale(1.05);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #0f172a;
        }

        .user-role {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: capitalize;
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
            border: 1px solid #e2e8f0;
        }

        .profile-dropdown.active {
            display: flex;
        }

        .profile-dropdown-item {
            padding: 0.75rem 1rem;
            color: #0f172a;
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
            background: #f1f5f9;
            color: #6366f1;
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
            margin-left: 16rem;
            margin-top: 4rem;
            padding: 2rem;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .top-nav {
                left: 0;
            }

            .page-content {
                margin-left: 0;
                padding: 1rem;
            }

            .user-details {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Admin Sidebar -->
    <x-admin-sidebar />

    <!-- Top Navigation -->
    <div class="top-nav">
        <div class="nav-content">
            <div class="nav-left">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #0f172a;">@yield('header', 'Dashboard')</h2>
            </div>
            <div class="nav-right">
                <div class="user-info" id="profileDropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="user-role">Admin</div>
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
    </div>

    <!-- Main Content Area -->
    <div class="page-content">
        @yield('content')
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
