<x-teacher-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Students') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Students Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled Courses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($students as $student)
                                    @php
                                        $firstEnrollment = $student->enrollments->first();
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ substr($student->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>{{ $student->phone ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($student->address ?? 'N/A', 30) }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-1">
                                                @foreach($student->enrollments as $enrollment)
                                                    <div class="text-sm text-gray-900 font-medium">{{ $enrollment->course->title }}</div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($firstEnrollment)
                                                <div class="text-sm text-gray-900">{{ $firstEnrollment->enrolled_at->format('M d, Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $firstEnrollment->enrolled_at->diffForHumans() }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($firstEnrollment)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($firstEnrollment->status === 'active') bg-green-100 text-green-800
                                                    @elseif($firstEnrollment->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($firstEnrollment->status === 'completed') bg-blue-100 text-blue-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($firstEnrollment->status) }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900">View Profile</a>
                                                <a href="#" class="text-green-600 hover:text-green-900">Progress</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="max-w-md mx-auto">
                                                <div class="mb-4">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No students enrolled</h3>
                                                <p class="text-gray-500">Students will appear here once they enroll in your courses.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($students->hasPages())
                        <div class="mt-8">
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>