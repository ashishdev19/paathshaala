<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Live Class Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <a href="{{ route('instructor.live-classes.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    ← Back to Live Classes
                </a>
            </div>

            <!-- Class Header -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $liveClass->topic }}</h3>
                <p class="text-gray-600">{{ $liveClass->course->title ?? 'General' }}</p>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Date & Time -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date & Time</label>
                    <div class="flex items-center text-lg font-semibold text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $liveClass->start_datetime->format('M d, Y - h:i A') }}
                    </div>
                </div>

                <!-- Duration -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Duration</label>
                    <div class="flex items-center text-lg font-semibold text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $liveClass->duration }} minutes
                    </div>
                </div>

                <!-- Mode -->
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mode</label>
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                        {{ ucfirst($liveClass->mode) }}
                    </span>
                </div>

                <!-- Status -->
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200">
                        {{ ucfirst($liveClass->status) }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            @if($liveClass->description)
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <p class="text-gray-700">{{ $liveClass->description }}</p>
            </div>
            @endif

            <!-- Meeting Link -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Meeting Link</label>
                <div class="flex items-center justify-between">
                    <code class="text-green-600 font-mono text-sm break-all">{{ $liveClass->meeting_link }}</code>
                    <button onclick="navigator.clipboard.writeText('{{ $liveClass->meeting_link }}')" class="ml-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-semibold">
                        Copy Link
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 justify-end">
                <a href="{{ route('instructor.live-classes.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                    Back
                </a>
                <a href="{{ route('instructor.live-classes.edit', $liveClass->id) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                    Edit Class
                </a>
                <a href="{{ route('instructor.live-classes.join', $liveClass->id) }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                    Start Class
                </a>
            </div>
        </div>
    </div>
</x-layouts.instructor>
