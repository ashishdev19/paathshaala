<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                <div class="text-sm font-medium text-gray-500">Total Courses</div>
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
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Teachers</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_teachers'] }}</div>
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
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Online Classes</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_online_classes'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Revenue</div>
                                <div class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['total_payments'], 2) }}</div>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Pending Payments</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['pending_payments'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <div class="text-sm font-medium text-gray-500">Certificates Issued</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['certificates_issued'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Enrollments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Enrollments</h3>
                        <div class="space-y-4">
                            @forelse($recent_enrollments as $enrollment)
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

                <!-- Recent Payments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Payments</h3>
                        <div class="space-y-4">
                            @forelse($recent_payments as $payment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $payment->student->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->course->title }}</div>
                                        <div class="text-xs text-gray-400">{{ $payment->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-green-600">₹{{ number_format($payment->final_amount, 2) }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->payment_method }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No recent payments</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Actions -->
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Management Actions</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <a href="{{ route('admin.courses.index') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-blue-50 rounded-2xl shadow-lg border-l-4 border-blue-500 hover:border-blue-600 hover:rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-blue-700 transition-colors duration-300">Course System</div>
                                <div class="text-sm text-gray-500 mt-1">Oversee all course content and structure</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-blue-600 font-medium">Manage Courses</span>
                                    <svg class="w-4 h-4 text-blue-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.online-classes.index') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-red-50 rounded-2xl shadow-lg border-l-4 border-red-500 hover:border-red-600 hover:-rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-red-500 via-red-600 to-red-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15,8V4H5V8H15M12,18A3,3 0 0,0 15,15A3,3 0 0,0 12,12A3,3 0 0,0 9,15A3,3 0 0,0 12,18M17,10H22L20,7V4H18V7L17,10M8,10L6.5,7V4H4.5V7L3,10H8M10.29,10L8.78,7V4H10.22V7L8.71,10H10.29M13.71,10L12.2,7V4H13.64V7L12.13,10H13.71M19.5,10.5V12.5H16.5V10.5H19.5M12.5,10.5V12.5H4.5V10.5H12.5M12,16C10.89,16 10,15.1 10,14H14C14,15.1 13.11,16 12,16Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-red-700 transition-colors duration-300">Live Classes</div>
                                <div class="text-sm text-gray-500 mt-1">Monitor and control all online sessions</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-red-600 font-medium">Control Center</span>
                                    <svg class="w-4 h-4 text-red-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.teachers.index') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-purple-50 rounded-2xl shadow-lg border-l-4 border-purple-500 hover:border-purple-600 hover:rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,2A3,3 0 0,1 15,5V11A3,3 0 0,1 12,14A3,3 0 0,1 9,11V5A3,3 0 0,1 12,2M19,11C19,14.53 16.39,17.44 13,17.93V21H11V17.93C7.61,17.44 5,14.53 5,11H7A5,5 0 0,0 12,16A5,5 0 0,0 17,11H19Z"/>
                                    <path d="M9,3V5H15V3H17V5H19A2,2 0 0,1 21,7V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V7A2,2 0 0,1 5,5H7V3H9M5,9V19H19V9H5Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-purple-700 transition-colors duration-300">Faculty Management</div>
                                <div class="text-sm text-gray-500 mt-1">Recruit, approve and manage educators</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-purple-600 font-medium">Manage Faculty</span>
                                    <svg class="w-4 h-4 text-purple-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.students.index') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-green-50 rounded-2xl shadow-lg border-l-4 border-green-500 hover:border-green-600 hover:-rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 via-green-600 to-green-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16,4C18.11,4 19.81,5.69 19.81,7.8C19.81,9.91 18.11,11.6 16,11.6C13.89,11.6 12.19,9.91 12.19,7.8C12.19,5.69 13.89,4 16,4M16,13.4C18.67,13.4 24,14.73 24,17.4V20H8V17.4C8,14.73 13.33,13.4 16,13.4M8.5,12H5.5L6.5,10.5V7.5L5.5,6H8.5L9.5,7.5V10.5L8.5,12M5.75,13.81C4.53,14.13 3.5,14.67 2.83,15.4C2.16,16.13 1.83,17 1.83,18V20H6.2V17.4C6.2,16.07 6.81,14.95 7.83,14.14C7.83,14.1 7.82,14.05 7.8,14C7.08,13.91 6.42,13.86 5.75,13.81Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-green-700 transition-colors duration-300">Student Portal</div>
                                <div class="text-sm text-gray-500 mt-1">Monitor enrollment and academic progress</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-green-600 font-medium">View Students</span>
                                    <svg class="w-4 h-4 text-green-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Video Upload -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <a href="{{ route('admin.online-classes.create') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-indigo-50 rounded-2xl shadow-lg border-l-4 border-indigo-500 hover:border-indigo-600 hover:rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-indigo-500 via-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-indigo-700 transition-colors duration-300">Upload Video</div>
                                <div class="text-sm text-gray-500 mt-1">Create new course and upload video content</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-indigo-600 font-medium">Create Class</span>
                                    <svg class="w-4 h-4 text-indigo-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.courses.create') }}" class="floating-card group flex items-center p-6 bg-white hover:bg-teal-50 rounded-2xl shadow-lg border-l-4 border-teal-500 hover:border-teal-600 hover:-rotate-1">
                            <div class="relative w-16 h-16 bg-gradient-to-br from-teal-500 via-teal-600 to-teal-700 rounded-2xl flex items-center justify-center mr-5 shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform rotate-6 group-hover:rotate-45 transition-transform duration-700 group-hover:opacity-30"></div>
                                <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg text-gray-900 group-hover:text-teal-700 transition-colors duration-300">Create Course</div>
                                <div class="text-sm text-gray-500 mt-1">Add new courses to the platform</div>
                                <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-teal-600 font-medium">Add Course</span>
                                    <svg class="w-4 h-4 text-teal-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</x-admin-layout>