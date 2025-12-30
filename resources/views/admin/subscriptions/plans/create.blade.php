<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create Subscription Plan
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg border border-indigo-100 p-6">
            <form action="{{ route('admin.subscriptions.plans.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Plan Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plan Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., Starter, Professional, Premium" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required placeholder="e.g., silver, gold, platinum" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description') }}</textarea>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (INR) *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', '0.00') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Courses -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Courses</label>
                        <input type="number" name="max_courses" value="{{ old('max_courses') }}" placeholder="Leave empty for unlimited" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Maximum number of courses teacher can create</p>
                    </div>

                    <!-- Max Students -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Students</label>
                        <input type="number" name="max_students" value="{{ old('max_students') }}" placeholder="Leave empty for unlimited" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Maximum number of students per course</p>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <input type="number" name="priority" value="{{ old('priority', '0') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Lower number = higher priority (for display order)</p>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                    </div>

                    <!-- Features (JSON) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Features (one per line)</label>
                        <textarea name="features_list" rows="5" placeholder="E.g.,&#10;Unlimited course uploads&#10;Priority support&#10;Analytics dashboard" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('features_list') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Enter each feature on a new line</p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.subscriptions.plans.index') }}" class="px-6 py-2 border border-indigo-200 rounded-lg text-indigo-700 hover:bg-indigo-50 transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                            Create Plan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
