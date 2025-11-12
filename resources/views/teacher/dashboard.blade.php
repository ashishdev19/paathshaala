<x-teacher-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-green-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                            <p class="text-green-100">Manage your courses, track student progress, and conduct online classes.</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('online-classes.create') }}" class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 rounded-lg font-bold transition-all duration-300 flex items-center shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Upload Video
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">My Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Students</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Enrollments</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_enrollments'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Active Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['active_courses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Online Classes</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $upcomingClasses->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Status Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Active Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['active_courses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Pending Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['pending_courses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Completed Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['completed_courses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Enrollments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Enrollments</h3>
                            <a href="{{ route('teacher.students') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentEnrollments as $enrollment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $enrollment->student->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $enrollment->course->title }}</div>
                                        <div class="text-xs text-gray-400">{{ $enrollment->enrolled_at->format('M d, Y H:i') }}</div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No recent enrollments</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Upcoming Classes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Upcoming Classes</h3>
                            <a href="{{ route('teacher.classes') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($upcomingClasses as $class)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $class->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $class->course->title }}</div>
                                        <div class="text-xs text-gray-400">{{ $class->scheduled_at->format('M d, Y H:i') }}</div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                            {{ ucfirst($class->type) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No upcoming classes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Per Course -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Students Per Course</h3>
                        <a href="{{ route('teacher.courses') }}" class="text-sm text-blue-600 hover:text-blue-800">Manage Courses</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($studentsPerCourse as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item['course']->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($item['course']->description, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($item['course']->status === 'active') bg-green-100 text-green-800
                                                @elseif($item['course']->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($item['course']->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item['student_count'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ₹{{ number_format($item['course']->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            <a href="#" class="text-green-600 hover:text-green-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No courses found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <style>
                .floating-card:hover {
                    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
                    transform: translateY(-16px) scale(1.05);
                }
                .floating-card {
                    transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
                }
            </style>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <a href="{{ route('teacher.courses') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-blue-50 rounded-2xl shadow-lg border-l-4 border-blue-500 hover:border-blue-600 hover:rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-blue-700 transition-colors duration-300">Course Management</div>
                                <div class="text-sm text-gray-500 mt-1">Create, edit, and organize your courses</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-blue-600 font-medium">Access Now</span>
                                    <svg class="w-4 h-4 text-blue-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>



                        <a href="{{ route('teacher.classes') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-purple-50 rounded-2xl shadow-lg border-l-4 border-purple-500 hover:border-purple-600 hover:-rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21,16V4H3V16H21M21,2A2,2 0 0,1 23,4V16A2,2 0 0,1 21,18H14L16,20V21H8V20L10,18H3A2,2 0 0,1 1,16V4A2,2 0 0,1 3,2H21M5,6H14V11H5V6M15,6H19V8H15V6M19,9V14H15V9H19M5,12H11V14H5V12Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-purple-700 transition-colors duration-300">Class Management</div>
                                <div class="text-sm text-gray-500 mt-1">Schedule, organize and conduct classes</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-purple-600 font-medium">Manage Now</span>
                                    <svg class="w-4 h-4 text-purple-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('teacher.students') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-green-50 rounded-2xl shadow-lg border-l-4 border-green-500 hover:border-green-600 hover:rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 via-green-600 to-green-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16,4C18.11,4 19.81,5.69 19.81,7.8C19.81,9.91 18.11,11.6 16,11.6C13.89,11.6 12.19,9.91 12.19,7.8C12.19,5.69 13.89,4 16,4M16,13.4C18.67,13.4 24,14.73 24,17.4V20H8V17.4C8,14.73 13.33,13.4 16,13.4M8.5,12H5.5L6.5,10.5V7.5L5.5,6H8.5L9.5,7.5V10.5L8.5,12M5.75,13.81C4.53,14.13 3.5,14.67 2.83,15.4C2.16,16.13 1.83,17 1.83,18V20H6.2V17.4C6.2,16.07 6.81,14.95 7.83,14.14C7.83,14.1 7.82,14.05 7.8,14C7.08,13.91 6.42,13.86 5.75,13.81Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-green-700 transition-colors duration-300">Student Analytics</div>
                                <div class="text-sm text-gray-500 mt-1">Track progress and performance insights</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-green-600 font-medium">View Analytics</span>
                                    <svg class="w-4 h-4 text-green-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>