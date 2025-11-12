<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-blue-100">Continue your learning journey, access your courses, and track your progress.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                                <div class="text-sm font-medium text-gray-500">Enrolled Courses</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_enrollments'] }}</div>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Certificates</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['certificates_earned'] }}</div>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Average Progress</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['average_progress'], 1) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
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

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Payments</div>
                                <div class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['total_payments'], 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Enrolled Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Courses</h3>
                            <a href="{{ route('student.courses') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($enrollments->take(4) as $enrollment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $enrollment->course->title }}</div>
                                        <div class="text-sm text-gray-500">by {{ $enrollment->course->teacher->name }}</div>
                                        <div class="mt-1">
                                            <div class="flex items-center">
                                                <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-600">{{ $enrollment->progress_percentage }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($enrollment->status === 'active') bg-green-100 text-green-800
                                            @elseif($enrollment->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No courses enrolled yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Upcoming Classes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Upcoming Classes</h3>
                            <a href="{{ route('student.classes') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
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
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($class->type === 'live') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800 @endif">
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

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Certificates -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Certificates</h3>
                            <a href="{{ route('student.certificates') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($certificates as $certificate)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $certificate->course->title }}</div>
                                        <div class="text-sm text-gray-500">Issued: {{ $certificate->issued_date->format('M d, Y') }}</div>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ $certificate->certificate_url ?? '#' }}" class="text-blue-600 hover:text-blue-800 text-sm" target="_blank">
                                            Download
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No certificates earned yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Payments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
                            <a href="{{ route('student.payments') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentPayments as $payment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $payment->course->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->created_at->format('M d, Y') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-green-600">₹{{ number_format($payment->final_amount, 2) }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->payment_method }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No payments made yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>