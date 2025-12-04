<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PaathShaala') }} - Super Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #1e293b;
        }

        main {
            margin-left: 16rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-nav {
            background: white;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .nav-content {
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 100%;
        }

        .nav-left h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-info p:first-child {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0;
        }

        .user-info p:last-child {
            font-size: 0.8125rem;
            color: #64748b;
            margin: 0.25rem 0 0 0;
        }

        .page-content {
            flex: 1;
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

        @media (max-width: 640px) {
            main {
                margin-left: 0;
            }

            .user-info {
                display: none;
            }

            .nav-content {
                padding: 1rem 1.5rem;
            }

            .page-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="antialiased">
    <div style="min-height: 100vh; background-color: #f3f4f6;">
        <!-- Sidebar Component -->
        <x-superadmin-sidebar />

        <!-- Main Content -->
        <main>
            <!-- Top Navigation Bar -->
            <div class="top-nav">
                <div class="nav-content">
                    <!-- Page Header -->
                    <div>
                        @hasSection('header')
                            @yield('header')
                        @else
                            <h1 style="font-size: 1.5rem; font-weight: bold; color: #111827;">Dashboard</h1>
                        @endif
                    </div>

                    <!-- Right Actions -->
                    <div class="nav-right">
                        <!-- User Profile -->
                        <div class="user-profile">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <p style="font-size: 0.875rem; font-weight: 500; color: #111827; margin: 0;">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Super Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
                
                <!-- Footer -->
                <x-dashboard-footer />
            </div>
        </main>
    </div>
</body>
</html>
