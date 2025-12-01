@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Welcome to Paathshaala</h2>
                    <p class="text-gray-600">You have logged in successfully!</p>
                    
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                            <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-200">
                                <h3 class="text-lg font-semibold text-indigo-900 mb-2">Admin Dashboard</h3>
                                <p class="text-indigo-700 text-sm mb-4">Manage users, courses, and platform settings</p>
                                <a href="{{ route('admin.dashboard') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    Go to Admin Dashboard
                                </a>
                            </div>
                        @endif
                        
                        @if(auth()->user()->isInstructor())
                            <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                                <h3 class="text-lg font-semibold text-green-900 mb-2">Instructor Dashboard</h3>
                                <p class="text-green-700 text-sm mb-4">Create and manage your courses</p>
                                <a href="{{ route('instructor.dashboard') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Go to Instructor Dashboard
                                </a>
                            </div>
                        @endif
                        
                        @if(auth()->user()->isStudent())
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                <h3 class="text-lg font-semibold text-blue-900 mb-2">Student Dashboard</h3>
                                <p class="text-blue-700 text-sm mb-4">View your courses and progress</p>
                                <a href="{{ route('student.dashboard') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Go to Student Dashboard
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Your Profile Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ auth()->user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Role</p>
                                <p class="font-medium">
                                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                                        @if(auth()->user()->isSuperAdmin())
                                            bg-red-100 text-red-800
                                        @elseif(auth()->user()->isAdmin())
                                            bg-purple-100 text-purple-800
                                        @elseif(auth()->user()->isInstructor())
                                            bg-green-100 text-green-800
                                        @else
                                            bg-blue-100 text-blue-800
                                        @endif
                                    ">
                                        {{ auth()->user()->role->name ?? 'No Role' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Member Since</p>
                                <p class="font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
