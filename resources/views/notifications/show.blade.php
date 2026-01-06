@php
    $layoutComponent = 'layouts.app';
    if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()) {
        $layoutComponent = 'layouts.admin';
    } elseif(auth()->user()->isInstructor()) {
        $layoutComponent = 'layouts.instructor';
    } elseif(auth()->user()->isStudent()) {
        $layoutComponent = 'layouts.student';
    }
@endphp

<x-dynamic-component :component="$layoutComponent">
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('notifications.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Notification Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">
                            @if($notification->icon)
                                <i class="{{ $notification->icon }}"></i>
                            @else
                                <i class="fas fa-bell"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold">{{ $notification->type ?? 'General Notification' }}</p>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $notification->title }}</h1>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-gray-500">{{ $notification->created_at->format('M d, Y h:i A') }}</span>
                        <div class="mt-1">
                            @if($notification->priority == 'high')
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">High Priority</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed mb-10">
                    {{ $notification->message }}
                </div>

                @if($notification->data)
                    <div class="bg-gray-50 rounded-xl p-6 mb-10 border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Additional Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            @foreach($notification->data as $key => $value)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ is_array($value) ? json_encode($value) : $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif

                <div class="flex space-x-4">
                    @if($notification->action_url)
                        <a href="{{ $notification->action_url }}" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-center hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Take Action
                        </a>
                    @endif
                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="{{ $notification->action_url ? 'flex-shrink-0' : 'flex-1' }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-white border border-red-200 text-red-600 px-6 py-3 rounded-xl font-bold hover:bg-red-50 transition" onclick="return confirm('Are you sure?')">
                            Delete Notification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
