<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
                    @include('components.notifications-dropdown')
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                        <p class="text-gray-600 mt-2">Stay updated with your learning activities</p>
                    </div>
                    
                    @if($unreadCount > 0)
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ $unreadCount }} unread</span>
                        <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                                Mark All Read
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-bell text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $stats['total'] }}</h3>
                            <p class="text-gray-600">Total</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $stats['unread'] }}</h3>
                            <p class="text-gray-600">Unread</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $stats['read'] }}</h3>
                            <p class="text-gray-600">Read</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-calendar-day text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $stats['today'] }}</h3>
                            <p class="text-gray-600">Today</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <form method="GET" action="{{ route('notifications.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select name="type" id="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                            <option value="enrollment" {{ request('type') == 'enrollment' ? 'selected' : '' }}>Enrollment</option>
                            <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Payment</option>
                            <option value="class_reminder" {{ request('type') == 'class_reminder' ? 'selected' : '' }}>Class Reminders</option>
                            <option value="certificate" {{ request('type') == 'certificate' ? 'selected' : '' }}>Certificates</option>
                            <option value="course_update" {{ request('type') == 'course_update' ? 'selected' : '' }}>Course Updates</option>
                            <option value="system" {{ request('type') == 'system' ? 'selected' : '' }}>System</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <select name="priority" id="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all" {{ request('priority') == 'all' ? 'selected' : '' }}>All Priorities</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition duration-300">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notifications List -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @forelse($notifications as $notification)
                    <div class="px-6 py-4 border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150 {{ !$notification->is_read ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start space-x-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $notification->icon_class }}">
                                    @php
                                        $iconMap = [
                                            'enrollment' => 'fas fa-graduation-cap',
                                            'payment' => 'fas fa-credit-card',
                                            'class_reminder' => 'fas fa-clock',
                                            'certificate' => 'fas fa-certificate',
                                            'course_update' => 'fas fa-book',
                                            'system' => 'fas fa-cog'
                                        ];
                                        $icon = $iconMap[$notification->type] ?? 'fas fa-bell';
                                    @endphp
                                    <i class="{{ $icon }}"></i>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $notification->title }}</h3>
                                        @if(!$notification->is_read)
                                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        @endif
                                        
                                        <!-- Priority Badge -->
                                        @if($notification->priority !== 'normal')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                {{ $notification->priority === 'urgent' ? 'bg-red-100 text-red-800' : 
                                                   ($notification->priority === 'high' ? 'bg-orange-100 text-orange-800' : 
                                                    'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($notification->priority) }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">{{ $notification->time_ago }}</span>
                                        
                                        <!-- Actions -->
                                        <div class="flex items-center space-x-1">
                                            @if(!$notification->is_read)
                                                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium px-2 py-1 rounded">
                                                        Mark Read
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('notifications.mark-unread', $notification) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-gray-600 hover:text-gray-800 text-sm font-medium px-2 py-1 rounded">
                                                        Mark Unread
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this notification?')"
                                                        class="text-red-600 hover:text-red-800 text-sm font-medium px-2 py-1 rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 mt-2">{{ $notification->message }}</p>
                                
                                @if($notification->action_url)
                                    <div class="mt-3">
                                        <a href="{{ $notification->action_url }}" 
                                           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                            View Details
                                            <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request()->hasAny(['type', 'status', 'priority']))
                                Try adjusting your filters to see more notifications.
                            @else
                                You're all caught up! New notifications will appear here.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>