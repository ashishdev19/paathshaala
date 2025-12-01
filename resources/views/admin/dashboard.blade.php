@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Platform Management & Overview</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Professors Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Professors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['professors'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5h7M6.5 10h7M6.5 13.5h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Students</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['students'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Courses Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Courses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['courses'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Enrollments Card -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Enrollments</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['enrollments'] ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a1 1 0 00-1-1h-1V9a6 6 0 00-12 0v6H2a1 1 0 00-1 1v2h17z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quick Actions (2 column span) -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('admin.teachers.index') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition text-center">
                    <div class="text-2xl mb-2">👥</div>
                    <p class="font-medium text-gray-900">Manage Users</p>
                    <p class="text-sm text-gray-500">Professors & Students</p>
                </a>

                <a href="{{ route('admin.courses.index') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition text-center">
                    <div class="text-2xl mb-2">📚</div>
                    <p class="font-medium text-gray-900">Manage Courses</p>
                    <p class="text-sm text-gray-500">View & Edit</p>
                </a>

                <a href="{{ route('admin.course-approvals.index') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition text-center">
                    <div class="text-2xl mb-2">✅</div>
                    <p class="font-medium text-gray-900">Course Approvals</p>
                    <p class="text-sm text-gray-500">Pending Review</p>
                </a>

                <a href="{{ route('admin.subscriptions.list') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition text-center">
                    <div class="text-2xl mb-2">💳</div>
                    <p class="font-medium text-gray-900">Subscriptions</p>
                    <p class="text-sm text-gray-500">Plans & Payments</p>
                </a>

                <a href="{{ route('admin.wallet.index') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition text-center">
                    <div class="text-2xl mb-2">💰</div>
                    <p class="font-medium text-gray-900">Wallet Management</p>
                    <p class="text-sm text-gray-500">Balance & Withdraw</p>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition text-center">
                    <div class="text-2xl mb-2">📊</div>
                    <p class="font-medium text-gray-900">Reports</p>
                    <p class="text-sm text-gray-500">Analytics & Stats</p>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Activity</h2>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500 mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">New course published</p>
                        <p class="text-xs text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 rounded-full bg-green-500 mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">25 new students enrolled</p>
                        <p class="text-xs text-gray-500">4 hours ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 rounded-full bg-purple-500 mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Subscription plan updated</p>
                        <p class="text-xs text-gray-500">1 day ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 rounded-full bg-orange-500 mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">System backup completed</p>
                        <p class="text-xs text-gray-500">1 day ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
