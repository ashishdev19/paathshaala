<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Create Course</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        @if(!($hasSubscription ?? false))
            <div class="p-6 border border-yellow-200 bg-yellow-50 rounded">
                <h3 class="text-lg font-semibold mb-2">Subscription required</h3>
                <p class="text-sm text-gray-700 mb-4">Please subscribe to a teacher plan to be able to create courses.</p>
                <a href="{{ route('instructor.subscription.show') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">View Plans</a>
            </div>
        @else
            <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2" rows="4"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" name="category" placeholder="e.g., Science, Technology, Arts" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Course Image (thumbnail)</label>
                        <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Course PDF (syllabus)</label>
                        <input type="file" name="syllabus_pdf" accept="application/pdf" class="mt-1 block w-full">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Course Video File (up to 1GB)</label>
                        <input type="file" name="video_file" accept="video/*" class="mt-1 block w-full">
                        <p class="text-xs text-gray-500 mt-1">You can also provide a Video URL below instead of uploading a file.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Course Video URL</label>
                        <input type="url" name="video_url" placeholder="https://" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price (INR)</label>
                        <input type="number" step="0.01" name="price" value="0.00" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('instructor.courses.index') }}" class="mr-2 px-4 py-2 border rounded">Cancel</a>
                        <button class="bg-green-600 text-white px-4 py-2 rounded">Create</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</x-layouts.instructor>
