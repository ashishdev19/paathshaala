<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Share Invite Link
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <a href="{{ route('instructor.live-classes.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    ← Back to Live Classes
                </a>
            </div>

            <!-- Class Info -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $liveClass->topic }}</h3>
                <div class="flex gap-4 text-sm text-gray-600">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $liveClass->start_datetime->format('M d, Y') }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $liveClass->start_datetime->format('h:i A') }}
                    </span>
                </div>
            </div>

            <!-- Meeting Link Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Meeting Link</h4>
                <div class="bg-white border border-blue-300 rounded-lg p-4 mb-4">
                    <code class="text-blue-600 font-mono text-sm break-all block mb-2">{{ $liveClass->meeting_link }}</code>
                </div>
                <button onclick="copyToClipboard('{{ $liveClass->meeting_link }}')" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold mb-3">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Copy Link
                </button>
            </div>

            <!-- Shareable Text Section -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Share Message</h4>
                <div class="bg-white border border-purple-300 rounded-lg p-4 mb-4">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Hi! You're invited to join my live class: <strong>{{ $liveClass->topic }}</strong><br>
                        📅 {{ $liveClass->start_datetime->format('M d, Y') }}<br>
                        🕐 {{ $liveClass->start_datetime->format('h:i A') }}<br>
                        🔗 <a href="{{ $liveClass->meeting_link }}" class="text-blue-600 hover:underline">Join Here</a>
                    </p>
                </div>
                <button onclick="copyToClipboard(document.getElementById('share-message').innerText)" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Copy Message
                </button>
            </div>

            <!-- QR Code Section (if available) -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Share Options</h4>
                <div class="grid grid-cols-3 gap-3">
                    <a href="https://wa.me/?text={{ urlencode('Join my live class: ' . $liveClass->topic . ' - ' . $liveClass->meeting_link) }}" target="_blank" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-center text-sm">
                        WhatsApp
                    </a>
                    <a href="https://mail.google.com/mail/?body={{ urlencode('Join my live class: ' . $liveClass->topic . ' - ' . $liveClass->meeting_link) }}" target="_blank" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-center text-sm">
                        Gmail
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('Join my live class: ' . $liveClass->topic) }}&url={{ urlencode($liveClass->meeting_link) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-center text-sm">
                        Twitter
                    </a>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 justify-end pt-6 border-t border-gray-200">
                <a href="{{ route('instructor.live-classes.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                    Done
                </a>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard!');
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</x-layouts.instructor>
