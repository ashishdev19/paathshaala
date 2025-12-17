<x-layouts.auth>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 montserrat">Welcome Back</h2>
        <p class="text-gray-600 mt-2">Sign in to continue your learning journey</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div class="text-sm text-green-800">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="rounded-lg bg-red-50 p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                <div class="text-sm text-red-800">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        
        <!-- Email Input -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                   placeholder="Enter your email">
            @error('email')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Password Input -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lock text-gray-400 mr-2"></i>Password
            </label>
            <div class="relative">
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                       placeholder="Enter your password">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i id="toggleIcon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-700">
                    Remember me
                </label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                    Forgot password?
                </a>
            @endif
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
        </button>
        
        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-600">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                Create one now
            </a>
        </p>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to home
            </a>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-layouts.auth>
