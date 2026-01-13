<x-layouts.auth>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 montserrat">Create Account</h2>
        <p class="text-gray-600 mt-2">Join Medniks to connect with professionals and advance your medical education.</p>
    </div>
    
    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
        @csrf
        
        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-user text-gray-400 mr-2"></i>Full Name
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                   placeholder="Enter your full name">
            @error('name')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                   placeholder="your.email@example.com">
            @error('email')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-phone text-gray-400 mr-2"></i>Phone Number
            </label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('phone') border-red-500 @enderror"
                   placeholder="+91 XXXXX XXXXX">
            @error('phone')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Role Selection (Spatie Role) -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-user-tag text-gray-400 mr-2"></i>Who are you?
            </label>
            <select id="role" name="role" required onchange="toggleProfessionField()"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('role') border-red-500 @enderror">
                <option value="">Select your role</option>
                <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Instructor/Professional</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student/Learner</option>
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Profession Type (shown for instructors) -->
        <div id="professionField" style="display: {{ old('role') == 'instructor' ? 'block' : 'none' }};">
            <label for="profession_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-briefcase text-gray-400 mr-2"></i>Profession Type
            </label>
            <select id="profession_type" name="profession_type"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <option value="">Select profession</option>
                <option value="doctor" {{ old('profession_type') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="nurse" {{ old('profession_type') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                <option value="medical_researcher" {{ old('profession_type') == 'medical_researcher' ? 'selected' : '' }}>Medical Researcher</option>
                <option value="healthcare_consultant" {{ old('profession_type') == 'healthcare_consultant' ? 'selected' : '' }}>Healthcare Consultant</option>
                <option value="pharmacist" {{ old('profession_type') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                <option value="other" {{ old('profession_type') == 'other' ? 'selected' : '' }}>Other Medical Professional</option>
            </select>
        </div>
        
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-lock text-gray-400 mr-2"></i>Password
            </label>
            <input id="password" type="password" name="password" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                   placeholder="Create a strong password">
            @error('password')
                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-lock text-gray-400 mr-2"></i>Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                   placeholder="Re-enter your password">
        </div>
        
        <!-- Location Fields in Grid -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">
                    <i class="fas fa-city text-gray-400 mr-2"></i>City
                </label>
                <input id="city" type="text" name="city" value="{{ old('city') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                       placeholder="City">
            </div>
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-1.5">
                    State
                </label>
                <input id="state" type="text" name="state" value="{{ old('state') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                       placeholder="State">
            </div>
        </div>
        
        <div>
            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-map-pin text-gray-400 mr-2"></i>PIN Code
            </label>
            <input id="pincode" type="text" name="pincode" value="{{ old('pincode') }}" maxlength="6"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                   placeholder="PIN Code">
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300 mt-6">
            <i class="fas fa-user-plus mr-2"></i>Create Account
        </button>
        
        <!-- Login Link -->
        <p class="mt-6 text-center text-gray-600 text-sm">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                Sign In
            </a>
        </p>
    </form>
    
    <script>
        function toggleProfessionField() {
            const role = document.getElementById('role').value;
            const professionField = document.getElementById('professionField');
            const professionSelect = document.getElementById('profession_type');
            
            if (role === 'instructor') {
                professionField.style.display = 'block';
                professionSelect.required = true;
            } else {
                professionField.style.display = 'none';
                professionSelect.required = false;
                professionSelect.value = '';
            }
        }
    </script>
</x-layouts.auth>
