<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Join {{ $onlineClass->title }} - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Join Live Class</h1>
                <p class="text-gray-600">You're about to join the live session</p>
            </div>

            <!-- Class Info Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-500 to-blue-500 px-6 py-4">
                    <div class="flex items-center justify-center">
                        <div class="w-3 h-3 bg-red-400 rounded-full mr-2 animate-pulse"></div>
                        <span class="text-white font-semibold">LIVE NOW</span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $onlineClass->title }}</h2>
                    <p class="text-gray-600 mb-4">{{ $onlineClass->course->title }}</p>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Instructor:</span>
                            <span class="font-medium text-gray-900">{{ $onlineClass->course->teacher->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Duration:</span>
                            <span class="font-medium text-gray-900">{{ $onlineClass->duration_minutes }} minutes</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Started:</span>
                            <span class="font-medium text-gray-900">{{ $onlineClass->scheduled_at->format('h:i A') }}</span>
                        </div>
                    </div>

                    @if($onlineClass->meeting_id || $onlineClass->meeting_password)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3">Meeting Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            @if($onlineClass->meeting_id)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Meeting ID:</span>
                                <div class="flex items-center space-x-2">
                                    <span class="font-mono text-sm font-medium text-gray-900">{{ $onlineClass->meeting_id }}</span>
                                    <button onclick="copyToClipboard('{{ $onlineClass->meeting_id }}')" 
                                            class="text-indigo-600 hover:text-indigo-800 text-sm">
                                        Copy
                                    </button>
                                </div>
                            </div>
                            @endif
                            @if($onlineClass->meeting_password)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Password:</span>
                                <div class="flex items-center space-x-2">
                                    <span class="font-mono text-sm font-medium text-gray-900">{{ $onlineClass->meeting_password }}</span>
                                    <button onclick="copyToClipboard('{{ $onlineClass->meeting_password }}')" 
                                            class="text-indigo-600 hover:text-indigo-800 text-sm">
                                        Copy
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Join Options -->
            <div class="space-y-4">
                @if($onlineClass->meeting_link)
                    <a href="{{ $onlineClass->meeting_link }}" 
                       target="_blank"
                       onclick="markAttendance()"
                       class="w-full bg-green-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-green-700 transition duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                        </svg>
                        <span>Join Meeting Now</span>
                    </a>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800 mb-1">Manual Join Required</h3>
                                <p class="text-sm text-yellow-700">
                                    No direct meeting link available. Please use the meeting details above to join manually through your preferred platform (Zoom, Google Meet, etc.).
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Alternative Actions -->
                <div class="flex space-x-3">
                    <a href="{{ route('online-classes.show', $onlineClass) }}" 
                       class="flex-1 bg-gray-200 text-gray-800 px-4 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 text-center">
                        Class Details
                    </a>
                    <a href="{{ route('online-classes.index') }}" 
                       class="flex-1 border border-gray-300 text-gray-700 px-4 py-3 rounded-lg font-semibold hover:bg-gray-50 transition duration-300 text-center">
                        All Classes
                    </a>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-white rounded-lg shadow p-4">
                <h3 class="font-semibold text-gray-900 mb-3">Before You Join</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Ensure you have a stable internet connection</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Test your camera and microphone</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Find a quiet space with good lighting</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Have pen and paper ready for notes</span>
                    </li>
                </ul>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Need help? Contact 
                    <a href="mailto:support@paathshaala.com" class="text-indigo-600 hover:text-indigo-800">
                        support@paathshaala.com
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div id="copyToast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300">
        Copied to clipboard!
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast();
            });
        }

        function showToast() {
            const toast = document.getElementById('copyToast');
            toast.classList.remove('translate-x-full');
            setTimeout(() => {
                toast.classList.add('translate-x-full');
            }, 2000);
        }

        function markAttendance() {
            // Mark attendance when joining the meeting
            fetch('{{ route("online-classes.attendance", $onlineClass) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (response.ok) {
                    console.log('Attendance marked successfully');
                }
            }).catch(error => {
                console.error('Error marking attendance:', error);
            });
        }

        // Auto-refresh every 30 seconds to check if class is still live
        setInterval(() => {
            fetch(window.location.href, {
                method: 'HEAD'
            }).then(response => {
                if (!response.ok) {
                    // Class might have ended, redirect to class details
                    window.location.href = '{{ route("online-classes.show", $onlineClass) }}';
                }
            });
        }, 30000);

        // Add CSRF token to meta tag if not present
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
    </script>
</body>
</html>