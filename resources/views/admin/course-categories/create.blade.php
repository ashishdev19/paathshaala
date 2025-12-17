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
</x-layouts.admin>
