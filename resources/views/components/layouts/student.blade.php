<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Paathshaala') }} - @yield('title', 'Student Panel')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Sidebar -->
    @include('components.shared.sidebar', ['role' => 'student'])

    <!-- Main Content Area with Left Margin -->
    <div class="ml-64 min-h-screen flex flex-col">
        <!-- Header -->
        @include('components.shared.header', ['role' => 'student'])

        <!-- Scrollable Page Content -->
        <main class="flex-1 bg-gray-100">
            <div class="p-8">
                @if(isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Footer (Full Width Below Sidebar) -->
    <div class="ml-64">
        @include('components.shared.footer', ['role' => 'student'])
    </div>
    
    @stack('scripts')
</body>
</html>