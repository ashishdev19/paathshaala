<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Create New Role
            </h2>
            <a href="{{ route('admin.roles.index') }}" class="bg-gray-500 text-white px-6 py-2.5 rounded-lg hover:bg-gray-600 transition duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.roles.store') }}" method="POST" class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            @csrf

            <div class="p-8 space-y-6">
                <!-- Role Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('name') border-red-500 @enderror"
                           placeholder="e.g., Financial Officer"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">A unique name for this role (e.g., Support Officer, Verification Officer)</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('description') border-red-500 @enderror"
                              placeholder="Describe the responsibilities and purpose of this role...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-150">
                    <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                        Active (Role can be assigned to new accounts)
                    </label>
                </div>

                <!-- Permissions Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Assign Permissions
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Select the permissions this role should have</p>

                    @if($permissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                        </svg>
                                        {{ ucfirst($module) ?? 'General' }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($modulePermissions as $permission)
                                            <label class="flex items-start p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 transition duration-150 cursor-pointer">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}"
                                                       {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5">
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
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">No permissions available. Create permissions first.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('admin.roles.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-200 shadow-md hover:shadow-lg font-medium">
                    Create Role
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
