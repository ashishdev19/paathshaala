<x-layouts.instructor>
    <x-slot name='header'>
        <h2 class='font-semibold text-2xl text-gray-800'>Instructor Dashboard</h2>
    </x-slot>
    <div class='bg-green-50 p-6 rounded-lg mb-6'>
        <h1 class='text-2xl font-bold text-green-800'>Welcome, {{ Auth::user()->name }}!</h1>
        <p class='text-green-600'>Manage your courses and students from here.</p>
    </div>
    <div class='grid grid-cols-1 md:grid-cols-3 gap-6'>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>My Courses</h3><p class='text-3xl font-bold text-green-600'>{{ $stats['total_courses'] ?? 0 }}</p></div>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>My Students</h3><p class='text-3xl font-bold text-blue-600'>{{ $stats['total_students'] ?? 0 }}</p></div>
        <div class='bg-white p-6 rounded-lg shadow'><h3 class='text-lg font-semibold mb-2'>Online Classes</h3><p class='text-3xl font-bold text-purple-600'>{{ $stats['total_classes'] ?? 0 }}</p></div>
    </div>
</x-layouts.instructor>
