<x-layouts.student>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }} - {{ $lecture->title }}
            </h2>
            <a href="{{ route('student.courses.show', $course->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                &larr; Back to Course
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Video Player Area -->
        <div class="lg:col-span-3">
            <div class="bg-black rounded-lg overflow-hidden shadow-lg aspect-video mb-6">
                @if($lecture->type == 'video')
                    @if($lecture->video_url)
                        @php
                            $isYouTube = str_contains($lecture->video_url, 'youtube.com') || str_contains($lecture->video_url, 'youtu.be');
                            $isVimeo = str_contains($lecture->video_url, 'vimeo.com');
                        @endphp

                        @if($isYouTube)
                            @php
                                $videoId = '';
                                if (str_contains($lecture->video_url, 'v=')) {
                                    parse_str(parse_url($lecture->video_url, PHP_URL_QUERY), $params);
                                    $videoId = $params['v'] ?? '';
                                } else {
                                    $videoId = basename(parse_url($lecture->video_url, PHP_URL_PATH));
                                }
                            @endphp
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        @elseif($isVimeo)
                            @php
                                $videoId = basename(parse_url($lecture->video_url, PHP_URL_PATH));
                            @endphp
                            <iframe src="https://player.vimeo.com/video/{{ $videoId }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white">
                                <a href="{{ $lecture->video_url }}" target="_blank" class="bg-blue-600 px-6 py-3 rounded-lg font-bold">Watch External Video</a>
                            </div>
                        @endif
                    @elseif($lecture->file_path)
                        <video src="{{ asset($lecture->file_path) }}" controls class="w-full h-full" controlsList="nodownload"></video>
                    @endif
                @elseif($lecture->type == 'pdf')
                    <iframe src="{{ asset($lecture->file_path) }}" class="w-full h-full min-h-[600px]" frameborder="0"></iframe>
                @else
                    <div class="w-full h-full flex items-center justify-center text-white bg-gray-800">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-semibold">This is a {{ $lecture->type }} lecture</h3>
                            <p class="text-gray-400">Please use the resources below if available.</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $lecture->title }}</h1>
                @if($lecture->description)
                    <div class="text-gray-700 prose max-w-none">
                        {!! nl2br(e($lecture->description)) !!}
                    </div>
                @endif

                @if($lecture->type == 'pdf' || ($lecture->type == 'assignment' && $lecture->file_path))
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <a href="{{ asset($lecture->file_path) }}" target="_blank" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Resource
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Course Content -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden sticky top-6">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Course Content</h3>
                </div>
                <div class="max-h-[calc(100vh-200px)] overflow-y-auto">
                    @foreach($course->sections as $section)
                        <div class="border-b border-gray-100">
                            <div class="bg-gray-50 px-4 py-2 text-sm font-semibold text-gray-600">
                                {{ $section->title }}
                            </div>
                            <div class="divide-y divide-gray-50">
                                @foreach($section->lectures as $l)
                                    <a href="{{ route('student.lectures.watch', $l->id) }}" 
                                       class="block px-4 py-3 hover:bg-blue-50 transition {{ $l->id == $lecture->id ? 'bg-blue-50 border-l-4 border-blue-600' : '' }}">
                                        <div class="flex items-center">
                                            <div class="mr-3">
                                                @if($l->type == 'video')
                                                    <svg class="w-4 h-4 {{ $l->id == $lecture->id ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @elseif($l->type == 'pdf')
                                                    <svg class="w-4 h-4 {{ $l->id == $lecture->id ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 {{ $l->id == $lecture->id ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="text-sm {{ $l->id == $lecture->id ? 'font-bold text-blue-700' : 'text-gray-700' }}">
                                                {{ $l->title }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.student>
