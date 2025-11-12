<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Classes - Paathshaala</title>
    
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Online Classes</h1>
                        <p class="text-gray-600 mt-2">Manage and attend your online classes</p>
                    </div>
                    
                    @role('teacher|admin')
                    <a href="{{ route('online-classes.create') }}" 
                       class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                        Schedule New Class
                    </a>
                    @endrole
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <form method="GET" action="{{ route('online-classes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Class Type</label>
                        <select name="type" id="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                            <option value="live" {{ request('type') == 'live' ? 'selected' : '' }}>Live Classes</option>
                            <option value="recorded" {{ request('type') == 'recorded' ? 'selected' : '' }}>Recorded Classes</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Classes</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>Live Now</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select name="course_id" id="course_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all" {{ request('course_id') == 'all' ? 'selected' : '' }}>All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition duration-300">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Classes Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($classes as $class)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Class Type Badge -->
                        <div class="p-4 pb-0">
                            <div class="flex justify-between items-start mb-3">
                                @if($class->type === 'live')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <div class="w-2 h-2 bg-red-400 rounded-full mr-1"></div>
                                        Live Class
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                        </svg>
                                        Recorded
                                    </span>
                                @endif

                                <!-- Status Indicator -->
                                @php
                                    $now = now();
                                    $scheduledTime = $class->scheduled_at;
                                    $classEndTime = $scheduledTime->copy()->addMinutes($class->duration_minutes);
                                    
                                    if ($class->type === 'live') {
                                        if ($now->greaterThanOrEqualTo($scheduledTime->copy()->subMinutes(15)) && $now->lessThanOrEqualTo($classEndTime)) {
                                            $status = 'live';
                                            $statusText = 'Live Now';
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } elseif ($now->lessThan($scheduledTime)) {
                                            $status = 'upcoming';
                                            $statusText = 'Upcoming';
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                        } else {
                                            $status = 'completed';
                                            $statusText = 'Completed';
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                        }
                                    } else {
                                        $status = 'available';
                                        $statusText = 'Available';
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    }
                                @endphp

                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $class->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($class->description, 100) }}</p>
                        </div>

                        <!-- Course Info -->
                        <div class="px-4 pb-4">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <span class="font-medium text-indigo-600">{{ $class->course->title }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $class->course->teacher->name }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $class->scheduled_at->format('M d, Y \a\t h:i A') }}
                                <span class="mx-2">•</span>
                                <span>{{ $class->duration_minutes }} min</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-4 pb-4 pt-0">
                            <div class="flex gap-2">
                                @if($class->type === 'live' && $status === 'live')
                                    <a href="{{ route('online-classes.join', $class) }}" 
                                       class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-300 text-center">
                                        Join Live
                                    </a>
                                @elseif($class->type === 'live' && $status === 'upcoming')
                                    <button disabled 
                                            class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-semibold cursor-not-allowed text-center">
                                        Starts {{ $class->scheduled_at->diffForHumans() }}
                                    </button>
                                @elseif($class->type === 'recorded' && $class->video_url)
                                    <a href="{{ route('online-classes.watch', $class) }}" 
                                       class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 text-center">
                                        Watch Recording
                                    </a>
                                @endif

                                <a href="{{ route('online-classes.show', $class) }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                                    Details
                                </a>

                                @role('teacher|admin')
                                @if($class->course->teacher_id === auth()->id() || auth()->user()->hasRole('admin'))
                                <a href="{{ route('online-classes.edit', $class) }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                                    Edit
                                </a>
                                @endif
                                @endrole
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No classes found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @role('teacher|admin')
                                Get started by scheduling your first online class.
                            @else
                                No classes match your current filters.
                            @endrole
                        </p>
                        @role('teacher|admin')
                        <div class="mt-6">
                            <a href="{{ route('online-classes.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Schedule New Class
                            </a>
                        </div>
                        @endrole
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($classes->hasPages())
                <div class="mt-8">
                    {{ $classes->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Auto-refresh for live status -->
    <script>
        // Refresh the page every 30 seconds to update live status
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>