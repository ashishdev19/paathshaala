<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Course Management
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Search and Filter -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 border-b border-indigo-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <input type="text" placeholder="Search courses..." class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                        <option value="">All Teachers</option>
                        @foreach(\App\Models\User::byRole('instructor')->get() as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Courses Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($courses ?? [] as $course)
                    <tr class="hover:bg-indigo-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded object-cover shadow-md border border-indigo-200" src="{{ $course->thumbnail ? '/storage/' . $course->thumbnail : 'https://via.placeholder.com/40' }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $course->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($course->description, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $course->teacher->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-indigo-600">₹{{ number_format($course->price, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300">
                                {{ $course->enrollments_count ?? 0 }} Students
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border
                                @if($course->status == 'active') bg-gradient-to-r from-green-100 to-green-200 text-green-800 border-green-300
                                @elseif($course->status == 'inactive') bg-gradient-to-r from-red-100 to-red-200 text-red-800 border-red-300
                                @else bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-gray-300 @endif">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="text-indigo-600 hover:text-indigo-800 mr-3 font-semibold">Edit</a>
                            <a href="{{ route('admin.courses.show', $course->id) }}" class="text-blue-600 hover:text-blue-800 mr-3 font-semibold">View</a>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mt-4 text-lg">No courses found</p>
                            <p class="mt-2 text-sm">Professors can create courses from their dashboard.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($courses) && $courses->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
