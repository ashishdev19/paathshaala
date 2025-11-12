<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $onlineClass->title }} - Enhanced Video Player - Paathshaala</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Video.js CSS -->
    <link href="https://vjs.zencdn.net/8.7.0/video-js.css" rel="stylesheet">

    <!-- Custom CSS for enhancements -->
    <style>
        .video-js .vjs-quality-selector .vjs-menu { min-width: 8em; }
        .video-js .vjs-speed-selector .vjs-menu { min-width: 6em; }
        .bookmark-btn { transition: all 0.3s ease; }
        .bookmark-btn:hover { transform: scale(1.1); }
        .bookmark-list { max-height: 300px; overflow-y: auto; }
        .quality-badge { position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.8); color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px; }
        @media (max-width: 768px) {
            .mobile-controls { display: flex !important; }
            .desktop-controls { display: none !important; }
        }
        @media (min-width: 769px) {
            .mobile-controls { display: none !important; }
            .desktop-controls { display: flex !important; }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-black">
    <div class="min-h-screen">
        <!-- Header Bar -->
        <div class="bg-black/90 backdrop-blur-sm border-b border-gray-800 px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('online-classes.show', $onlineClass) }}"
                       class="text-gray-300 hover:text-white transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg font-semibold text-white truncate">{{ $onlineClass->title }}</h1>
                        <p class="text-sm text-gray-400 truncate">{{ $onlineClass->course->title }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2 md:space-x-4">
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="text-sm text-gray-400">
                            {{ $onlineClass->formatted_duration }}
                        </div>
                        @if($onlineClass->allow_offline_download)
                            <button id="downloadBtn" class="text-indigo-400 hover:text-indigo-300 transition duration-300 text-sm font-medium">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </button>
                        @endif
                    </div>
                    <a href="{{ route('dashboard') }}"
                       class="text-gray-300 hover:text-white transition duration-300 text-sm">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Video Player Container -->
        <div class="relative bg-black">
            <div class="aspect-video bg-black relative">
                <!-- Quality Badge -->
                <div id="qualityBadge" class="quality-badge hidden">720p</div>

                @if(str_contains($onlineClass->video_url, 'youtube.com') || str_contains($onlineClass->video_url, 'youtu.be'))
                    <!-- YouTube Video (Basic) -->
                    @php
                        $videoId = null;
                        if (str_contains($onlineClass->video_url, 'youtube.com/watch?v=')) {
                            parse_str(parse_url($onlineClass->video_url, PHP_URL_QUERY), $query);
                            $videoId = $query['v'] ?? null;
                        } elseif (str_contains($onlineClass->video_url, 'youtu.be/')) {
                            $videoId = basename(parse_url($onlineClass->video_url, PHP_URL_PATH));
                        }
                    @endphp

                    @if($videoId)
                        <iframe
                            id="youtube-player"
                            width="100%"
                            height="100%"
                            src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=0&rel=0&modestbranding=1&enablejsapi=1"
                            title="{{ $onlineClass->title }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            class="w-full h-full">
                        </iframe>
                    @else
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center text-white">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-lg font-medium">Invalid YouTube URL</p>
                                <p class="text-sm text-gray-400 mt-2">Please contact your instructor</p>
                            </div>
                        </div>
                    @endif
                @elseif(str_contains($onlineClass->video_url, 'vimeo.com'))
                    <!-- Vimeo Video (Basic) -->
                    @php
                        $videoId = basename(parse_url($onlineClass->video_url, PHP_URL_PATH));
                    @endphp

                    <iframe
                        id="vimeo-player"
                        src="https://player.vimeo.com/video/{{ $videoId }}?h=0&byline=0&portrait=0"
                        width="100%"
                        height="100%"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                        class="w-full h-full">
                    </iframe>
                @else
                    <!-- Enhanced HTML5 Video Player -->
                    <video
                        id="video-player"
                        class="video-js vjs-default-skin w-full h-full"
                        controls
                        preload="auto"
                        data-setup='{"responsive": true, "fluid": true, "playbackRates": {{ json_encode($onlineClass->default_playback_speeds) }}}'
                        poster="">
                        @foreach($onlineClass->default_video_qualities as $quality => $url)
                            <source src="{{ $url }}" type="video/mp4" label="{{ $quality }}" res="{{ str_replace('p', '', $quality) }}">
                        @endforeach
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>.
                        </p>
                    </video>
                @endif
            </div>

            <!-- Enhanced Video Controls Overlay -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 opacity-0 hover:opacity-100 transition-opacity duration-300">
                <!-- Desktop Controls -->
                <div class="desktop-controls hidden md:flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button id="bookmarkBtn" class="bookmark-btn text-white hover:text-yellow-400 transition duration-300" title="Add Bookmark">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                        <div class="text-white text-sm font-medium">
                            <span id="currentTime">0:00</span> / <span id="duration">{{ $onlineClass->formatted_duration }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-400 text-xs">Speed:</span>
                            <select id="speedSelector" class="bg-gray-800 text-white text-xs px-2 py-1 rounded border-none">
                                @foreach($onlineClass->default_playback_speeds as $speed)
                                    <option value="{{ $speed }}" {{ $speed == 1.0 ? 'selected' : '' }}>{{ $speed }}x</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        @if(count($onlineClass->default_video_qualities) > 1)
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-400 text-xs">Quality:</span>
                                <select id="qualitySelector" class="bg-gray-800 text-white text-xs px-2 py-1 rounded border-none">
                                    @foreach($onlineClass->default_video_qualities as $quality => $url)
                                        <option value="{{ $quality }}" {{ $quality == '720p' ? 'selected' : '' }}>{{ $quality }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button id="fullscreenBtn" class="text-white hover:text-gray-300 transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Controls -->
                <div class="mobile-controls flex md:hidden justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <button id="mobileBookmarkBtn" class="bookmark-btn text-white hover:text-yellow-400 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                        <div class="text-white text-xs">
                            <span id="mobileCurrentTime">0:00</span>
                        </div>
                    </div>
                    <button id="mobileFullscreenBtn" class="text-white hover:text-gray-300 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Class Information Panel -->
        <div class="bg-gray-900 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Class Details -->
                    <div class="lg:col-span-3">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-white mb-2">{{ $onlineClass->title }}</h2>
                                <p class="text-gray-300 mb-2">{{ $onlineClass->course->title }}</p>
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                                    <span>👤 {{ $onlineClass->course->teacher->name }}</span>
                                    <span>📅 {{ $onlineClass->created_at->format('M d, Y') }}</span>
                                    <span>👁️ {{ number_format($onlineClass->total_views) }} views</span>
                                    @if($onlineClass->completion_rate > 0)
                                        <span>📊 {{ number_format($onlineClass->completion_rate, 1) }}% avg completion</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-col items-start md:items-end space-y-2">
                                @if($onlineClass->allow_offline_download)
                                    <button id="mobileDownloadBtn" class="md:hidden bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if($onlineClass->description)
                            <div class="bg-gray-800 rounded-lg p-4 mb-6">
                                <h3 class="text-lg font-semibold text-white mb-3">About This Class</h3>
                                <div class="text-gray-300 text-sm leading-relaxed">
                                    {!! nl2br(e($onlineClass->description)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Progress Tracking -->
                        <div class="bg-gray-800 rounded-lg p-4 mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-semibold text-white">Your Progress</h3>
                                <span id="progressPercent" class="text-sm text-gray-400">0% Complete</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-3 mb-3">
                                <div id="progressBar" class="bg-indigo-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400">
                                <span>Watched: <span id="watchedTime">0:00</span></span>
                                <span>Remaining: <span id="remainingTime">{{ $onlineClass->formatted_duration }}</span></span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Your progress is saved automatically as you watch.
                            </p>
                        </div>

                        <!-- Bookmarks Section -->
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-semibold text-white">Bookmarks</h3>
                                <button id="showBookmarksBtn" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">
                                    View All
                                </button>
                            </div>
                            <div id="bookmarksList" class="space-y-2 hidden">
                                <!-- Bookmarks will be loaded here -->
                            </div>
                            <p class="text-xs text-gray-500">
                                Click the bookmark icon while watching to save important moments.
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-4">
                        <!-- Quick Actions -->
                        <div class="bg-gray-800 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-white mb-3">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('online-classes.show', $onlineClass) }}"
                                   class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 text-center block text-sm">
                                    Class Details
                                </a>
                                <a href="{{ route('student.courses.show', $onlineClass->course->id) }}"
                                   class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition duration-300 text-center block text-sm">
                                    Course Overview
                                </a>
                                <a href="{{ route('online-classes.index') }}"
                                   class="w-full border border-gray-600 text-gray-300 px-4 py-2 rounded-lg font-semibold hover:bg-gray-800 transition duration-300 text-center block text-sm">
                                    All Classes
                                </a>
                            </div>
                        </div>

                        <!-- Class Stats -->
                        <div class="bg-gray-800 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-white mb-3">Class Statistics</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-400 text-sm">Total Views</span>
                                    <span class="text-white font-medium">{{ number_format($onlineClass->total_views) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400 text-sm">Avg Watch Time</span>
                                    <span class="text-white font-medium">{{ gmdate('i:s', $onlineClass->average_watch_time) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400 text-sm">Completion Rate</span>
                                    <span class="text-white font-medium">{{ number_format($onlineClass->completion_rate, 1) }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Related Classes (Future Enhancement) -->
                        <div class="bg-gray-800 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-white mb-3">More from this Course</h3>
                            <div class="space-y-2">
                                <p class="text-gray-400 text-sm">Related classes will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Video.js and Custom Scripts -->
    <script src="https://vjs.zencdn.net/8.7.0/video.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let player = null;
            let bookmarks = JSON.parse(localStorage.getItem('bookmarks_{{ $onlineClass->id }}') || '[]');
            let watchProgress = parseFloat(localStorage.getItem('progress_{{ $onlineClass->id }}') || '0');
            let lastUpdateTime = Date.now();

            // Initialize appropriate player
            if (document.getElementById('video-player')) {
                initializeVideoJSPlayer();
            } else if (document.getElementById('youtube-player')) {
                initializeYouTubePlayer();
            } else if (document.getElementById('vimeo-player')) {
                initializeVimeoPlayer();
            }

            function initializeVideoJSPlayer() {
                player = videojs('video-player', {
                    responsive: true,
                    fluid: true,
                    playbackRates: {{ json_encode($onlineClass->default_playback_speeds) }},
                    controls: true,
                    html5: {
                        vhs: {
                            overrideNative: !videojs.browser.IS_SAFARI
                        }
                    }
                });

                // Load saved progress
                if (watchProgress > 0) {
                    player.on('loadedmetadata', function() {
                        player.currentTime(watchProgress);
                        updateProgressDisplay();
                    });
                }

                // Quality selector
                if ({{ count($onlineClass->default_video_qualities) > 1 ? 'true' : 'false' }}) {
                    player.ready(function() {
                        const qualityLevels = player.qualityLevels();
                        qualityLevels.on('change', function() {
                            const currentQuality = qualityLevels[qualityLevels.selectedIndex];
                            if (currentQuality) {
                                document.getElementById('qualityBadge').textContent = currentQuality.height + 'p';
                                document.getElementById('qualityBadge').classList.remove('hidden');
                            }
                        });
                    });
                }

                // Progress tracking
                player.on('timeupdate', function() {
                    const currentTime = player.currentTime();
                    const duration = player.duration();

                    if (duration > 0) {
                        const progress = (currentTime / duration) * 100;
                        updateProgressDisplay(currentTime, duration);

                        // Save progress every 5 seconds
                        if (Date.now() - lastUpdateTime > 5000) {
                            localStorage.setItem('progress_{{ $onlineClass->id }}', currentTime.toString());
                            lastUpdateTime = Date.now();

                            // Send progress to server (optional)
                            updateServerProgress(progress, currentTime);
                        }
                    }
                });

                // Mark as completed
                player.on('ended', function() {
                    markClassCompleted();
                });

                // Speed control
                document.getElementById('speedSelector').addEventListener('change', function() {
                    player.playbackRate(parseFloat(this.value));
                });

                // Quality control
                document.getElementById('qualitySelector').addEventListener('change', function() {
                    // This would require more complex implementation for actual quality switching
                    console.log('Quality changed to:', this.value);
                });
            }

            function initializeYouTubePlayer() {
                // Basic YouTube player - enhanced features would require YouTube API
                console.log('YouTube player initialized');
            }

            function initializeVimeoPlayer() {
                // Basic Vimeo player - enhanced features would require Vimeo API
                console.log('Vimeo player initialized');
            }

            // Bookmark functionality
            document.getElementById('bookmarkBtn').addEventListener('click', addBookmark);
            document.getElementById('mobileBookmarkBtn').addEventListener('click', addBookmark);

            function addBookmark() {
                if (!player) return;

                const currentTime = player.currentTime();
                const timestamp = formatTime(currentTime);

                const bookmark = {
                    id: Date.now(),
                    time: currentTime,
                    timestamp: timestamp,
                    note: `Bookmark at ${timestamp}`
                };

                bookmarks.push(bookmark);
                localStorage.setItem('bookmarks_{{ $onlineClass->id }}', JSON.stringify(bookmarks));

                showNotification('Bookmark added!', 'success');
                updateBookmarksList();
            }

            function updateBookmarksList() {
                const container = document.getElementById('bookmarksList');
                container.innerHTML = '';

                if (bookmarks.length === 0) {
                    container.innerHTML = '<p class="text-gray-400 text-sm">No bookmarks yet</p>';
                    return;
                }

                bookmarks.forEach(bookmark => {
                    const bookmarkEl = document.createElement('div');
                    bookmarkEl.className = 'flex justify-between items-center p-2 bg-gray-700 rounded';
                    bookmarkEl.innerHTML = `
                        <div>
                            <div class="text-white text-sm font-medium">${bookmark.timestamp}</div>
                            <div class="text-gray-400 text-xs">${bookmark.note}</div>
                        </div>
                        <button onclick="jumpToBookmark(${bookmark.time})" class="text-indigo-400 hover:text-indigo-300 text-sm">
                            Jump
                        </button>
                    `;
                    container.appendChild(bookmarkEl);
                });

                container.classList.remove('hidden');
            }

            // Show/hide bookmarks
            document.getElementById('showBookmarksBtn').addEventListener('click', function() {
                const container = document.getElementById('bookmarksList');
                container.classList.toggle('hidden');
            });

            // Download functionality
            const downloadBtns = ['downloadBtn', 'mobileDownloadBtn'];
            downloadBtns.forEach(btnId => {
                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.addEventListener('click', function() {
                        // In a real implementation, this would trigger a download
                        showNotification('Download feature coming soon!', 'info');
                    });
                }
            });

            // Utility functions
            function updateProgressDisplay(currentTime, duration) {
                if (typeof currentTime === 'undefined') {
                    if (player) {
                        currentTime = player.currentTime() || 0;
                        duration = player.duration() || {{ $onlineClass->duration_minutes * 60 }};
                    } else {
                        return;
                    }
                }

                const progress = duration > 0 ? (currentTime / duration) * 100 : 0;

                document.getElementById('progressBar').style.width = progress + '%';
                document.getElementById('progressPercent').textContent = Math.round(progress) + '% Complete';
                document.getElementById('watchedTime').textContent = formatTime(currentTime);
                document.getElementById('remainingTime').textContent = formatTime(duration - currentTime);

                // Update mobile display
                document.getElementById('mobileCurrentTime').textContent = formatTime(currentTime);
                document.getElementById('currentTime').textContent = formatTime(currentTime);
            }

            function formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            }

            function jumpToBookmark(time) {
                if (player) {
                    player.currentTime(time);
                    showNotification('Jumped to bookmark!', 'success');
                }
            }

            function showNotification(message, type = 'info') {
                // Simple notification - could be enhanced with a proper notification system
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white text-sm font-medium z-50 ${
                    type === 'success' ? 'bg-green-600' :
                    type === 'error' ? 'bg-red-600' : 'bg-blue-600'
                }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            function updateServerProgress(progress, currentTime) {
                // Send progress to server
                fetch('/api/classes/{{ $onlineClass->id }}/progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        progress: progress,
                        current_time: currentTime
                    })
                }).catch(err => console.log('Progress update failed:', err));
            }

            function markClassCompleted() {
                fetch('/api/classes/{{ $onlineClass->id }}/complete', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                }).then(() => {
                    showNotification('Class completed! 🎉', 'success');
                }).catch(err => console.log('Completion marking failed:', err));
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.target.tagName.toLowerCase() === 'input') return;

                switch(e.key) {
                    case ' ':
                        e.preventDefault();
                        if (player) {
                            player.paused() ? player.play() : player.pause();
                        }
                        break;
                    case 'f':
                    case 'F':
                        e.preventDefault();
                        if (player) {
                            if (player.isFullscreen()) {
                                player.exitFullscreen();
                            } else {
                                player.requestFullscreen();
                            }
                        }
                        break;
                    case 'ArrowLeft':
                        e.preventDefault();
                        if (player) {
                            player.currentTime(Math.max(0, player.currentTime() - 10));
                        }
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        if (player) {
                            player.currentTime(Math.min(player.duration(), player.currentTime() + 10));
                        }
                        break;
                    case 'b':
                    case 'B':
                        e.preventDefault();
                        addBookmark();
                        break;
                }
            });

            // Load initial bookmarks
            updateBookmarksList();

            // Load initial progress
            updateProgressDisplay();
        });

        // Global function for bookmark jumping
        function jumpToBookmark(time) {
            const player = videojs.getPlayer('video-player');
            if (player) {
                player.currentTime(time);
            }
        }
    </script>
</body>
</html>