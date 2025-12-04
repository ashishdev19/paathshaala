@props(['role' => 'admin'])

<footer class="" style="background: linear-gradient(180deg,#0f172a,#0b1220); color: #e6eef8;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <p class="text-sm">&copy; {{ date('Y') }} Paathshaala. All rights reserved.</p>
            </div>
            <div class="flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="#" class="hover:text-white">Contact</a>
            </div>
        </div>
    </div>
</footer>