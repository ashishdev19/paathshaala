<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schedule New Class - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Paathshaala</h1>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('online-classes.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Back to Classes
                    </a>
                    <div class="text-sm text-gray-600">
                        Welcome, {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Schedule New Online Class</h1>
                <p class="text-gray-600 mt-2">Create a live session or upload recorded content for your students</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('online-classes.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Basic Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Options -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Course <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="space-y-4">
                                <!-- Option to select existing course -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="course_option" value="existing" 
                                               {{ old('course_option', 'new') === 'existing' ? 'checked' : '' }}
                                               class="text-indigo-600 focus:ring-indigo-500" onchange="toggleCourseOption()">
                                        <span class="ml-2 text-sm text-gray-700">Select existing course</span>
                                    </label>
                                    
                                    <div id="existingCourseSelect" class="mt-2 {{ old('course_option', 'new') === 'existing' ? '' : 'hidden' }}">
                                        <select name="course_id" id="course_id"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Select a course</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                    {{ $course->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Option to create new course -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="course_option" value="new" 
                                               {{ old('course_option', 'new') === 'new' ? 'checked' : '' }}
                                               class="text-indigo-600 focus:ring-indigo-500" onchange="toggleCourseOption()">
                                        <span class="ml-2 text-sm text-gray-700">Create new course</span>
                                    </label>
                                    
                                    <div id="newCourseFields" class="mt-3 space-y-4 {{ old('course_option', 'new') === 'new' ? '' : 'hidden' }}">
                                        <div>
                                            <label for="course_title" class="block text-sm font-medium text-gray-700 mb-1">
                                                Course Title <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="course_title" id="course_title" value="{{ old('course_title') }}"
                                                   placeholder="e.g., Complete Web Development with React"
                                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        
                                        <div>
                                            <label for="course_description" class="block text-sm font-medium text-gray-700 mb-1">
                                                Course Description
                                            </label>
                                            <textarea name="course_description" id="course_description" rows="3" 
                                                      placeholder="Brief description of what this course covers..."
                                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('course_description') }}</textarea>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="course_category" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Category
                                                </label>
                                                <select name="course_category" id="course_category"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option value="">Select category</option>
                                                    <option value="programming" {{ old('course_category') == 'programming' ? 'selected' : '' }}>Medical</option>
                                                    <!-- <option value="design" {{ old('course_category') == 'design' ? 'selected' : '' }}>Design</option>
                                                    <option value="business" {{ old('course_category') == 'business' ? 'selected' : '' }}>Business</option>
                                                    <option value="marketing" {{ old('course_category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                                    <option value="data-science" {{ old('course_category') == 'data-science' ? 'selected' : '' }}>Data Science</option>
                                                    <option value="language" {{ old('course_category') == 'language' ? 'selected' : '' }}>Language</option>
                                                    <option value="music" {{ old('course_category') == 'music' ? 'selected' : '' }}>Music</option>
                                                    <option value="other" {{ old('course_category') == 'other' ? 'selected' : '' }}>Other</option> -->
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label for="course_level" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Level
                                                </label>
                                                <select name="course_level" id="course_level"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option value="">Select level</option>
                                                    <option value="beginner" {{ old('course_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                                    <option value="intermediate" {{ old('course_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                    <option value="advanced" {{ old('course_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="course_price" class="block text-sm font-medium text-gray-700 mb-1">
                                                Price (₹)
                                            </label>
                                            <input type="number" name="course_price" id="course_price" value="{{ old('course_price', '0') }}" 
                                                   min="0" step="0.01"
                                                   placeholder="0.00"
                                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <p class="text-sm text-gray-500 mt-1">Set to 0 for free course</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @error('course_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('course_title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Class Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Class Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   placeholder="e.g., Introduction to React Components"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Class Type -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Class Type <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="live" 
                                           {{ old('type', 'live') === 'live' ? 'checked' : '' }}
                                           class="text-indigo-600 focus:ring-indigo-500" onchange="toggleClassType()">
                                    <span class="ml-2 text-sm text-gray-700">Live Class</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="recorded" 
                                           {{ old('type') === 'recorded' ? 'checked' : '' }}
                                           class="text-indigo-600 focus:ring-indigo-500" onchange="toggleClassType()">
                                    <span class="ml-2 text-sm text-gray-700">Recorded Class</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Scheduled Date & Time -->
                        <div>
                            <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="scheduled_date" id="scheduled_date" 
                                   value="{{ old('scheduled_date', now()->addDay()->format('Y-m-d')) }}" required
                                   min="{{ now()->format('Y-m-d') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('scheduled_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="scheduled_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="scheduled_time" id="scheduled_time" 
                                   value="{{ old('scheduled_time', '10:00') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('scheduled_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="md:col-span-2">
                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                                Duration (minutes) <span class="text-red-500">*</span>
                            </label>
                            <select name="duration_minutes" id="duration_minutes" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="30" {{ old('duration_minutes') == '30' ? 'selected' : '' }}>30 minutes</option>
                                <option value="45" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                                <option value="60" {{ old('duration_minutes', '60') == '60' ? 'selected' : '' }}>1 hour</option>
                                <option value="90" {{ old('duration_minutes') == '90' ? 'selected' : '' }}>1.5 hours</option>
                                <option value="120" {{ old('duration_minutes') == '120' ? 'selected' : '' }}>2 hours</option>
                                <option value="180" {{ old('duration_minutes') == '180' ? 'selected' : '' }}>3 hours</option>
                            </select>
                            @error('duration_minutes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="4" placeholder="Describe what will be covered in this class..."
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Live Class Settings -->
                <div id="liveClassSettings" class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Live Class Settings</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Meeting Link -->
                        <div class="md:col-span-2">
                            <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting Link
                            </label>
                            <input type="url" name="meeting_link" id="meeting_link" value="{{ old('meeting_link') }}"
                                   placeholder="https://zoom.us/j/123456789 or https://meet.google.com/abc-def-ghi"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">
                                Provide direct link to Zoom, Google Meet, or other platform
                            </p>
                            @error('meeting_link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meeting ID -->
                        <div>
                            <label for="meeting_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting ID
                            </label>
                            <input type="text" name="meeting_id" id="meeting_id" value="{{ old('meeting_id') }}"
                                   placeholder="123-456-789"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">
                                Auto-generated if not provided
                            </p>
                            @error('meeting_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meeting Password -->
                        <div>
                            <label for="meeting_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting Password
                            </label>
                            <input type="text" name="meeting_password" id="meeting_password" value="{{ old('meeting_password') }}"
                                   placeholder="Enter password"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">
                                Auto-generated if not provided
                            </p>
                            @error('meeting_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Recorded Class Settings -->
                <div id="recordedClassSettings" class="bg-white rounded-lg shadow p-6 hidden">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Recorded Class Content</h2>
                    
                    <div class="space-y-6">
                        <!-- Video Upload Option -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Video Content
                            </label>
                            <div class="space-y-4">
                                <!-- File Upload -->
                                <div>
                                    <label for="video_file" class="block text-sm text-gray-600 mb-2">
                                        Upload Video File
                                    </label>
                                    <input type="file" name="video_file" id="video_file" 
                                           accept="video/mp4,video/avi,video/mov,video/wmv"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <p class="text-sm text-gray-500 mt-1">
                                        Max file size: 1GB. Supported formats: MP4, AVI, MOV, WMV
                                    </p>
                                </div>

                                <!-- OR Divider -->
                                <div class="flex items-center">
                                    <div class="flex-1 border-t border-gray-300"></div>
                                    <span class="px-3 text-sm text-gray-500">OR</span>
                                    <div class="flex-1 border-t border-gray-300"></div>
                                </div>

                                <!-- URL Input -->
                                <div>
                                    <label for="video_url" class="block text-sm text-gray-600 mb-2">
                                        Video URL
                                    </label>
                                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                                           placeholder="https://youtube.com/watch?v=... or https://vimeo.com/..."
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <p class="text-sm text-gray-500 mt-1">
                                        Supports YouTube, Vimeo, or direct video URLs
                                    </p>
                                </div>
                            </div>
                            @error('video_file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('video_url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('online-classes.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                        Schedule Class
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleClassType() {
            const liveSettings = document.getElementById('liveClassSettings');
            const recordedSettings = document.getElementById('recordedClassSettings');
            const liveRadio = document.querySelector('input[name="type"][value="live"]');
            
            if (liveRadio.checked) {
                liveSettings.classList.remove('hidden');
                recordedSettings.classList.add('hidden');
            } else {
                liveSettings.classList.add('hidden');
                recordedSettings.classList.remove('hidden');
            }
        }

        function toggleCourseOption() {
            const existingRadio = document.querySelector('input[name="course_option"][value="existing"]');
            const newRadio = document.querySelector('input[name="course_option"][value="new"]');
            const existingSelect = document.getElementById('existingCourseSelect');
            const newFields = document.getElementById('newCourseFields');
            const courseSelect = document.getElementById('course_id');
            const courseTitleInput = document.getElementById('course_title');
            
            if (existingRadio.checked) {
                existingSelect.classList.remove('hidden');
                newFields.classList.add('hidden');
                courseSelect.required = true;
                courseTitleInput.required = false;
            } else {
                existingSelect.classList.add('hidden');
                newFields.classList.remove('hidden');
                courseSelect.required = false;
                courseTitleInput.required = true;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleClassType();
            toggleCourseOption();
            
            // Combine date and time for scheduled_at field
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const date = document.getElementById('scheduled_date').value;
                const time = document.getElementById('scheduled_time').value;
                
                if (date && time) {
                    const scheduledAt = date + 'T' + time;
                    
                    // Create hidden input for scheduled_at
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'scheduled_at';
                    hiddenInput.value = scheduledAt;
                    
                    form.appendChild(hiddenInput);
                }
            });

            // File upload preview
            const fileInput = document.getElementById('video_file');
            const urlInput = document.getElementById('video_url');
            
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    urlInput.value = '';
                    urlInput.disabled = true;
                    
                    // Show file info
                    const file = this.files[0];
                    const size = (file.size / (1024 * 1024)).toFixed(2);
                    console.log(`Selected file: ${file.name} (${size} MB)`);
                } else {
                    urlInput.disabled = false;
                }
            });
            
            urlInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    fileInput.disabled = true;
                } else {
                    fileInput.disabled = false;
                }
            });
        });
    </script>
</body>
</html>