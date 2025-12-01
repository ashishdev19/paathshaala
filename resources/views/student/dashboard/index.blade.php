<x-layouts.student>
    <x-slot name='header'>
        <h2 class='font-semibold text-2xl text-gray-800'>Student Dashboard</h2>
    </x-slot>
    <div class='bg-blue-50 p-6 rounded-lg mb-6'>
        <h1 class='text-2xl font-bold text-blue-800'>Welcome, {{ Auth::user()->name }}!</h1>
        <p class='text-blue-600'>Continue your learning journey.</p>
    </div>
    <div class='grid grid-cols-1 md:grid-cols-3 gap-6'>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>Enrolled Courses</h3><p class='text-3xl font-bold text-blue-600'>{{ $stats['total_enrollments'] ?? 0 }}</p></div>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>Certificates</h3><p class='text-3xl font-bold text-green-600'>{{ $stats['certificates_earned'] ?? 0 }}</p></div>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>Progress</h3><p class='text-3xl font-bold text-purple-600'>{{ $stats['average_progress'] ?? 0 }}%</p></div>
    </div>
</x-layouts.student>
