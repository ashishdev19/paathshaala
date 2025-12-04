<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Assign Permissions to Roles
            </h2>
            <a href="{{ route('admin.permissions.index') }}" class="bg-gray-500 text-white px-6 py-2.5 rounded-lg hover:bg-gray-600 transition duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Permissions
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Permission Assignment</h3>
            <p class="text-sm text-gray-600">Select a role and assign the permissions it should have. Changes will be saved immediately.</p>
        </div>

        <form action="{{ route('admin.permissions.assign-store') }}" method="POST" class="p-6">
            @csrf

            <!-- Role Selection -->
            <div class="mb-8">
                <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-3">
                    Select Role <span class="text-red-500">*</span>
                </label>
                <select name="role_id" 
                        id="role_id" 
                        required
                        onchange="updatePermissionDisplay(this.value)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 @error('role_id') border-red-500 @enderror">
                    <option value="">Choose a role...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" 
                                data-permissions="{{ $role->permissions->pluck('id')->toJson() }}"
                                {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }} ({{ $role->permissions->count() }} permissions)
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Permissions Grid -->
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-900">Available Permissions</h4>
                    <div class="flex gap-2">
                        <button type="button" onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Select All
                        </button>
                        <span class="text-gray-400">|</span>
                        <button type="button" onclick="deselectAll()" class="text-sm text-red-600 hover:text-red-800 font-medium">
                            Deselect All
                        </button>
                    </div>
                </div>

                @foreach($permissions as $module => $modulePermissions)
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                </svg>
                                {{ ucfirst($module) ?? 'General' }} Module
                            </h5>
                            <button type="button" onclick="toggleModule('{{ $module }}')" class="text-xs text-purple-600 hover:text-purple-800 font-medium">
                                Toggle All
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($modulePermissions as $permission)
                                <label class="permission-item flex items-start p-3 bg-white rounded-lg border border-gray-200 hover:bg-purple-50 hover:border-purple-300 transition duration-150 cursor-pointer module-{{ $module }}">
                                    <input type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}"
                                           data-module="{{ $module }}"
                                           class="permission-checkbox h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded mt-0.5">
                                    <div class="ml-3 flex-1">
                                        <span class="text-sm font-medium text-gray-900 block">{{ $permission->name }}</span>
                                        @if($permission->description)
                                            <span class="text-xs text-gray-500">{{ $permission->description }}</span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.permissions.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition duration-200 shadow-md hover:shadow-lg font-medium">
                    Save Permissions
                </button>
            </div>
        </form>
    </div>

    <script>
        // Update permission checkboxes when role is selected
        function updatePermissionDisplay(roleId) {
            // Uncheck all checkboxes first
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
            
            if (!roleId) return;
            
            // Get the selected role's permissions
            const select = document.getElementById('role_id');
            const selectedOption = select.options[select.selectedIndex];
            const permissions = JSON.parse(selectedOption.dataset.permissions || '[]');
            
            // Check the appropriate checkboxes
            permissions.forEach(permId => {
                const checkbox = document.querySelector(`input[value="${permId}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }

        // Select all permissions
        function selectAll() {
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
        }

        // Deselect all permissions
        function deselectAll() {
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        }

        // Toggle all permissions in a module
        function toggleModule(module) {
            const checkboxes = document.querySelectorAll(`[data-module="${module}"]`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_id');
            if (roleSelect.value) {
                updatePermissionDisplay(roleSelect.value);
            }
        });
    </script>
</x-layouts.admin>
