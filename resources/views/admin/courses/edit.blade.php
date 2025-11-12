<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Course: ') . $course->title }}
            </h2>
            <a href="{{ route('admin.courses.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>Back to Courses
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course Title -->
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Course Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $course->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Course Description')" />
                                <textarea id="description" name="description" rows="4" 
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                    required>{{ old('description', $course->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', default: $course->price)" required step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Duration -->
                            <div>
                                <x-input-label for="duration" :value="__('Duration (Hours)')" />
                                <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration', $course->duration)" required min="1" />
                                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            </div>

                            <!-- Level -->
                            <div>
                                <x-input-label for="level" :value="__('Difficulty Level')" />
                                <select id="level" name="level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Level</option>
                                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            </div>

                            <!-- Teacher -->
                            <div>
                                <x-input-label for="teacher_id" :value="__('Instructor')" />
                                <select id="teacher_id" name="teacher_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Instructor</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category" :value="__('Category')" />
                                <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" :value="old('category', $course->category)" required />
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $course->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $course->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Current Thumbnail -->
                            @if($course->thumbnail)
                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Current Thumbnail')" />
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="h-32 w-48 object-cover rounded-lg">
                                    </div>
                                </div>
                            @endif

                            <!-- New Thumbnail -->
                            <div class="md:col-span-2">
                                <x-input-label for="thumbnail" :value="__('New Thumbnail (Optional)')" />
                                <input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail" accept="image/*" />
                                <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">Upload a new image to replace current thumbnail (JPEG, PNG, JPG, GIF). Max size: 2MB</p>
                            </div>

                            <!-- Featured Course -->
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input id="is_featured" type="checkbox" name="is_featured" value="1" 
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                        {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                                    <label for="is_featured" class="ml-2 text-sm text-gray-700">
                                        Mark as Featured Course
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('admin.courses.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-6 rounded-lg transition duration-150 ease-in-out">
                                Cancel
                            </a>
                            <x-primary-button>
                                <i class="fas fa-save mr-2"></i>{{ __('Update Course') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>