{{-- Main Footer Component --}}
<footer class="bg-gray-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- About Section --}}
            <div>
                <h3 class="text-xl font-bold mb-4">Paathshaala</h3>
                <p class="text-gray-400">Empowering education through technology. Learn from the best teachers and courses.</p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-white">Courses</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                </ul>
            </div>

            {{-- Resources section removed per request --}}

            {{-- Contact Info --}}
            <div>
                <h4 class="text-lg font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Email: info@paathshaala.com</li>
                    <li>Phone: +91 1234567890</li>
                    <li>Address: India</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Paathshaala. All rights reserved.</p>
        </div>
    </div>
</footer>
