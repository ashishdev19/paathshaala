@props(['role' => 'admin'])

<footer class="bg-gray-800 text-white py-6 {{ isset($role) && in_array($role, ['admin', 'instructor', 'student']) ? '' : '' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm">&copy; {{ date('Y') }} Medniks. All rights reserved.</p>
            </div>
            <div class="flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-gray-300">Home</a>
                <a href="#" class="hover:text-gray-300">Contact</a>
            </div>
        </div>
    </div>
</footer>