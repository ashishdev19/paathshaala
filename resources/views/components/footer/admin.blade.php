{{-- Admin Dashboard Footer Component --}}
<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- About Paathshaala --}}
            <div>
                <h3 class="text-gray-900 font-bold text-lg mb-4 border-b-2 border-indigo-500 pb-2 inline-block">ABOUT PAATHSHAALA</h3>
                <ul class="space-y-3 text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Our Mission</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Careers</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Blog</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h3 class="text-gray-900 font-bold text-lg mb-4 border-b-2 border-indigo-500 pb-2 inline-block">SUPPORT</h3>
                <ul class="space-y-3 text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Report Issue</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h3 class="text-gray-900 font-bold text-lg mb-4 border-b-2 border-indigo-500 pb-2 inline-block">LEGAL</h3>
                <ul class="space-y-3 text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Cookie Policy</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Security</a></li>
                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h3 class="text-gray-900 font-bold text-lg mb-4 border-b-2 border-indigo-500 pb-2 inline-block">RESOURCES</h3>
                <ul class="space-y-3 text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Documentation</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">API Docs</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Community</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Partner Program</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-200 mt-10 pt-8 flex flex-col md:flex-row justify-between items-center">
            <div class="text-gray-600 text-sm mb-4 md:mb-0">
                <p>© {{ date('Y') }} PaathShaala. All rights reserved.</p>
                <p class="mt-1">Made with <span class="text-red-500">❤</span> for education</p>
            </div>
            
            {{-- Social Media Links --}}
            <div class="flex space-x-4">
                <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-full flex items-center justify-center text-gray-600 hover:text-indigo-600 transition-all">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-full flex items-center justify-center text-gray-600 hover:text-indigo-600 transition-all">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-full flex items-center justify-center text-gray-600 hover:text-indigo-600 transition-all">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-indigo-100 rounded-full flex items-center justify-center text-gray-600 hover:text-indigo-600 transition-all">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
