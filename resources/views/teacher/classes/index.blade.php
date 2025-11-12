<x-teacher-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Online Classes') }}
            </h2>
            <a href="{{ route('online-classes.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Schedule New Class
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Classes List -->
                    <div class="space-y-6">
                        @forelse($classes as $class)
                            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $class->title }}</h3>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($class->type === 'live') bg-red-100 text-red-800
                                                @elseif($class->type === 'recorded') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($class->type) }}
                                            </span>
                                            @if($class->scheduled_at > now())
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                    Upcoming
                                                </span>
                                            @elseif($class->scheduled_at->isToday())
                                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                                                    Today
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                                    Completed
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="text-sm text-gray-600 mb-2">
                                            <strong>Course:</strong> {{ $class->course->title }}
                                        </div>
                                        
                                        @if($class->description)
                                            <p class="text-gray-600 mb-3">{{ $class->description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $class->scheduled_at->format('M d, Y') }}
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $class->scheduled_at->format('H:i') }}
                                            </div>
                                            @if($class->duration)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                    {{ $class->duration }} minutes
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col space-y-2 ml-4">
                                        @if($class->scheduled_at > now())
                                            @if($class->type === 'live')
                                                <a href="{{ $class->meeting_url ?? '#' }}" class="bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded text-sm font-medium" target="_blank">
                                                    Join Live Class
                                                </a>
                                            @endif
                                        @elseif($class->scheduled_at->isToday() && $class->type === 'live')
                                            <a href="{{ $class->meeting_url ?? '#' }}" class="bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded text-sm font-medium" target="_blank">
                                                Start Class Now
                                            </a>
                                        @endif
                                        
                                        @if($class->type === 'recorded' && $class->recording_url)
                                            <a href="{{ $class->recording_url }}" class="bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded text-sm font-medium" target="_blank">
                                                View Recording
                                            </a>
                                        @endif
                                        
                                        <a href="#" class="bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                            Edit
                                        </a>
                                        
                                        <button class="bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="max-w-md mx-auto">
                                    <div class="mb-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No classes scheduled</h3>
                                    <p class="text-gray-500 mb-6">Create your first online class to get started.</p>
                                    <a href="{{ route('online-classes.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Schedule New Class
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($classes->hasPages())
                        <div class="mt-8">
                            {{ $classes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>