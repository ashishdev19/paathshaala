<x-layouts.instructor>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Manage Curriculum: {{ $course->title }}
            </h2>
            <a href="{{ route('instructor.courses.edit', $course->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Back to Course Edit
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8">
        <!-- Hidden course ID for JavaScript -->
        <input type="hidden" id="courseId" value="{{ $course->id }}">
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar Info -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 h-fit sticky top-4">
                <h3 class="font-semibold text-blue-900 mb-3">Course Stats</h3>
                <div class="space-y-2 text-sm text-blue-800">
                    <p><strong>Sections:</strong> <span id="sectionCount">{{ $course->sections->count() }}</span></p>
                    <p><strong>Lectures:</strong> <span id="lectureCount">{{ $course->sections->sum(fn($s) => $s->lectures->count()) }}</span></p>
                </div>
                <div class="mt-6 pt-4 border-t border-blue-200">
                    <p class="text-xs text-blue-600 italic">
                        Add sections and lectures to your course. Students will be able to access these as soon as you add them.
                    </p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Add Section Button -->
                <button onclick="addSection()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold mb-6 shadow-sm transition">
                    + Add New Section
                </button>

                <!-- Sections List -->
                <div id="sectionsContainer" class="space-y-4">
                    @forelse($course->sections as $section)
                        <div class="bg-white rounded-lg shadow p-6 section-item border border-gray-100" data-section-id="{{ $section->id }}">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $section->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $section->lectures->count() }} lectures</p>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="editSection({{ $section->id }})" class="p-1 text-blue-600 hover:bg-blue-50 rounded transition" title="Edit Section">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteSection({{ $section->id }})" class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Delete Section">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Lectures -->
                            <div class="space-y-2 ml-4 mb-4">
                                @forelse($section->lectures as $lecture)
                                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200 lecture-item" data-lecture-id="{{ $lecture->id }}">
                                        <div class="flex items-center flex-1">
                                            <div class="mr-3 text-gray-400">
                                                @if($lecture->type == 'video')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @elseif($lecture->type == 'pdf')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-sm text-gray-800">{{ $lecture->title }}</p>
                                                <p class="text-xs text-gray-500 uppercase">{{ $lecture->type }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button onclick="editLecture({{ $lecture->id }})" class="p-1 text-blue-600 hover:bg-blue-100 rounded transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteLecture({{ $lecture->id }})" class="p-1 text-red-600 hover:bg-red-100 rounded transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic py-2">No lectures in this section yet.</p>
                                @endforelse
                            </div>

                            <!-- Add Lecture Button -->
                            <button onclick="addLecture({{ $section->id }})" class="mt-2 inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-bold transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Lecture
                            </button>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow p-12 text-center border-2 border-dashed border-gray-200">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">No sections yet</h3>
                            <p class="text-gray-500 mt-1">Get started by adding your first section.</p>
                            <button onclick="addSection()" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                                Add Section
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modals Container -->
    <div id="modalsContainer"></div>

    <script src="{{ asset('js/curriculum-builder.js') }}"></script>
</x-layouts.instructor>
