<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Course - Step 6: Review & Submit
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto">
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
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">SEO</div>
                    </div>
                    <div class="step-line active flex-1"></div>
                    <div class="step active">
                        <div class="step-circle bg-blue-600 text-white">6</div>
                        <div class="step-label">Review</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-6">
            <!-- Success/Info Box -->
            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                <p class="text-green-900 font-semibold">Almost there! Review your course before submission</p>
                <p class="text-green-800 text-sm mt-1">Your course will be reviewed by our admin team and will be published once approved.</p>
            </div>

            <!-- Basic Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="font-bold text-lg text-gray-900">{{ $course->title }}</h3>
                    <a href="{{ route('instructor.courses.create.basics') }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Category</p>
                        <p class="font-semibold">{{ $course->category }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Level</p>
                        <p class="font-semibold">{{ ucfirst($course->level) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Language</p>
                        <p class="font-semibold">{{ $course->language }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Mode</p>
                        <p class="font-semibold">{{ ucfirst($course->course_mode) }}</p>
                    </div>
                </div>

                <p class="text-gray-700 text-sm">{{ $course->description }}</p>
            </div>

            <!-- Media -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-gray-900">Media</h3>
                    <a href="{{ route('instructor.courses.create.media') }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($course->thumbnail)
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Thumbnail</p>
                            <img src="{{ $course->thumbnail_url }}" alt="Thumbnail" class="w-full h-40 object-cover rounded">
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Promo Video</p>
                        <p class="text-sm">{{ $course->promo_video_url ? '✓ Video URL set' : '✗ No promo video' }}</p>
                    </div>
                </div>
            </div>

            <!-- Curriculum Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-gray-900">Curriculum Summary</h3>
                    <a href="{{ route('instructor.courses.create.curriculum') }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="bg-blue-50 p-4 rounded text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $course->sections->count() }}</p>
                        <p class="text-sm text-gray-600">Sections</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $course->lectures->count() }}</p>
                        <p class="text-sm text-gray-600">Lectures</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded text-center">
                        <p class="text-2xl font-bold text-purple-600">
                            {{ $course->lectures->sum(fn($l) => $l->duration ?? 0) > 0 ? floor($course->lectures->sum(fn($l) => $l->duration ?? 0) / 3600) : 0 }}h
                        </p>
                        <p class="text-sm text-gray-600">Content Duration</p>
                    </div>
                </div>

                @if($course->sections->count() > 0)
                    <div class="space-y-3">
                        @foreach($course->sections as $section)
                            <div class="bg-gray-50 p-3 rounded">
                                <p class="font-semibold text-sm">{{ $section->title }}</p>
                                <p class="text-xs text-gray-600">{{ $section->lectures->count() }} lectures</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-orange-600 font-semibold">⚠️ No sections added yet. Add at least one section with lectures.</p>
                @endif
            </div>

            <!-- Pricing -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-gray-900">Pricing</h3>
                    <a href="{{ route('instructor.courses.create.pricing') }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Type</p>
                        <p class="font-semibold">{{ $course->is_free ? 'Free' : 'Paid' }}</p>
                    </div>
                    @if(!$course->is_free)
                        <div>
                            <p class="text-xs text-gray-500">Price</p>
                            <p class="font-semibold">₹{{ number_format($course->price, 2) }}</p>
                        </div>
                        @if($course->discount_price)
                            <div>
                                <p class="text-xs text-gray-500">Discount Price</p>
                                <p class="font-semibold">₹{{ number_format($course->discount_price, 2) }}</p>
                            </div>
                        @endif
                    @endif
                    <div>
                        <p class="text-xs text-gray-500">Validity</p>
                        <p class="font-semibold">{{ $course->validity_days ? $course->validity_days . ' days' : 'Lifetime' }}</p>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-gray-900">SEO Settings</h3>
                    <a href="{{ route('instructor.courses.create.seo') }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Meta Title</p>
                        <p class="font-semibold text-sm">{{ $course->meta_title ?? '(Not set)' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Meta Description</p>
                        <p class="font-semibold text-sm">{{ $course->meta_description ?? '(Not set)' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">URL Slug</p>
                        <p class="font-semibold text-sm">{{ $course->slug ?? '(Not set)' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms Agreement -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-8">
            <label class="flex items-start">
                <input type="checkbox" id="agreeTerms" class="mt-1" required>
                <span class="ml-3 text-sm text-gray-700">
                    I confirm that this course complies with our <a href="#" class="text-blue-600 hover:underline">course guidelines</a> and 
                    <a href="#" class="text-blue-600 hover:underline">content policy</a>. I understand that the admin team will review 
                    this course and may request changes or reject it if it doesn't meet our standards.
                </span>
            </label>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            <a href="{{ route('instructor.courses.create.seo') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                ← Back
            </a>
            <form action="{{ route('instructor.courses.create.submit-review') }}" method="POST" class="inline">
                @csrf
                <button type="submit" id="submitBtn" disabled class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white px-6 py-3 rounded-lg font-semibold">
                    Submit for Review
                </button>
            </form>
        </div>
    </div>

    <script>
        const agreeCheckbox = document.getElementById('agreeTerms');
        const submitBtn = document.getElementById('submitBtn');

        agreeCheckbox.addEventListener('change', function() {
            submitBtn.disabled = !this.checked;
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
