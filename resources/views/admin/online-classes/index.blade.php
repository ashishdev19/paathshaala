@extends('layouts.admin')

@section('title', 'Online Classes Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Online Classes Management</h1>
        <a href="{{ route('admin.online-classes.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            <i class="fas fa-plus mr-2"></i>Add New Class
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="live" {{ request('type') === 'live' ? 'selected' : '' }}>Live Classes</option>
                    <option value="recorded" {{ request('type') === 'recorded' ? 'selected' : '' }}>Recorded Classes</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="live" {{ request('status') === 'live' ? 'selected' : '' }}>Live Now</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                <select name="course_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium mr-2">
                    <i class="fas fa-filter mr-1"></i>Filter
                </button>
                <a href="{{ route('admin.online-classes.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md font-medium">
                    <i class="fas fa-times mr-1"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Classes List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($classes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($classes as $class)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $class->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($class->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $class->course->title }}</div>
                                    <div class="text-sm text-gray-500">by {{ $class->course->teacher->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $class->type === 'live' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($class->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $class->scheduled_at->format('M d, Y') }}</div>
                                    <div>{{ $class->scheduled_at->format('h:i A') }}</div>
                                    <div class="text-xs">({{ $class->duration_minutes }} min)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $now = now();
                                        $isUpcoming = $class->scheduled_at->isFuture();
                                        $isLive = $class->scheduled_at <= $now && $class->scheduled_at >= $now->copy()->subMinutes(60);
                                        $isCompleted = $class->scheduled_at < $now->copy()->subHours(2);
                                    @endphp
                                    @if($isLive)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Live Now
                                        </span>
                                    @elseif($isUpcoming)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Upcoming
                                        </span>
                                    @elseif($isCompleted)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Scheduled
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.online-classes.show', $class) }}"
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.online-classes.edit', $class) }}"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.online-classes.destroy', $class) }}"
                                              onsubmit="return confirm('Are you sure you want to delete this class?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $classes->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-video text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No online classes found</h3>
                <p class="text-gray-500 mb-4">Get started by creating your first online class.</p>
                <a href="{{ route('admin.online-classes.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-plus mr-2"></i>Create First Class
                </a>
            </div>
        @endif
    </div>
</div>
@endsection