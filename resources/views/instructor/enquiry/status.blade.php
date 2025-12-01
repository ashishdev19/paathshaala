@extends('layouts.app')

@section('title', 'Application Status')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Application Status</h1>
            <p class="text-lg text-gray-600">Track your instructor registration application</p>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            @php
                $statusColors = [
                    'pending' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'badge' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fas fa-clock text-yellow-600'],
                    'approved' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'badge' => 'bg-green-100 text-green-800', 'icon' => 'fas fa-check-circle text-green-600'],
                    'rejected' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'badge' => 'bg-red-100 text-red-800', 'icon' => 'fas fa-times-circle text-red-600'],
                ];
                $status = $enquiry->status ?? 'pending';
                $colors = $statusColors[$status] ?? $statusColors['pending'];
            @endphp

            <div class="{{ $colors['bg'] }} border-2 {{ $colors['border'] }} rounded-lg p-6 mb-6">
                <div class="flex items-center mb-4">
                    <i class="{{ $colors['icon'] }} fa-3x mr-4"></i>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ ucfirst($status) }}</h2>
                        <p class="text-gray-600">
                            @if($status === 'pending')
                                Your application is under review. We'll notify you soon.
                            @elseif($status === 'approved')
                                Congratulations! You're approved to start teaching.
                            @else
                                Unfortunately, your application was not approved at this time.
                            @endif
                        </p>
                    </div>
                </div>
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $colors['badge'] }}">
                    {{ ucfirst($status) }} on {{ $enquiry->updated_at->format('M d, Y') }}
                </span>
            </div>

            <!-- Application Details -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Full Name</p>
                            <p class="font-semibold text-gray-900">{{ $enquiry->full_name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900">{{ $enquiry->email }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-semibold text-gray-900">{{ $enquiry->phone_number }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Qualification</p>
                            <p class="font-semibold text-gray-900">{{ $enquiry->qualification }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Experience</p>
                            <p class="font-semibold text-gray-900">{{ $enquiry->experience }} years</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Applied On</p>
                            <p class="font-semibold text-gray-900">{{ $enquiry->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Subject Expertise -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Subject Expertise</p>
                    <p class="text-gray-900">{{ $enquiry->subject_expertise }}</p>
                </div>

                <!-- Bio -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">About You</p>
                    <p class="text-gray-900">{{ $enquiry->bio }}</p>
                </div>

                <!-- Admin Notes (if rejected) -->
                @if($status === 'rejected' && $enquiry->admin_notes)
                    <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-2">Feedback from Admin</p>
                        <p class="text-gray-900">{{ $enquiry->admin_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-8 border-t">
                @if($status === 'approved')
                    <a href="{{ route('instructor.dashboard') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                        <i class="fas fa-arrow-right mr-2"></i> Go to Dashboard
                    </a>
                @elseif($status === 'rejected')
                    <a href="{{ route('teacher.enquiry.create') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-redo mr-2"></i> Apply Again
                    </a>
                @endif
                <a href="{{ route('home') }}" class="inline-block ml-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-semibold">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
