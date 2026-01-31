<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Edit Course</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-lg flex justify-between items-center">
            <div>
                <h3 class="text-indigo-900 font-bold">Course Curriculum</h3>
                <p class="text-indigo-700 text-sm">Add class-wise videos, PDFs, and notes as you complete them.</p>
            </div>
            <a href="{{ route('instructor.courses.curriculum.edit', $course->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-sm">
                Manage Curriculum
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

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
                    <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2" rows="4">{{ old('description', $course->description ?? '') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        <option value="">Select Category</option>
                        @foreach(\App\Models\CourseCategory::active()->orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Course Image (thumbnail)</label>
                    @if($course->thumbnail)
                        <div class="mb-2">
                            <img src="{{ $course->thumbnail_url }}" alt="Current thumbnail" class="h-32 w-auto rounded border">
                            <p class="text-xs text-gray-500 mt-1">Current: {{ basename($course->thumbnail) }}</p>
                        </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Course PDF (syllabus)</label>
                    @if($course->syllabus && isset($course->syllabus['pdf']))
                        <p class="text-xs text-gray-500 mb-2">Current: {{ basename($course->syllabus['pdf']) }}</p>
                    @endif
                    <input type="file" name="syllabus_pdf" accept="application/pdf" class="mt-1 block w-full">
                    <p class="text-xs text-gray-500 mt-1 italic">Note: This is for the overall course syllabus. Use "Manage Curriculum" above for class-wise notes.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Course Video File (up to 1GB)</label>
                    @if($course->video_file)
                        <p class="text-xs text-gray-500 mb-2">Current: {{ basename($course->video_file) }}</p>
                    @endif
                    <input type="file" name="video_file" accept="video/*" class="mt-1 block w-full">
                    <p class="text-xs text-gray-500 mt-1">You can also provide a Video URL below instead of uploading a file.</p>
                    <p class="text-xs text-gray-500 mt-1 italic">Note: This is for the course intro/promo video. Use "Manage Curriculum" above for class recordings.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Course Video URL</label>
                    <input type="url" name="video_url" value="{{ $course->video_url ?? '' }}" placeholder="https://" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (INR)</label>
                    <input type="number" step="0.01" name="price" value="{{ $course->price ?? '0.00' }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- GST Settings -->
                <div class="border-t pt-4 mt-4">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-percentage text-blue-500 mr-1"></i> GST Settings
                    </h4>
                    
                    <div class="mb-3">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="gst_enabled" value="1" 
                                   {{ old('gst_enabled', $course->gst_enabled ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600">
                            <span class="ml-2 text-sm text-gray-700">Enable GST for this course</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="block text-sm font-medium text-gray-700">GST Percentage:</label>
                        <input type="number" step="0.01" name="gst_percentage" 
                               value="{{ old('gst_percentage', $course->gst_percentage ?? 18) }}" 
                               min="0" max="100"
                               class="w-24 border border-gray-300 rounded-md p-2">
                        <span class="text-gray-600">%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Default: 18%. GST will be added during checkout.</p>
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
