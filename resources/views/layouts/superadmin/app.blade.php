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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Smooth scrollbar for sidebar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #111827;
        }

        ::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6B7280;
        }

        /* Main content area */
        main {
            margin-left: 16rem;
        }

        /* Animation for page load */
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

        .page-content {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar Component -->
        <x-superadmin-sidebar />

        <!-- Main Content -->
        <main class="transition-all duration-300">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="px-6 py-4 flex items-center justify-between">
                    <!-- Page Header -->
                    <div>
                        @if (isset($header))
                            {{ $header }}
                        @else
                            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        @endif
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- User Profile Dropdown (Optional) -->
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                                <p class="text-xs text-gray-500">Super Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Optional: Toast Notifications -->
    @if ($errors->any())
        <script>
            console.error(@json($errors->all()));
        </script>
    @endif

    @if (session('success'))
        <script>
            console.log(@json(session('success')));
        </script>
    @endif
</body>
</html>
