<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $onlineClass->title }} - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Paathshaala</h1>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('online-classes.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Back to Classes
                    </a>
                    <div class="text-sm text-gray-600">
                        Welcome, {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-8">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                @if($onlineClass->type === 'live')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                        <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                        Live Class
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                        </svg>
                                        Recorded Class
                                    </span>
                                @endif

                                <!-- Status Badge -->
                                @php
                                    $now = now();
                                    $scheduledTime = $onlineClass->scheduled_at;
                                    $classEndTime = $scheduledTime->copy()->addMinutes($onlineClass->duration_minutes);
                                    
                                    if ($onlineClass->type === 'live') {
                                        if ($now->greaterThanOrEqualTo($scheduledTime->copy()->subMinutes(15)) && $now->lessThanOrEqualTo($classEndTime)) {
                                            $status = 'live';
                                            $statusText = 'Live Now';
                                            $statusClass = 'bg-green-500 text-white';
                                        } elseif ($now->lessThan($scheduledTime)) {
                                            $status = 'upcoming';
                                            $statusText = 'Upcoming';
                                            $statusClass = 'bg-yellow-500 text-white';
                                        } else {
                                            $status = 'completed';
                                            $statusText = 'Completed';
                                            $statusClass = 'bg-gray-500 text-white';
                                        }
                                    } else {
                                        $status = 'available';
                                        $statusText = 'Available';
                                        $statusClass = 'bg-blue-500 text-white';
                                    }
                                @endphp

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            <h1 class="text-3xl font-bold text-white mb-2">{{ $onlineClass->title }}</h1>
                            <p class="text-indigo-100 text-lg">{{ $onlineClass->course->title }}</p>
                            <p class="text-indigo-200">by {{ $onlineClass->course->teacher->name }}</p>
                        </div>

                        @role('teacher|admin')
                        @if($onlineClass->course->teacher_id === auth()->id() || auth()->user()->hasRole('admin'))
                        <div class="flex space-x-2">
                            <a href="{{ route('online-classes.edit', $onlineClass) }}" 
                               class="bg-white/20 text-white px-4 py-2 rounded-lg font-medium hover:bg-white/30 transition duration-300">
                                Edit Class
                            </a>
                        </div>
                        @endif
                        @endrole
                    </div>
                </div>

                <!-- Class Details -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Class Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Class Details</h3>
                            <div class="space-y-3">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                                    </svg>
                                    <span>{{ $onlineClass->scheduled_at->format('l, F j, Y') }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                    </svg>
                                    <span>{{ $onlineClass->scheduled_at->format('h:i A') }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                    </svg>
                                    <span>{{ $onlineClass->duration_minutes }} minutes</span>
                                </div>
                                @if($onlineClass->type === 'live' && $onlineClass->meeting_id)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                    </svg>
                                    <span>Meeting ID: {{ $onlineClass->meeting_id }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Panel -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                            <div class="space-y-3">
                                @if($onlineClass->type === 'live' && $canJoin)
                                    <a href="{{ route('online-classes.join', $onlineClass) }}" 
                                       class="w-full bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 text-center block">
                                        🔴 Join Live Class
                                    </a>
                                @elseif($onlineClass->type === 'live' && $status === 'upcoming')
                                    <div class="text-center">
                                        <button disabled 
                                                class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                            Class starts {{ $onlineClass->scheduled_at->diffForHumans() }}
                                        </button>
                                        <p class="text-sm text-gray-500 mt-2">You can join 15 minutes before the scheduled time</p>
                                    </div>
                                @elseif($onlineClass->type === 'recorded' && $onlineClass->video_url)
                                    <a href="{{ route('online-classes.watch', $onlineClass) }}" 
                                       class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 text-center block">
                                        ▶️ Watch Recording
                                    </a>
                                @endif

                                @role('student')
                                @if(!$isEnrolled)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800 text-sm mb-3">
                                        You need to be enrolled in this course to access the class.
                                    </p>
                                    <a href="{{ route('courses.show', $onlineClass->course->id) }}" 
                                       class="text-yellow-700 underline text-sm font-medium">
                                        Enroll in Course →
                                    </a>
                                </div>
                                @endif
                                @endrole
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($onlineClass->description)
                    <div class="border-t border-gray-200 pt-8 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">About This Class</h3>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($onlineClass->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Meeting Details (for live classes) -->
                    @if($onlineClass->type === 'live' && ($canJoin || auth()->user()->hasRole('teacher') || auth()->user()->hasRole('admin')))
                    <div class="border-t border-gray-200 pt-8 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Meeting Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if($onlineClass->meeting_id)
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-gray-700">Meeting ID:</span>
                                    <span class="ml-2 font-mono text-gray-900">{{ $onlineClass->meeting_id }}</span>
                                </div>
                            @endif
                            @if($onlineClass->meeting_password)
                                <div class="mb-3">
                                    <span class="text-sm font-medium text-gray-700">Password:</span>
                                    <span class="ml-2 font-mono text-gray-900">{{ $onlineClass->meeting_password }}</span>
                                </div>
                            @endif
                            @if($onlineClass->meeting_link)
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Direct Link:</span>
                                    <a href="{{ $onlineClass->meeting_link }}" target="_blank" 
                                       class="ml-2 text-indigo-600 hover:text-indigo-800 text-sm underline">
                                        {{ $onlineClass->meeting_link }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Enrolled Students (for teachers/admin) -->
                    @role('teacher|admin')
                    @if($onlineClass->course->teacher_id === auth()->id() || auth()->user()->hasRole('admin'))
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Enrolled Students ({{ $enrolledStudents->count() }})
                        </h3>
                        @if($enrolledStudents->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($enrolledStudents as $enrollment)
                                    <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                                        <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">
                                                {{ substr($enrollment->student->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $enrollment->student->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $enrollment->student->email }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No students enrolled in this course yet.</p>
                        @endif
                    </div>
                    @endif
                    @endrole
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh for live classes -->
    @if($onlineClass->type === 'live')
    <script>
        // Refresh every 30 seconds for live classes to update status
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
    @endif
</body>
</html>