<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Create New Course</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(!($hasSubscription ?? true))
            <div class="p-6 border border-yellow-200 bg-yellow-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Subscription Required</h3>
                <p class="text-sm text-gray-700 mb-4">Please subscribe to a teacher plan to create courses.</p>
                <a href="{{ route('instructor.subscription.show') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg">View Plans</a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-lg border border-indigo-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-indigo-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <h3 class="text-lg font-semibold text-indigo-900">Course Details</h3>
                    <p class="text-sm text-gray-600">Fill in all required information to create your course</p>
                </div>

                <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="space-y-6">
                        <!-- Category Selection -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Course Category <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="category_id" 
                                id="category_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Select a Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Course Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                                placeholder="e.g., Complete Medical Coding & Billing Masterclass"
                                required
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Course Description <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                                placeholder="Provide a detailed description of your course..."
                                required
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Course Duration <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="duration" 
                                id="duration" 
                                value="{{ old('duration') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('duration') border-red-500 @enderror"
                                placeholder="e.g., 3 Months, 6 Weeks, 1 Year"
                                required
                            >
                            @error('duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Class Timing -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="class_start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Class Start Time
                                </label>
                                <input 
                                    type="time" 
                                    name="class_start_time" 
                                    id="class_start_time" 
                                    value="{{ old('class_start_time') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('class_start_time') border-red-500 @enderror"
                                >
                                @error('class_start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="class_end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Class End Time
                                </label>
                                <input 
                                    type="time" 
                                    name="class_end_time" 
                                    id="class_end_time" 
                                    value="{{ old('class_end_time') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('class_end_time') border-red-500 @enderror"
                                >
                                @error('class_end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Course Mode -->
                        <div>
                            <label for="mode" class="block text-sm font-medium text-gray-700 mb-2">
                                Course Mode <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="mode" 
                                id="mode" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('mode') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Select Mode --</option>
                                <option value="online" {{ old('mode') === 'online' ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ old('mode') === 'offline' ? 'selected' : '' }}>Offline</option>
                                <option value="hybrid" {{ old('mode') === 'hybrid' ? 'selected' : '' }}>Hybrid (Online + Offline)</option>
                            </select>
                            @error('mode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Batch Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="batch_start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Batch Start Date
                                </label>
                                <input 
                                    type="date" 
                                    name="batch_start_date" 
                                    id="batch_start_date" 
                                    value="{{ old('batch_start_date') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('batch_start_date') border-red-500 @enderror"
                                >
                                @error('batch_start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="batch_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Batch End Date
                                </label>
                                <input 
                                    type="date" 
                                    name="batch_end_date" 
                                    id="batch_end_date" 
                                    value="{{ old('batch_end_date') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('batch_end_date') border-red-500 @enderror"
                                >
                                @error('batch_end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Course Media Files -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                                    Course Thumbnail
                                </label>
                                <input 
                                    type="file" 
                                    name="thumbnail" 
                                    id="thumbnail" 
                                    accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('thumbnail') border-red-500 @enderror"
                                >
                                @error('thumbnail')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Max 2MB</p>
                            </div>

                            <div>
                                <label for="syllabus_pdf" class="block text-sm font-medium text-gray-700 mb-2">
                                    Course Syllabus (PDF)
                                </label>
                                <input 
                                    type="file" 
                                    name="syllabus_pdf" 
                                    id="syllabus_pdf" 
                                    accept="application/pdf"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                <p class="mt-1 text-xs text-gray-500">Upload PDF syllabus</p>
                            </div>
                        </div>

                        <!-- Video File/URL -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">
                                    Course Video File
                                </label>
                                <input 
                                    type="file" 
                                    name="video_file" 
                                    id="video_file" 
                                    accept="video/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                <p class="mt-1 text-xs text-gray-500">Or use video URL instead</p>
                            </div>

                            <div>
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Course Video URL
                                </label>
                                <input 
                                    type="url" 
                                    name="video_url" 
                                    id="video_url" 
                                    value="{{ old('video_url') }}"
                                    placeholder="https://youtube.com/..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Course Price (₹)
                                </label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    value="{{ old('price', '0.00') }}"
                                    min="0"
                                    step="0.01"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Course Type
                                </label>
                                <div class="flex items-center h-10">
                                    <input 
                                        type="checkbox" 
                                        name="is_free" 
                                        id="is_free" 
                                        value="1"
                                        {{ old('is_free') ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    >
                                    <label for="is_free" class="ml-2 text-sm text-gray-700">
                                        This is a free course
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">Important Information</h4>
                                    <p class="mt-1 text-sm text-blue-700">
                                        Your course will be submitted for admin approval. You'll be notified once it's reviewed.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                        <a href="{{ route('instructor.courses.index') ?? route('instructor.dashboard.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        // Auto-disable price field when "Free course" is checked
        document.getElementById('is_free').addEventListener('change', function() {
            const priceField = document.getElementById('price');
            if (this.checked) {
                priceField.value = '0';
                priceField.disabled = true;
                priceField.classList.add('bg-gray-100');
            } else {
                priceField.disabled = false;
                priceField.classList.remove('bg-gray-100');
            }
        });
    </script>
    @endpush
</x-layouts.instructor>
