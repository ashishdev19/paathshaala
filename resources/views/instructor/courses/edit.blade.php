<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Edit Course</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" value="{{ $course->title ?? '' }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2" rows="4">{{ $course->description ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" value="{{ $course->category ?? '' }}" placeholder="e.g., Science, Technology, Arts" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Course Image (thumbnail)</label>
                    @if($course->thumbnail)
                        <p class="text-xs text-gray-500 mb-2">Current: {{ basename($course->thumbnail) }}</p>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Course PDF (syllabus)</label>
                    @if($course->syllabus && isset($course->syllabus['pdf']))
                        <p class="text-xs text-gray-500 mb-2">Current: {{ basename($course->syllabus['pdf']) }}</p>
                    @endif
                    <input type="file" name="syllabus_pdf" accept="application/pdf" class="mt-1 block w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Course Video File (up to 1GB)</label>
                    @if($course->video_file)
                        <p class="text-xs text-gray-500 mb-2">Current: {{ basename($course->video_file) }}</p>
                    @endif
                    <input type="file" name="video_file" accept="video/*" class="mt-1 block w-full">
                    <p class="text-xs text-gray-500 mt-1">You can also provide a Video URL below instead of uploading a file.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Course Video URL</label>
                    <input type="url" name="video_url" value="{{ $course->video_url ?? '' }}" placeholder="https://" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (INR)</label>
                    <input type="number" step="0.01" name="price" value="{{ $course->price ?? '0.00' }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        <option value="draft" @if(($course->status ?? 'draft') === 'draft') selected @endif>Draft</option>
                        <option value="published" @if(($course->status ?? 'draft') === 'published') selected @endif>Published</option>
                        <option value="archived" @if(($course->status ?? 'draft') === 'archived') selected @endif>Archived</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('instructor.courses.index') }}" class="mr-2 px-4 py-2 border rounded">Cancel</a>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.instructor>
