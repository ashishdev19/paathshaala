<!-- Footer -->
<footer class="site-footer">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-xl font-bold mb-4 montserrat">{{ config('app.name') }}</h3>
                <p class="text-teal-100 mb-4">Empowering medical professionals through quality education and training</p>
                <div class="flex gap-3">
                    <a href="#" class="social-icon bg-white/15 hover:bg-white/25">
                        <i class="fab fa-facebook-f text-white"></i>
                    </a>
                    <a href="#" class="social-icon bg-white/15 hover:bg-white/25">
                        <i class="fab fa-instagram text-white"></i>
                    </a>
                    <a href="#" class="social-icon bg-white/15 hover:bg-white/25">
                        <i class="fab fa-youtube text-white"></i>
                    </a>
                    <a href="#" class="social-icon bg-white/15 hover:bg-white/25">
                        <i class="fab fa-linkedin-in text-white"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="footer-links">
                <h4 class="text-lg font-semibold mb-4 montserrat text-white">Platform</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('courses.index') }}">Browse Courses</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="#faculty">Our Faculty</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            
            <!-- Specializations -->
            <div class="footer-links">
                <h4 class="text-lg font-semibold mb-4 montserrat text-white">Specializations</h4>
                <ul class="space-y-2">
                    <li><a href="#">Aesthetic Medicine</a></li>
                    <li><a href="#">Aesthetic Gynecology</a></li>
                    <li><a href="#">Ultrasound</a></li>
                    <li><a href="#">IVF & Reproductive Medicine</a></li>
                    <li><a href="#">Surgical Courses</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="text-lg font-semibold mb-4 montserrat text-white">Contact Us</h4>
                <ul class="space-y-2 text-teal-50">
                    <li>
                        <i class="fas fa-envelope mr-2"></i>
                        info@medniks.com
                    </li>
                    <li>
                        <i class="fas fa-phone mr-2"></i>
                        +1 234 567 8900
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        123 Medical Plaza, Healthcare City
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-white/30 pt-6 text-center text-teal-50">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="mt-2">
                <span class="inline-block mr-4">
                    <i class="fas fa-shield-alt mr-1"></i>SSL Secured
                </span>
                <span class="inline-block">
                    <i class="fas fa-certificate mr-1"></i>ISO Certified
                </span>
            </div>
        </div>
    </div>
</footer>
