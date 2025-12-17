<x-layouts.instructor>
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
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                    {{ ucfirst($liveClass->status) }}
                </span>
                <form action="{{ route('instructor.live-classes.end', $liveClass->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to end this class?')"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        End Class
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="space-y-4">
        <!-- Class Info Bar -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

        <!-- Meeting Link Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Share Meeting Link</h3>
            <div class="flex items-center space-x-3">
                <input type="text" 
                       value="{{ $liveClass->meeting_link }}" 
                       id="meeting-link"
                       readonly
                       class="flex-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-700">
                <button onclick="copyMeetingLink()" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-2">Share this link with your students to join the class</p>
        </div>
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
                    displayName: "{{ auth()->user()->name }} (Instructor)",
                    email: "{{ auth()->user()->email }}"
                },
                configOverwrite: {
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
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
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                        'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                        'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone'
                    ],
                    SETTINGS_SECTIONS: ['devices', 'language', 'moderator', 'profile', 'calendar'],
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,
                    SHOW_BRAND_WATERMARK: false,
                    BRAND_WATERMARK_LINK: '',
                    APP_NAME: 'Medniks Live Class',
                    NATIVE_APP_NAME: 'Medniks',
                    PROVIDER_NAME: 'Medniks',
                    DEFAULT_REMOTE_DISPLAY_NAME: 'Student',
                    HIDE_INVITE_MORE_HEADER: false,
                }
            });

            // Event listeners
            api.addEventListener('videoConferenceJoined', (event) => {
                console.log('Instructor joined the meeting:', event);
                
                // Grant moderator rights
                api.executeCommand('toggleLobby', true);
                
                // Apply class settings
                @if(!$liveClass->allow_chat)
                    api.executeCommand('toggleChat');
                @endif
                
                @if(!$liveClass->allow_mic)
                    // Mute all participants by default (instructor can unmute individually)
                    console.log('Microphone disabled for students');
                @endif
            });

            api.addEventListener('participantJoined', (event) => {
                console.log('Student joined:', event.displayName);
                
                // Show notification
                showNotification('Student joined: ' + event.displayName);
            });

            api.addEventListener('participantLeft', (event) => {
                console.log('Student left:', event.displayName);
            });

            api.addEventListener('videoConferenceLeft', () => {
                console.log('You left the meeting');
                window.location.href = "{{ route('instructor.live-classes.index') }}";
            });

            api.addEventListener('readyToClose', () => {
                console.log('Meeting ended');
                window.location.href = "{{ route('instructor.live-classes.index') }}";
            });
        };

        // Copy meeting link function
        function copyMeetingLink() {
            const linkInput = document.getElementById('meeting-link');
            linkInput.select();
            linkInput.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(linkInput.value).then(() => {
                showNotification('Meeting link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy:', err);
                alert('Failed to copy link');
            });
        }

        // Show notification helper
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Auto-end class after duration
        const duration = {{ $liveClass->duration }} * 60 * 1000;
        setTimeout(() => {
            if (confirm('The scheduled class duration has ended. Do you want to end the class?')) {
                document.querySelector('form[action*="end"]').submit();
            }
        }, duration);
    </script>
</x-layouts.instructor>
