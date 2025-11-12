@extends('layouts.admin')

@section('title', 'Create Online Class')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Create Online Class</h1>
                <a href="{{ route('admin.online-classes.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Classes
                </a>
            </div>

            <form action="{{ route('admin.online-classes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Course Creation -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Course</h3>
                    
                    <!-- Hidden field to always set course_option to 'new' -->
                    <input type="hidden" name="course_option" value="new">
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="course_title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Course Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="course_title" id="course_title" value="{{ old('course_title') }}"
                                       placeholder="e.g., Advanced Medical Surgery Techniques"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Assign Teacher <span class="text-red-500">*</span>
                                </label>
                                <select name="teacher_id" id="teacher_id"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Select teacher</option>
                                    @foreach(App\Models\User::whereHas('roles', function($q) { $q->where('name', 'teacher'); })->get() as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="course_description" class="block text-sm font-medium text-gray-700 mb-1">
                                Course Description
                            </label>
                            <textarea name="course_description" id="course_description" rows="3" 
                                      placeholder="Brief description of what this course covers..."
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('course_description') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="course_category" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category
                                </label>
                                <select name="course_category" id="course_category"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select category</option>
                                    <option value="medical" {{ old('course_category') == 'medical' ? 'selected' : '' }}>Medical</option>
                                    <option value="surgery" {{ old('course_category') == 'surgery' ? 'selected' : '' }}>Surgery</option>
                                    <option value="cardiology" {{ old('course_category') == 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                                    <option value="neurology" {{ old('course_category') == 'neurology' ? 'selected' : '' }}>Neurology</option>
                                    <option value="pediatrics" {{ old('course_category') == 'pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                    <option value="orthopedics" {{ old('course_category') == 'orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                    <option value="other" {{ old('course_category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="course_level" class="block text-sm font-medium text-gray-700 mb-1">
                                    Level
                                </label>
                                <select name="course_level" id="course_level"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select level</option>
                                    <option value="beginner" {{ old('course_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('course_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('course_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="course_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Price (₹)
                                </label>
                                <input type="number" name="course_price" id="course_price" value="{{ old('course_price', '0') }}" 
                                       min="0" step="0.01"
                                       placeholder="0.00"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    
                    @error('course_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('teacher_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Class Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter class title" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Class Type <span class="text-red-500">*</span>
                        </label>
                        <select id="type" name="type"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">Select type</option>
                            <option value="live" {{ old('type') === 'live' ? 'selected' : '' }}>Live Class</option>
                            <option value="recorded" {{ old('type') === 'recorded' ? 'selected' : '' }}>Recorded Class</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Enter class description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Schedule -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Scheduled Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('scheduled_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                            Duration (minutes) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', 60) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               min="15" max="480" required>
                        @error('duration_minutes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Live Class Fields -->
                <div id="live-fields" class="hidden space-y-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Live Class Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting Link
                            </label>
                            <input type="url" id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://zoom.us/...">
                            @error('meeting_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meeting_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting ID
                            </label>
                            <input type="text" id="meeting_id" name="meeting_id" value="{{ old('meeting_id') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Auto-generated if empty">
                            @error('meeting_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="meeting_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Meeting Password
                        </label>
                        <input type="text" id="meeting_password" name="meeting_password" value="{{ old('meeting_password') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Auto-generated if empty">
                        @error('meeting_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Recorded Class Fields -->
                <div id="recorded-fields" class="hidden space-y-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Recorded Class Settings</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Video Source
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="video_source" value="upload" class="mr-2" checked>
                                    <span>Upload Video File</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="video_source" value="url" class="mr-2">
                                    <span>Video URL</span>
                                </label>
                            </div>
                        </div>

                        <div id="upload-section">
                            <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Video File
                            </label>
                            <input type="file" id="video_file" name="video_file"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   accept=".mp4,.avi,.mov,.wmv">
                            <p class="mt-1 text-sm text-gray-500">Supported formats: MP4, AVI, MOV, WMV. Max size: 1GB</p>
                            @error('video_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="url-section" class="hidden">
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Video URL
                            </label>
                            <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://example.com/video.mp4">
                            @error('video_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.online-classes.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        <i class="fas fa-save mr-2"></i>Create Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const liveFields = document.getElementById('live-fields');
    const recordedFields = document.getElementById('recorded-fields');
    const videoSourceRadios = document.querySelectorAll('input[name="video_source"]');
    const uploadSection = document.getElementById('upload-section');
    const urlSection = document.getElementById('url-section');

    function toggleFields() {
        const selectedType = typeSelect.value;

        if (selectedType === 'live') {
            liveFields.classList.remove('hidden');
            recordedFields.classList.add('hidden');
        } else if (selectedType === 'recorded') {
            liveFields.classList.add('hidden');
            recordedFields.classList.remove('hidden');
        } else {
            liveFields.classList.add('hidden');
            recordedFields.classList.add('hidden');
        }
    }

    function toggleVideoSource() {
        const selectedSource = document.querySelector('input[name="video_source"]:checked');
        if (selectedSource) {
            const value = selectedSource.value;
            if (value === 'upload') {
                uploadSection.classList.remove('hidden');
                urlSection.classList.add('hidden');
            } else {
                uploadSection.classList.add('hidden');
                urlSection.classList.remove('hidden');
            }
        }
    }

    typeSelect.addEventListener('change', toggleFields);
    videoSourceRadios.forEach(radio => radio.addEventListener('change', toggleVideoSource));

    // Initialize
    toggleFields();
    toggleVideoSource();
});
</script>
@endsection