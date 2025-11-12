<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student Details: ') . $student->name }}
            </h2>
            <div class="flex space-x-2">
                <!-- Edit Student -->
                <a href="{{ route('admin.students.edit', $student) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Student
                </a>
                
                <!-- Delete Student -->
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out"
                            onclick="return confirm('Are you sure you want to delete {{ $student->name }}? This will remove all their enrollments, certificates, and payment records. This action cannot be undone.')">
                        <i class="fas fa-trash mr-2"></i>Delete Student
                    </button>
                </form>
                
                <!-- Back to List -->
                <a href="{{ route('admin.students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Students
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Student Information Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-center">
                                <div class="mx-auto h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                                    <span class="text-indigo-600 font-bold text-2xl">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $student->name }}</h3>
                                <p class="text-sm text-gray-500 mb-4">Student ID: #{{ $student->id }}</p>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->phone ?: 'Not provided' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->address ?: 'Not provided' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                                        <dd class="text-sm text-gray-900">{{ $student->created_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                                        <dd class="text-sm">
                                            @if($student->email_verified_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Not Verified
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enrollments and Activity -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Enrollments -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Course Enrollments ({{ $student->enrollments->count() }})</h3>
                            
                            @if($student->enrollments->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled Date</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($student->enrollments as $enrollment)
                                                <tr>
                                                    <td class="px-4 py-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $enrollment->course->title }}</div>
                                                        <div class="text-sm text-gray-500">${{ number_format($enrollment->course->price, 2) }}</div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if($enrollment->payment_status === 'paid') bg-green-100 text-green-800
                                                            @elseif($enrollment->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ ucfirst($enrollment->payment_status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4 text-sm text-gray-500">
                                                        {{ $enrollment->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <div class="flex items-center">
                                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                                                            </div>
                                                            <span class="ml-2 text-sm text-gray-500">{{ $enrollment->progress_percentage ?? 0 }}%</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">No course enrollments yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Certificates -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Certificates ({{ $student->certificates->count() }})</h3>
                            
                            @if($student->certificates->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($student->certificates as $certificate)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $certificate->course->title }}</h4>
                                                    <p class="text-sm text-gray-500">{{ $certificate->issued_at->format('M d, Y') }}</p>
                                                </div>
                                                <i class="fas fa-certificate text-yellow-500"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">No certificates earned yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment History ({{ $student->payments->count() }})</h3>
                            
                            @if($student->payments->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($student->payments as $payment)
                                                <tr>
                                                    <td class="px-4 py-4 text-sm text-gray-900">{{ $payment->course->title }}</td>
                                                    <td class="px-4 py-4 text-sm text-gray-900">${{ number_format($payment->amount, 2) }}</td>
                                                    <td class="px-4 py-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if($payment->status === 'completed') bg-green-100 text-green-800
                                                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $payment->created_at->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">No payment history.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>