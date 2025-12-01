<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Pending Course Approvals
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-yellow-50 rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <p class="text-gray-600 text-sm">Pending Review</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-green-50 rounded-lg shadow p-6 border-l-4 border-green-500">
                <p class="text-gray-600 text-sm">Published</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['published'] }}</p>
            </div>
            <div class="bg-red-50 rounded-lg shadow p-6 border-l-4 border-red-500">
                <p class="text-gray-600 text-sm">Rejected</p>
                <p class="text-3xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
            </div>
        </div>

        <!-- Courses Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Courses Under Review</h3>
                <span class="text-sm text-gray-600">{{ $courses->total() }} total</span>
            </div>

            @if($courses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Course Title</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Instructor</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($courses as $course)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $course->title }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($course->description, 60) }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $course->teacher->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $course->teacher->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                            {{ $course->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $course->updated_at->format('M d, Y') }}</span>
                                        <p class="text-xs text-gray-500">{{ $course->updated_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.course-approvals.show', $course) }}" 
                                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold text-sm transition">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg text-gray-600">No courses pending review</p>
                    <p class="text-sm text-gray-500 mt-2">All submitted courses have been processed</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
