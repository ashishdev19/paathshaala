<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students Management') }}
            </h2>
            <a href="{{ route('admin.students.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Add New Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Students Summary Dashboard -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Analytics Overview</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                            <!-- Total Students Card -->
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-users text-indigo-600 text-lg"></i>
                                                </div>
                                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Total Students</p>
                                            </div>
                                            <div class="mt-3">
                                                <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($students->total()) }}</p>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                                                    <p class="text-gray-500 text-xs font-medium">All registered students</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full p-3 shadow-lg">
                                            <i class="fas fa-chart-line text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-2 bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
                            </div>

                            <!-- Active Students Card -->
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-user-check text-emerald-600 text-lg"></i>
                                                </div>
                                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Active Students</p>
                                            </div>
                                            <div class="mt-3">
                                                <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($students->where('email_verified_at', '!=', null)->count()) }}</p>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                                    <p class="text-gray-500 text-xs font-medium">Email verified accounts</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full p-3 shadow-lg">
                                            <i class="fas fa-check-circle text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-2 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
                            </div>

                            <!-- Enrolled Students Card -->
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-graduation-cap text-amber-600 text-lg"></i>
                                                </div>
                                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">With Enrollments</p>
                                            </div>
                                            <div class="mt-3">
                                                <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($students->filter(function($student) { return $student->enrollments->count() > 0; })->count()) }}</p>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                                    <p class="text-gray-500 text-xs font-medium">Students taking courses</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-full p-3 shadow-lg">
                                            <i class="fas fa-book-open text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-2 bg-gradient-to-r from-amber-500 to-amber-600"></div>
                            </div>

                            <!-- New Students Card -->
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-user-plus text-purple-600 text-lg"></i>
                                                </div>
                                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">New This Month</p>
                                            </div>
                                            <div class="mt-3">
                                                <p class="text-4xl font-black text-gray-900 mb-1">{{ number_format($students->where('created_at', '>=', now()->startOfMonth())->count()) }}</p>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                                    <p class="text-gray-500 text-xs font-medium">{{ now()->format('F Y') }} registrations</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-full p-3 shadow-lg">
                                            <i class="fas fa-calendar-plus text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-2 bg-gradient-to-r from-purple-500 to-purple-600"></div>
                            </div>
                        </div>

                        <!-- Quick Actions Bar -->
                        <div class="mt-6 bg-gray-50 rounded-lg p-4">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <h4 class="text-sm font-medium text-gray-700">Quick Actions:</h4>
                                    <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-user-plus mr-2"></i>Add Student
                                    </a>
                                    <button onclick="window.print()" class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-print mr-2"></i>Print List
                                    </button>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    Last updated: {{ now()->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Students Directory</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">Showing {{ $students->count() }} of {{ $students->total() }} students</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-user text-gray-400"></i>
                                                <span>Student Info</span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-envelope text-gray-400"></i>
                                                <span>Contact Details</span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-graduation-cap text-gray-400"></i>
                                                <span>Enrollments</span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-calendar text-gray-400"></i>
                                                <span>Joined Date</span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center justify-end space-x-1">
                                                <i class="fas fa-cogs text-gray-400"></i>
                                                <span>Actions</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($students as $student)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50 transition-all duration-200">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                                                        <span class="text-white font-bold text-sm">
                                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-base font-semibold text-gray-900">
                                                        {{ $student->name }}
                                                    </div>
                                                    <div class="flex items-center space-x-2 mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                            <i class="fas fa-hashtag mr-1 text-xs"></i>{{ $student->id }}
                                                        </span>
                                                        @if($student->email_verified_at)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-600">
                                                                <i class="fas fa-check-circle mr-1 text-xs"></i>Verified
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-600">
                                                                <i class="fas fa-clock mr-1 text-xs"></i>Pending
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="space-y-1">
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                                    <a href="mailto:{{ $student->email }}" class="hover:text-indigo-600 transition-colors">{{ $student->email }}</a>
                                                </div>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                                    @if($student->phone)
                                                        <a href="tel:{{ $student->phone }}" class="hover:text-indigo-600 transition-colors">{{ $student->phone }}</a>
                                                    @else
                                                        <span class="text-gray-400 italic">No phone provided</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="space-y-1">
                                                <div class="flex items-center">
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                                        @if($student->enrollments->count() > 0) bg-indigo-100 text-indigo-800 @else bg-gray-100 text-gray-600 @endif">
                                                        <i class="fas fa-book mr-1"></i>
                                                        {{ $student->enrollments->count() }} {{ Str::plural('course', $student->enrollments->count()) }}
                                                    </span>
                                                </div>
                                                @if($student->enrollments->count() > 0)
                                                    <div class="text-xs text-gray-500 truncate" style="max-width: 150px;">
                                                        Latest: {{ $student->enrollments->first()->course->title ?? 'N/A' }}
                                                    </div>
                                                @else
                                                    <div class="text-xs text-gray-400 italic">No active enrollments</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="space-y-1">
                                                <div class="text-sm font-medium text-gray-900">{{ $student->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-3">
                                                <!-- View Action -->
                                                <a href="{{ route('admin.students.show', $student) }}" 
                                                   class="inline-flex items-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 hover:text-indigo-800 rounded-md transition duration-150 ease-in-out"
                                                   title="View Student Details">
                                                    <i class="fas fa-eye mr-2"></i>View
                                                </a>
                                                
                                                <!-- Edit Action -->
                                                <a href="{{ route('admin.students.edit', $student) }}" 
                                                   class="inline-flex items-center px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 hover:text-green-800 rounded-md transition duration-150 ease-in-out"
                                                   title="Edit Student Information">
                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                </a>
                                                
                                                <!-- Delete Action -->
                                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 rounded-md transition duration-150 ease-in-out"
                                                            title="Delete Student"
                                                            onclick="return confirm('Are you sure you want to delete {{ $student->name }}? This action cannot be undone.')">
                                                        <i class="fas fa-trash mr-2"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12">
                                            <div class="text-center">
                                                <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                                                    <i class="fas fa-users text-6xl"></i>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No students found</h3>
                                                <p class="text-gray-500 mb-4">Get started by adding your first student to the system.</p>
                                                <a href="{{ route('admin.students.create') }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                                    <i class="fas fa-user-plus mr-2"></i>Add First Student
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($students->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
        </div>
    </div>
</x-admin-layout>