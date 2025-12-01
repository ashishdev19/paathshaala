<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Course - Step 5: SEO Settings
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="flex items-center w-full">
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Basics</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Media</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Curriculum</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Pricing</div>
                    </div>
                    <div class="step-line active flex-1"></div>
                    <div class="step active">
                        <div class="step-circle bg-blue-600 text-white">5</div>
                        <div class="step-label">SEO</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-gray-300">6</div>
                        <div class="step-label">Review</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('instructor.courses.create.store-seo') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            @csrf

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-900 font-semibold">Improve your course visibility</p>
                <p class="text-blue-800 text-sm mt-1">These SEO settings help students find your course in search engines and marketplace</p>
            </div>

            <!-- Meta Title -->
            <div>
                <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">
                    Meta Title (for Search Engines)
                </label>
                <div class="relative">
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $course->meta_title) }}"
                           placeholder="e.g., Advanced Medical Anatomy Course Online | Certificate"
                           maxlength="160"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute right-3 top-3 text-xs text-gray-500">
                        <span id="titleCount">{{ strlen($course->meta_title ?? '') }}</span>/160
                    </div>
                </div>
                @error('meta_title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-600">This appears as the page title in search results (ideal length: 50-60 characters)</p>
            </div>

            <!-- Meta Description -->
            <div>
                <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Meta Description (for Search Engines)
                </label>
                <div class="relative">
                    <textarea id="meta_description" name="meta_description" rows="3"
                              placeholder="A compelling description of your course that appears in search results..."
                              maxlength="160"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('meta_description', $course->meta_description) }}</textarea>
                    <div class="absolute right-3 bottom-3 text-xs text-gray-500">
                        <span id="descCount">{{ strlen($course->meta_description ?? '') }}</span>/160
                    </div>
                </div>
                @error('meta_description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-600">This snippet appears under the title in search results (ideal length: 150-160 characters)</p>
            </div>

            <!-- Course Slug -->
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                    Course URL Slug
                </label>
                <div class="flex items-center">
                    <span class="text-gray-600 px-3">{{ config('app.url') }}/courses/</span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $course->slug) }}"
                           placeholder="course-title-slug"
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-600">Use hyphens to separate words (e.g., advanced-medical-anatomy)</p>
            </div>

            <!-- SEO Preview -->
            <div class="border-t pt-6">
                <h3 class="font-semibold text-gray-700 mb-4">Search Result Preview</h3>
                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                    <div class="text-blue-600 text-base font-semibold mb-1">
                        <span id="previewTitle">{{ $course->meta_title ?? $course->title ?? 'Your Course Title' }}</span>
                    </div>
                    <div class="text-gray-500 text-sm mb-2">
                        {{ config('app.url') }}/courses/<span id="previewSlug">{{ $course->slug ?? 'course-slug' }}</span>
                    </div>
                    <div class="text-gray-700 text-sm">
                        <span id="previewDesc">{{ $course->meta_description ?? 'Your course description will appear here...' }}</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('instructor.courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                    ← Back
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Next: Review & Submit →
                </button>
            </div>
        </form>
    </div>

    <script>
        const titleInput = document.getElementById('meta_title');
        const descInput = document.getElementById('meta_description');
        const slugInput = document.getElementById('slug');

        // Update title preview
        titleInput.addEventListener('input', function() {
            document.getElementById('titleCount').textContent = this.value.length;
            document.getElementById('previewTitle').textContent = this.value || 'Your Course Title';
        });

        // Update description preview
        descInput.addEventListener('input', function() {
            document.getElementById('descCount').textContent = this.value.length;
            document.getElementById('previewDesc').textContent = this.value || 'Your course description will appear here...';
        });

        // Update slug preview
        slugInput.addEventListener('input', function() {
            document.getElementById('previewSlug').textContent = this.value || 'course-slug';
        });

        // Auto-generate slug from title
        titleInput.addEventListener('blur', function() {
            if (!slugInput.value) {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w-]/g, '')
                    .replace(/-+/g, '-');
                slugInput.value = slug;
                document.getElementById('previewSlug').textContent = slug;
            }
        });
    </script>

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

        .step-line.active {
            background-color: #2563eb;
        }

        .step.active .step-circle {
            background-color: #2563eb;
            color: white;
        }
    </style>
</x-layouts.instructor>
