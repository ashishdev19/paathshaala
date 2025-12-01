<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Class Attendance
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <a href="{{ route('instructor.live-classes.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    ← Back to Live Classes
                </a>
            </div>

            <!-- Class Info Header -->
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-900">{{ $liveClass->topic }}</h3>
                <div class="flex gap-6 mt-3 text-sm text-gray-600">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $liveClass->start_datetime->format('M d, Y - h:i A') }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 8 4 4 0 010-8zM3 20.458A6 6 0 0112 16c3.314 0 6.208.938 8 2.458M3 20.458V18a6 6 0 0112 0v2.458M3 20.458A8.968 8.968 0 0112 15a8.968 8.968 0 019 5.458"/></svg>
                        <span id="total-students">0</span> Students Enrolled
                    </span>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Present</p>
                            <p id="present-count" class="text-3xl font-bold text-green-600">0</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Absent</p>
                            <p id="absent-count" class="text-3xl font-bold text-red-600">0</p>
                        </div>
                        <svg class="w-8 h-8 text-red-600 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-1">Attendance Rate</p>
                            <p id="attendance-rate" class="text-3xl font-bold text-yellow-600">0%</p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-600 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Student Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Time Joined</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Duration (mins)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition duration-200">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">
                                <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8 4 4 0 010-8zM3 20.458A6 6 0 0112 16c3.314 0 6.208.938 8 2.458M3 20.458V18a6 6 0 0112 0v2.458M3 20.458A8.968 8.968 0 0112 15a8.968 8.968 0 019 5.458M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-semibold">No attendance data yet</p>
                                <p class="text-xs mt-1">Attendance will appear once students join the class</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Export Button -->
            <div class="mt-6 flex gap-3 justify-end">
                <a href="{{ route('instructor.live-classes.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                    Back
                </a>
                <button onclick="alert('Export feature coming soon')" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export CSV
                </button>
            </div>
        </div>
    </div>

    <script>
        // Calculate and update stats
        function updateStats() {
            // This would normally fetch data from the server
            // For now, display placeholder message
            const presentCount = 0;
            const absentCount = 0;
            const totalEnrolled = 0;
            const rate = totalEnrolled > 0 ? Math.round((presentCount / totalEnrolled) * 100) : 0;

            document.getElementById('present-count').textContent = presentCount;
            document.getElementById('absent-count').textContent = absentCount;
            document.getElementById('attendance-rate').textContent = rate + '%';
            document.getElementById('total-students').textContent = totalEnrolled;
        }

        // Call on page load
        document.addEventListener('DOMContentLoaded', updateStats);
    </script>
</x-layouts.instructor>
