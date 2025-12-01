<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Course - Step 1: Basic Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="flex items-center w-full">
                    <div class="step active">
                        <div class="step-circle bg-blue-600 text-white">1</div>
                        <div class="step-label">Basics</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-gray-300">2</div>
                        <div class="step-label">Media</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-gray-300">3</div>
                        <div class="step-label">Curriculum</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-gray-300">4</div>
                        <div class="step-label">Pricing</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('instructor.courses.create.store-basics') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
            @csrf

            <div class="space-y-6">
                <!-- Course Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" 
                           placeholder="Enter a catchy course title"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Subtitle -->
                <div>
                    <label for="subtitle" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Subtitle
                    </label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" 
                           placeholder="Brief subtitle describing the course"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('subtitle')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5"
                              placeholder="Detailed description of what students will learn"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category & Level -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}" 
                               placeholder="e.g., Medical, Engineering, Web Development"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">
                            Level <span class="text-red-500">*</span>
                        </label>
                        <select id="level" name="level" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('level') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('level')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Language & Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="language" class="block text-sm font-semibold text-gray-700 mb-2">
                            Language <span class="text-red-500">*</span>
                        </label>
                        <select id="language" name="language" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Language</option>
                            <option value="English" {{ old('language') === 'English' ? 'selected' : '' }}>English</option>
                            <option value="Hindi" {{ old('language') === 'Hindi' ? 'selected' : '' }}>Hindi</option>
                            <option value="Marathi" {{ old('language') === 'Marathi' ? 'selected' : '' }}>Marathi</option>
                            <option value="Gujarati" {{ old('language') === 'Gujarati' ? 'selected' : '' }}>Gujarati</option>
                        </select>
                        @error('language')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="course_mode" class="block text-sm font-semibold text-gray-700 mb-2">
                            Course Mode <span class="text-red-500">*</span>
                        </label>
                        <select id="course_mode" name="course_mode" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Mode</option>
                            <option value="online" {{ old('course_mode') === 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ old('course_mode') === 'offline' ? 'selected' : '' }}>Offline</option>
                            <option value="hybrid" {{ old('course_mode') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('course_mode')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('instructor.courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Next: Upload Media →
                </button>
            </div>
        </form>
    </div>

    <style>
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .step-label {
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }

        .step-line {
            height: 2px;
            background-color: #e5e7eb;
            margin: 0 8px;
            margin-top: 20px;
        }

        .step.active .step-line {
            background-color: #2563eb;
        }
    </style>
</x-layouts.instructor>
