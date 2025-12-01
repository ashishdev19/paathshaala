<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Reschedule Live Class
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('instructor.live-classes.update-reschedule', $liveClass->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <a href="{{ route('instructor.live-classes.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                        ← Back to Live Classes
                    </a>
                </div>

                <!-- Current Schedule Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-900 mb-2">Current Schedule</h4>
                    <p class="text-gray-700">
                        <span class="font-semibold">Date & Time:</span> 
                        {{ $liveClass->start_datetime->format('M d, Y - h:i A') }}
                    </p>
                    <p class="text-gray-700 mt-1">
                        <span class="font-semibold">Topic:</span> 
                        {{ $liveClass->topic }}
                    </p>
                </div>

                <!-- New Date -->
                <div class="mb-6">
                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                        New Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date" name="date" required 
                        value="{{ old('date', $liveClass->start_datetime->format('Y-m-d')) }}"
                        class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Time -->
                <div class="mb-6">
                    <label for="time" class="block text-sm font-semibold text-gray-700 mb-2">
                        New Time <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="time" name="time" required 
                        value="{{ old('time', $liveClass->start_datetime->format('H:i')) }}"
                        class="w-full border border-indigo-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Message -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-amber-800">
                        <strong>Note:</strong> All enrolled students will be notified about the new schedule.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end pt-6 border-t border-gray-200">
                    <a href="{{ route('instructor.live-classes.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold">
                        Reschedule Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.instructor>
