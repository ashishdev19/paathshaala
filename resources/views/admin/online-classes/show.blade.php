@extends('layouts.admin')

@section('title', 'Online Class Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $onlineClass->title }}</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.online-classes.edit', $onlineClass) }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.online-classes.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Classes
                    </a>
                </div>
            </div>

            <!-- Class Status -->
            <div class="mb-6">
                @php
                    $now = now();
                    $isUpcoming = $onlineClass->scheduled_at->isFuture();
                    $isLive = $onlineClass->scheduled_at <= $now && $onlineClass->scheduled_at >= $now->copy()->subMinutes(60);
                    $isCompleted = $onlineClass->scheduled_at < $now->copy()->subHours(2);
                @endphp
                @if($isLive)
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                        <i class="fas fa-circle text-red-500 mr-2 animate-pulse"></i>Live Now
                    </span>
                @elseif($isUpcoming)
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2"></i>Upcoming
                    </span>
                @elseif($isCompleted)
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        <i class="fas fa-check-circle mr-2"></i>Completed
                    </span>
                @else
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        <i class="fas fa-calendar mr-2"></i>Scheduled
                    </span>
                @endif

                @if(!$onlineClass->is_active)
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800 ml-2">
                        <i class="fas fa-pause mr-2"></i>Inactive
                    </span>
                @endif
            </div>

            <!-- Class Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Class Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Course</dt>
                            <dd class="text-sm text-gray-900">{{ $onlineClass->course->title }}</dd>
                            <dd class="text-sm text-gray-600">by {{ $onlineClass->course->teacher->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="text-sm text-gray-900">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $onlineClass->type === 'live' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($onlineClass->type) }} Class
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Scheduled Time</dt>
                            <dd class="text-sm text-gray-900">{{ $onlineClass->scheduled_at->format('l, F j, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="text-sm text-gray-900">{{ $onlineClass->duration_minutes }} minutes</dd>
                        </div>
                        @if($onlineClass->description)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $onlineClass->description }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div>
                    @if($onlineClass->type === 'live')
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Live Class Details</h3>
                        <dl class="space-y-3">
                            @if($onlineClass->meeting_link)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Meeting Link</dt>
                                    <dd class="text-sm text-gray-900">
                                        <a href="{{ $onlineClass->meeting_link }}" target="_blank"
                                           class="text-blue-600 hover:text-blue-800 flex items-center">
                                            {{ $onlineClass->meeting_link }}
                                            <i class="fas fa-external-link-alt ml-1"></i>
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($onlineClass->meeting_id)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Meeting ID</dt>
                                    <dd class="text-sm text-gray-900 font-mono">{{ $onlineClass->meeting_id }}</dd>
                                </div>
                            @endif
                            @if($onlineClass->meeting_password)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Meeting Password</dt>
                                    <dd class="text-sm text-gray-900 font-mono">{{ $onlineClass->meeting_password }}</dd>
                                </div>
                            @endif
                        </dl>
                    @else
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recorded Class Details</h3>
                        <dl class="space-y-3">
                            @if($onlineClass->video_url)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Video</dt>
                                    <dd class="text-sm text-gray-900">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-video text-gray-400"></i>
                                            <span>{{ basename($onlineClass->video_url) }}</span>
                                            <a href="{{ $onlineClass->video_url }}" target="_blank"
                                               class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-play-circle mr-1"></i>View Video
                                            </a>
                                        </div>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    @endif
                </div>
            </div>

            <!-- Enrolled Students -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Enrolled Students</h3>

                @if($onlineClass->course->enrollments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($onlineClass->course->enrollments as $enrollment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ substr($enrollment->student->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $enrollment->student->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $enrollment->student->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $enrollment->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                </div>
                                                <span class="text-sm text-gray-500">{{ $enrollment->progress_percentage }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">No students enrolled in this course yet.</p>
                    </div>
                @endif
            </div>

            <!-- Delete Action -->
            <div class="border-t pt-6 mt-8">
                <div class="flex justify-end">
                    <form method="POST" action="{{ route('admin.online-classes.destroy', $onlineClass) }}"
                          onsubmit="return confirm('Are you sure you want to delete this online class? This action cannot be undone.')"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                            <i class="fas fa-trash mr-2"></i>Delete Class
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection