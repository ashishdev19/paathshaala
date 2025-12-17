{{-- Admin Dashboard Footer Component --}}
<footer class="w-full" style="background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);">
    <div class="w-full px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
            {{-- About Medniks --}}
            <div>
                <h3 class="text-white font-bold text-sm mb-4 tracking-wide">ABOUT MEDNIKS</h3>
                <ul class="space-y-3 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Our Mission</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h3 class="text-white font-bold text-sm mb-4 tracking-wide">SUPPORT</h3>
                <ul class="space-y-3 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Report Issue</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h3 class="text-white font-bold text-sm mb-4 tracking-wide">LEGAL</h3>
                <ul class="space-y-3 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h3 class="text-white font-bold text-sm mb-4 tracking-wide">RESOURCES</h3>
                <ul class="space-y-3 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">API Docs</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Community</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Partner Program</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-slate-700 mt-10 pt-8 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto">
            <div class="text-slate-400 text-sm mb-4 md:mb-0">
                <p>© {{ date('Y') }} Medniks. All rights reserved.</p>
                <p class="mt-1">Made with <span class="text-red-500">❤</span> for education</p>
            </div>
            
            {{-- Social Media Links --}}
            <div class="flex space-x-4">
                <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-indigo-600 rounded-full flex items-center justify-center text-slate-300 hover:text-white transition-all">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-indigo-600 rounded-full flex items-center justify-center text-slate-300 hover:text-white transition-all">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-indigo-600 rounded-full flex items-center justify-center text-slate-300 hover:text-white transition-all">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-indigo-600 rounded-full flex items-center justify-center text-slate-300 hover:text-white transition-all">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
