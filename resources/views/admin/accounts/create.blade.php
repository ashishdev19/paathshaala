<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Create New Admin Account
            </h2>
            <a href="{{ route('admin.accounts.index') }}" class="bg-gray-500 text-white px-6 py-2.5 rounded-lg hover:bg-gray-600 transition duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Accounts
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.accounts.store') }}" method="POST" class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            @csrf

            <div class="p-8 space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 @error('name') border-red-500 @enderror"
                           placeholder="e.g., John Doe"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 @error('email') border-red-500 @enderror"
                           placeholder="e.g., john@example.com"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input type="tel" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 @error('phone') border-red-500 @enderror"
                           placeholder="e.g., +1 234 567 8900">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 @error('password') border-red-500 @enderror"
                           placeholder="Minimum 8 characters"
                           required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Must be at least 8 characters with letters and numbers</p>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150"
                           placeholder="Re-enter password"
                           required>
                </div>

                <!-- Role Selection -->
                <div class="border-t border-gray-200 pt-6">
                    <label for="admin_role_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Assign Role <span class="text-red-500">*</span>
                    </label>
                    <select name="admin_role_id" 
                            id="admin_role_id" 
                            required
                            onchange="showRolePermissions(this.value)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 @error('admin_role_id') border-red-500 @enderror">
                        <option value="">Select a role...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                    data-permissions="{{ $role->permissions->pluck('name')->toJson() }}"
                                    {{ old('admin_role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }} ({{ $role->permissions->count() }} permissions)
                            </option>
                        @endforeach
                    </select>
                    @error('admin_role_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Role Permissions Display -->
                    <div id="role-permissions" class="mt-4 hidden">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-900 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Permissions included in this role:
                            </h4>
                            <div id="permissions-list" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Active Status -->
                <div class="flex items-center pt-4">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded transition duration-150">
                    <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                        Active (Account can login immediately)
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('admin.accounts.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:from-green-700 hover:to-teal-700 transition duration-200 shadow-md hover:shadow-lg font-medium">
                    Create Account
                </button>
            </div>
        </form>
    </div>

    <script>
        function showRolePermissions(roleId) {
            const permissionsDiv = document.getElementById('role-permissions');
            const permissionsList = document.getElementById('permissions-list');
            
            if (!roleId) {
                permissionsDiv.classList.add('hidden');
                return;
            }

            const select = document.getElementById('admin_role_id');
            const selectedOption = select.options[select.selectedIndex];
            const permissions = JSON.parse(selectedOption.dataset.permissions || '[]');
            
            if (permissions.length === 0) {
                permissionsDiv.classList.add('hidden');
                return;
            }

            permissionsList.innerHTML = permissions.map(permission => 
                `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    ${permission}
                </span>`
            ).join('');
            
            permissionsDiv.classList.remove('hidden');
        }

        // Initialize on page load if role is already selected
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('admin_role_id');
            if (roleSelect.value) {
                showRolePermissions(roleSelect.value);
            }
        });
    </script>
</x-layouts.admin>
