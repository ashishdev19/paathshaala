<x-layouts.student>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ $liveClass->topic }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $liveClass->course->title ?? 'General Session' }} • {{ $liveClass->start_datetime->format('M d, Y h:i A') }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 
                    @if($liveClass->status === 'live') bg-red-100 text-red-800
                    @else bg-green-100 text-green-800 @endif
                    rounded-full text-sm font-semibold">
                    @if($liveClass->status === 'live')
                        <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                        LIVE
                    @else
                        {{ ucfirst($liveClass->status) }}
                    @endif
                </span>
                <a href="{{ route('student.live-classes.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                    Leave Class
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-4">
        <!-- Class Info Bar -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Instructor</p>
                        <p class="font-semibold text-gray-900 text-sm">{{ $liveClass->instructor->name }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Duration</p>
                        <p class="font-semibold text-gray-900">{{ $liveClass->duration }} mins</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Chat</p>
                        <p class="font-semibold text-gray-900">{{ $liveClass->allow_chat ? 'Enabled' : 'Disabled' }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Microphone</p>
                        <p class="font-semibold text-gray-900">{{ $liveClass->allow_mic ? 'Enabled' : 'Disabled' }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Video</p>
                        <p class="font-semibold text-gray-900">{{ $liveClass->allow_video ? 'Enabled' : 'Disabled' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jitsi Meeting Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div id="jaas-container" style="height: 700px;"></div>
        </div>

        <!-- Class Description -->
        @if($liveClass->description)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">About This Class</h3>
            <p class="text-gray-700">{{ $liveClass->description }}</p>
        </div>
        @endif
    </div>

    <!-- Jitsi JaaS External API Script -->
    <script src='https://8x8.vc/vpaas-magic-cookie-c52e06a75eae4895ac45c2652feb19b5/external_api.js' async></script>
    <script>
        // Wait for script to load
        window.onload = () => {
            // Initialize Jitsi Meet with JaaS
            const api = new JitsiMeetExternalAPI("8x8.vc", {
                roomName: "vpaas-magic-cookie-c52e06a75eae4895ac45c2652feb19b5/{{ $liveClass->room_name }}",
                parentNode: document.querySelector('#jaas-container'),
                width: "100%",
                height: 700,
                userInfo: {
                    displayName: "{{ auth()->user()->name }}",
                    email: "{{ auth()->user()->email }}"
                },
                configOverwrite: {
                    startWithAudioMuted: {{ $liveClass->allow_mic ? 'false' : 'true' }},
                    startWithVideoMuted: {{ $liveClass->allow_video ? 'false' : 'true' }},
                    enableWelcomePage: false,
                    prejoinPageEnabled: false,
                    disableDeepLinking: true,
                    enableNoisyMicDetection: true,
                    @if(!$liveClass->allow_chat)
                    disableChat: true,
                    @endif
                },
                interfaceConfigOverwrite: {
                    TOOLBAR_BUTTONS: [
                        @if($liveClass->allow_mic) 'microphone', @endif
                        @if($liveClass->allow_video) 'camera', @endif
                        'closedcaptions', 'desktop', 'fullscreen', 'fodeviceselection',
                        'hangup', 'profile',
                        @if($liveClass->allow_chat) 'chat', @endif
                        'raisehand', 'videoquality', 'filmstrip', 'stats',
                        'shortcuts', 'tileview', 'videobackgroundblur', 'help'
                    ],
                    SETTINGS_SECTIONS: ['devices', 'language', 'profile'],
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,
                    SHOW_BRAND_WATERMARK: false,
                    BRAND_WATERMARK_LINK: '',
                    APP_NAME: 'Medniks Live Class',
                    NATIVE_APP_NAME: 'Medniks',
                    DEFAULT_REMOTE_DISPLAY_NAME: 'Student',
                    DISABLE_PRESENCE_STATUS: true,
                    MOBILE_APP_PROMO: false,
                }
            });

            // Event listeners
            api.addEventListener('videoConferenceJoined', (event) => {
                console.log('Student joined:', event);
                showNotification('You joined the live class!');
            });

            api.addEventListener('videoConferenceLeft', () => {
                console.log('Student left the meeting');
                window.location.href = "{{ route('student.live-classes.index') }}";
            });

            api.addEventListener('readyToClose', () => {
                window.location.href = "{{ route('student.live-classes.index') }}";
            });

            // Handle permissions after joining
            api.addEventListener('videoConferenceJoined', () => {
                @if(!$liveClass->allow_mic)
                    api.executeCommand('toggleAudio');
                @endif

                @if(!$liveClass->allow_video)
                    api.executeCommand('toggleVideo');
                @endif
            });
        };

        // Show notification helper
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-layouts.student>
