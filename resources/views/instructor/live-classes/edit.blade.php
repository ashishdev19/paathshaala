<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Edit Live Class
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('instructor.live-classes.update', $liveClass->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <a href="{{ route('instructor.live-classes.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                        ← Back to Live Classes
                    </a>
                </div>

                <!-- Course Selection -->
                <div class="mb-6">
                    <label for="course_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course <span class="text-red-500">*</span>
                    </label>
                    <select id="course_id" name="course_id" required class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $liveClass->course_id === $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Topic -->
                <div class="mb-6">
                    <label for="topic" class="block text-sm font-semibold text-gray-700 mb-2">
                        Topic <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="topic" name="topic" value="{{ old('topic', $liveClass->topic) }}" required 
                        class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter class topic">
                    @error('topic')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter class description">{{ old('description', $liveClass->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mode Selection -->
                <div class="mb-6">
                    <label for="mode" class="block text-sm font-semibold text-gray-700 mb-2">
                        Mode <span class="text-red-500">*</span>
                    </label>
                    <select id="mode" name="mode" required class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="online" {{ $liveClass->mode === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ $liveClass->mode === 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="hybrid" {{ $liveClass->mode === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('mode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration -->
                <div class="mb-6">
                    <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">
                        Duration (minutes) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="duration" name="duration" value="{{ old('duration', $liveClass->duration) }}" required min="15"
                        class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter duration in minutes">
                    @error('duration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end pt-6 border-t border-gray-200">
                    <a href="{{ route('instructor.live-classes.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">
                        Update Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.instructor>
