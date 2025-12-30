<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Category
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg border border-indigo-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-indigo-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <h3 class="text-lg font-semibold text-indigo-900">Category Information</h3>
                <p class="text-sm text-gray-600">Fill in the details below to create a new course category</p>
            </div>

            <form action="{{ route('admin.course-categories.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Category Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Medical Coding & Billing"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div class="mb-6">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon (Font Awesome Class)
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="text" 
                            name="icon" 
                            id="icon" 
                            value="{{ old('icon') }}"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('icon') border-red-500 @enderror"
                            placeholder="e.g., fa-heart-pulse, fa-brain, fa-syringe"
                        >
                        <div id="iconPreview" class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-gray-500 text-xl"></i>
                        </div>
                    </div>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty to use auto-detected icon. <a href="https://fontawesome.com/icons" target="_blank" class="text-indigo-600 hover:underline">Browse Icons</a></p>
                </div>

                <!-- Show on Homepage -->
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="show_on_homepage" 
                            value="1"
                            {{ old('show_on_homepage', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                        >
                        <span class="text-sm font-medium text-gray-700">Show on Homepage</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500 ml-8">Display this category in the "Browse popular specialties" section</p>
                </div>

                <!-- Display Order -->
                <div class="mb-6">
                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Display Order
                    </label>
                    <input 
                        type="number" 
                        name="display_order" 
                        id="display_order" 
                        value="{{ old('display_order', 0) }}"
                        min="0"
                        class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('display_order') border-red-500 @enderror"
                    >
                    @error('display_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first. Categories with same order are sorted alphabetically.</p>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Active categories will be visible to instructors when creating courses</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.course-categories.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value.trim();
            const preview = document.getElementById('iconPreview');
            if (iconClass) {
                preview.innerHTML = '<i class="fas ' + iconClass + ' text-indigo-600 text-xl"></i>';
            } else {
                preview.innerHTML = '<i class="fas fa-stethoscope text-gray-500 text-xl"></i>';
            }
        });
    </script>
</x-layouts.admin>
