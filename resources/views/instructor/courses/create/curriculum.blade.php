<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Course - Step 3: Build Curriculum
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <!-- Hidden course ID for JavaScript -->
        <input type="hidden" id="courseId" value="{{ session('course_id') }}">
        
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
                    <div class="step-line active flex-1"></div>
                    <div class="step active">
                        <div class="step-circle bg-blue-600 text-white">3</div>
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

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar Info -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <h3 class="font-semibold text-blue-900 mb-3">Course: {{ $course->title }}</h3>
                <div class="space-y-2 text-sm text-blue-800">
                    <p><strong>Sections:</strong> <span id="sectionCount">{{ $course->sections->count() }}</span></p>
                    <p><strong>Lectures:</strong> <span id="lectureCount">{{ $course->lectures->count() }}</span></p>
                    <p><strong>Total Duration:</strong> <span id="totalDuration">0h 0m</span></p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Add Section Button -->
                <button onclick="addSection()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold mb-6">
                    + Add Section
                </button>

                <!-- Sections List -->
                <div id="sectionsContainer" class="space-y-4">
                    @forelse($course->sections as $section)
                        <div class="bg-white rounded-lg shadow p-6 section-item" data-section-id="{{ $section->id }}">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-lg">{{ $section->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $section->lectures->count() }} lectures</p>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="editSection({{ $section->id }})" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteSection({{ $section->id }})" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Lectures -->
                            <div class="space-y-2 ml-4 mb-4">
                                @forelse($section->lectures as $lecture)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded lecture-item" data-lecture-id="{{ $lecture->id }}">
                                        <div class="flex items-center flex-1">
                                            <svg class="w-4 h-4 mr-2 text-gray-400 drag-handle" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z"></path>
                                            </svg>
                                            <div>
                                                <p class="font-semibold text-sm">{{ $lecture->title }}</p>
                                                <p class="text-xs text-gray-500">{{ ucfirst($lecture->type) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button onclick="editLecture({{ $lecture->id }})" class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteLecture({{ $lecture->id }})" class="text-red-600 hover:text-red-800">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic">No lectures yet</p>
                                @endforelse
                            </div>

                            <!-- Add Lecture Button -->
                            <button onclick="addLecture({{ $section->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                + Add Lecture
                            </button>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <p class="text-gray-500">No sections added yet. Click "Add Section" to get started!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            <a href="{{ route('instructor.courses.create.media') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                ← Back to Media
            </a>
            <a href="{{ route('instructor.courses.create.pricing') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                Next: Set Pricing →
            </a>
        </div>
    </div>

    <!-- Modals will be added here -->
    <div id="modalsContainer"></div>

    <script src="{{ asset('js/curriculum-builder.js') }}"></script>

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
