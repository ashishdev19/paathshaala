<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Course - Step 2: Upload Media
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
                    <div class="step-line active flex-1"></div>
                    <div class="step active">
                        <div class="step-circle bg-blue-600 text-white">2</div>
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
        <form action="{{ route('instructor.courses.create.store-media') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            @csrf

            <!-- Course Thumbnail -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8">
                <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-4">
                    Course Thumbnail <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center justify-center">
                    <div class="text-center" id="thumbnailArea">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V16a4 4 0 00-4-4h-8l-4-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Drag image here or click to select</p>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                    <!-- Progress Loader -->
                    <div id="thumbnailProgress" class="hidden">
                        <div class="relative w-24 h-24">
                            <svg class="transform -rotate-90 w-24 h-24">
                                <circle cx="48" cy="48" r="40" stroke="#e5e7eb" stroke-width="8" fill="none" />
                                <circle id="thumbnailProgressCircle" cx="48" cy="48" r="40" stroke="#3b82f6" stroke-width="8" fill="none"
                                        stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="thumbnailProgressText" class="text-lg font-bold text-blue-600">0%</span>
                            </div>
                        </div>
                        <p id="thumbnailStatusText" class="mt-2 text-sm text-gray-600">Uploading...</p>
                    </div>
                </div>
                <input type="file" id="thumbnail" name="thumbnail" class="hidden" accept="image/*">
                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Promo Video URL -->
            <div>
                <label for="promo_video_url" class="block text-sm font-semibold text-gray-700 mb-2">
                    Promo Video URL (YouTube/Vimeo)
                </label>
                <input type="url" id="promo_video_url" name="promo_video_url" value="{{ old('promo_video_url') }}"
                       placeholder="https://youtube.com/watch?v=..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('promo_video_url')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Link to a promotional video showcasing your course</p>
            </div>

            <!-- Demo PDF -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8">
                <label for="demo_pdf" class="block text-sm font-semibold text-gray-700 mb-4">
                    Sample PDF/Material
                </label>
                <div class="flex items-center justify-center">
                    <div class="text-center" id="pdfArea">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Upload PDF or course material</p>
                        <p class="text-xs text-gray-500">PDF up to 5MB</p>
                    </div>
                    <!-- Progress Loader -->
                    <div id="pdfProgress" class="hidden">
                        <div class="relative w-24 h-24">
                            <svg class="transform -rotate-90 w-24 h-24">
                                <circle cx="48" cy="48" r="40" stroke="#e5e7eb" stroke-width="8" fill="none" />
                                <circle id="pdfProgressCircle" cx="48" cy="48" r="40" stroke="#3b82f6" stroke-width="8" fill="none"
                                        stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="pdfProgressText" class="text-lg font-bold text-blue-600">0%</span>
                            </div>
                        </div>
                        <p id="pdfStatusText" class="mt-2 text-sm text-gray-600">Uploading...</p>
                    </div>
                </div>
                <input type="file" id="demo_pdf" name="demo_pdf" class="hidden" accept=".pdf">
                @error('demo_pdf')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Demo Lecture -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8">
                <label for="demo_lecture" class="block text-sm font-semibold text-gray-700 mb-4">
                    Demo Lecture/Video
                </label>
                <div class="flex items-center justify-center">
                    <div class="text-center" id="videoArea">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Upload a sample lecture video</p>
                        <p class="text-xs text-gray-500">MP4, AVI, MOV up to 50MB</p>
                    </div>
                    <!-- Progress Loader -->
                    <div id="videoProgress" class="hidden">
                        <div class="relative w-24 h-24">
                            <svg class="transform -rotate-90 w-24 h-24">
                                <circle cx="48" cy="48" r="40" stroke="#e5e7eb" stroke-width="8" fill="none" />
                                <circle id="videoProgressCircle" cx="48" cy="48" r="40" stroke="#3b82f6" stroke-width="8" fill="none"
                                        stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="videoProgressText" class="text-lg font-bold text-blue-600">0%</span>
                            </div>
                        </div>
                        <p id="videoStatusText" class="mt-2 text-sm text-gray-600">Uploading...</p>
                    </div>
                </div>
                <input type="file" id="demo_lecture" name="demo_lecture" class="hidden" accept="video/*">
                @error('demo_lecture')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('instructor.courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                    ← Back
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Next: Build Curriculum →
                </button>
            </div>
        </form>
    </div>

    <script>
        // File upload drag and drop
        const setupDropZone = (dropZoneSelector, inputSelector) => {
            const dropZone = document.querySelector(dropZoneSelector);
            const input = document.querySelector(inputSelector);

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('bg-blue-50', 'border-blue-400');
            }

            function unhighlight(e) {
                dropZone.classList.remove('bg-blue-50', 'border-blue-400');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;
                unhighlight(e);
            }

            dropZone.addEventListener('click', () => input.click());
        };

        setupDropZone('#thumbnailArea', '#thumbnail');
        setupDropZone('#pdfArea', '#demo_pdf');
        setupDropZone('#videoArea', '#demo_lecture');

        // Show progress when file is selected
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                showProgress('thumbnail', this.files[0]);
            }
        });

        document.getElementById('demo_pdf').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                showProgress('pdf', this.files[0]);
            }
        });

        document.getElementById('demo_lecture').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                showProgress('video', this.files[0]);
            }
        });

        function showProgress(type, file) {
            const area = document.getElementById(type + 'Area');
            const progress = document.getElementById(type + 'Progress');
            const progressCircle = document.getElementById(type + 'ProgressCircle');
            const progressText = document.getElementById(type + 'ProgressText');
            const statusText = document.getElementById(type + 'StatusText');
            
            area.classList.add('hidden');
            progress.classList.remove('hidden');
            
            // Simulate upload progress
            let percent = 0;
            const circumference = 251.2;
            
            const interval = setInterval(() => {
                percent += Math.random() * 15;
                if (percent >= 100) {
                    percent = 100;
                    clearInterval(interval);
                    
                    // Show success message
                    setTimeout(() => {
                        progressText.textContent = '✓';
                        progressText.classList.remove('text-blue-600');
                        progressText.classList.add('text-green-600', 'text-3xl');
                        progressCircle.setAttribute('stroke', '#10b981');
                        statusText.textContent = 'Uploaded';
                        statusText.classList.remove('text-gray-600');
                        statusText.classList.add('text-green-600', 'font-semibold');
                    }, 200);
                }
                
                const offset = circumference - (percent / 100) * circumference;
                progressCircle.style.strokeDashoffset = offset;
                progressText.textContent = Math.round(percent) + '%';
            }, 200);
        }
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
