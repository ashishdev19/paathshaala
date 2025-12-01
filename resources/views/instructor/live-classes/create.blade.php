<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Schedule New Live Class
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Class Details</h3>
                <p class="text-sm text-gray-600 mt-1">Fill in the details to schedule a new live class</p>
            </div>

            <form action="{{ route('instructor.live-classes.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <!-- Course Selection -->
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Course (Optional)
                    </label>
                    <select name="course_id" id="course_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">-- General Session --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Topic -->
                <div>
                    <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                        Topic <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="topic" id="topic" value="{{ old('topic') }}" required
                           placeholder="e.g., Introduction to Laravel"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('topic')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4" 
                              placeholder="Provide details about what will be covered in this class..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mode -->
                <div>
                    <label for="mode" class="block text-sm font-medium text-gray-700 mb-2">
                        Class Mode <span class="text-red-500">*</span>
                    </label>
                    <select name="mode" id="mode" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="online" {{ old('mode') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('mode') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="hybrid" {{ old('mode') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('mode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}" required
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                            Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="time" id="time" value="{{ old('time') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                        Duration (minutes) <span class="text-red-500">*</span>
                    </label>
                    <select name="duration" id="duration" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="30" {{ old('duration') == '30' ? 'selected' : '' }}>30 minutes</option>
                        <option value="45" {{ old('duration') == '45' ? 'selected' : '' }}>45 minutes</option>
                        <option value="60" {{ old('duration') == '60' ? 'selected' : '' }}>1 hour</option>
                        <option value="90" {{ old('duration') == '90' ? 'selected' : '' }}>1.5 hours</option>
                        <option value="120" {{ old('duration') == '120' ? 'selected' : '' }}>2 hours</option>
                        <option value="180" {{ old('duration') == '180' ? 'selected' : '' }}>3 hours</option>
                    </select>
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Participant Permissions
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="allow_chat" id="allow_chat" value="1" 
                                   {{ old('allow_chat', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="allow_chat" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Allow Chat</span>
                                <span class="text-gray-500 ml-2">- Participants can send messages</span>
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="allow_mic" id="allow_mic" value="1"
                                   {{ old('allow_mic', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="allow_mic" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Allow Microphone</span>
                                <span class="text-gray-500 ml-2">- Participants can unmute themselves</span>
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="allow_video" id="allow_video" value="1"
                                   {{ old('allow_video', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="allow_video" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Allow Video</span>
                                <span class="text-gray-500 ml-2">- Participants can turn on camera</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('instructor.live-classes.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Schedule Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.instructor>
