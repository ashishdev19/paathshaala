@php
    $layoutComponent = 'layouts.app';
    if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()) {
        $layoutComponent = 'layouts.admin';
    } elseif(auth()->user()->isInstructor()) {
        $layoutComponent = 'layouts.instructor';
    } elseif(auth()->user()->isStudent()) {
        $layoutComponent = 'layouts.student';
    }

    // Check if the component exists in the expected location
    // resources/views/components/layouts/admin.blade.php -> x-layouts.admin
@endphp

<x-dynamic-component :component="$layoutComponent">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            <div class="flex space-x-2">
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200 transition">
                        Mark all as read
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 px-4 sm:px-0">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="text-sm text-gray-500 mb-1">Total</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-indigo-50 rounded-xl shadow-sm p-6 border border-indigo-100">
                <div class="text-sm text-indigo-600 mb-1">Unread</div>
                <div class="text-2xl font-bold text-indigo-700">{{ $stats['unread'] }}</div>
            </div>
            <div class="bg-green-50 rounded-xl shadow-sm p-6 border border-green-100">
                <div class="text-sm text-green-600 mb-1">Read</div>
                <div class="text-2xl font-bold text-green-700">{{ $stats['read'] }}</div>
            </div>
            <div class="bg-purple-50 rounded-xl shadow-sm p-6 border border-purple-100">
                <div class="text-sm text-purple-600 mb-1">Today</div>
                <div class="text-2xl font-bold text-purple-700">{{ $stats['today'] }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mx-4 sm:px-0">
            <!-- Filter Bar -->
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-4 items-center justify-between">
                <div class="flex space-x-4">
                    <a href="{{ route('notifications.index', ['status' => 'all']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ !request()->has('status') || request()->status == 'all' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('notifications.index', ['status' => 'unread']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->status == 'unread' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                        Unread
                    </a>
                    <a href="{{ route('notifications.index', ['status' => 'read']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->status == 'read' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-200' }}">
                        Read
                    </a>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    <div class="p-6 hover:bg-gray-50 transition {{ !$notification->is_read ? 'bg-indigo-50/30' : '' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $notification->priority == 'high' ? 'bg-red-100 text-red-600' : 'bg-indigo-100 text-indigo-600' }}">
                                    @if($notification->icon)
                                        <i class="{{ $notification->icon }}"></i>
                                    @else
                                        <i class="fas {{ $notification->priority == 'high' ? 'fa-exclamation-circle' : 'fa-bell' }}"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-bold text-gray-900 {{ !$notification->is_read ? 'text-indigo-900' : '' }}">
                                        {{ $notification->title }}
                                    </h3>
                                    <span class="text-xs text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $notification->message }}
                                </p>
                                <div class="mt-4 flex space-x-4">
                                    @if($notification->action_url)
                                        <a href="{{ route('notifications.show', $notification) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                            View Details
                                        </a>
                                    @endif
                                    @if(!$notification->is_read)
                                        <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-gray-500 hover:text-gray-700">
                                                Mark as read
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('notifications.mark-unread', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-gray-500 hover:text-gray-700">
                                                Mark as unread
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if(!$notification->is_read)
                                <div class="ml-4 flex-shrink-0">
                                    <span class="w-3 h-3 bg-indigo-600 rounded-full block shadow-[0_0_8px_rgba(79,70,229,0.5)]"></span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No notifications found</h3>
                        <p class="text-gray-500 mt-1">When you get notifications, they'll show up here.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dynamic-component>
