<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Review Course: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Course Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div>
                    @if($course->thumbnail)
                        <img src="{{ asset($course->thumbnail) }}" alt="Thumbnail" class="w-full h-64 object-cover rounded-lg mb-6">
                    @endif
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500">COURSE TITLE</label>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $course->title }}</h3>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500">SUBTITLE</label>
                            <p class="text-gray-700">{{ $course->subtitle ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500">INSTRUCTOR</label>
                            <p class="text-gray-700 font-semibold">{{ $course->teacher->name }}</p>
                            <p class="text-sm text-gray-600">{{ $course->teacher->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Course Details -->
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-xs text-gray-600">Category</p>
                            <p class="font-semibold">{{ $course->category }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-xs text-gray-600">Level</p>
                            <p class="font-semibold">{{ ucfirst($course->level) }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-xs text-gray-600">Language</p>
                            <p class="font-semibold">{{ $course->language }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-xs text-gray-600">Mode</p>
                            <p class="font-semibold">{{ ucfirst($course->course_mode) }}</p>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <label class="text-xs font-semibold text-gray-500">PRICING</label>
                        <div class="mt-2 space-y-1">
                            <p class="text-gray-700"><strong>Type:</strong> {{ $course->is_free ? 'Free' : 'Paid' }}</p>
                            @if(!$course->is_free)
                                <p class="text-gray-700"><strong>Price:</strong> ₹{{ number_format($course->price, 2) }}</p>
                                @if($course->discount_price)
                                    <p class="text-gray-700"><strong>Discount:</strong> ₹{{ number_format($course->discount_price, 2) }}</p>
                                @endif
                            @endif
                            <p class="text-gray-700"><strong>Validity:</strong> {{ $course->validity_days ? $course->validity_days . ' days' : 'Lifetime' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg text-gray-900 mb-3">Course Description</h3>
            <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
        </div>

        <!-- Curriculum Summary -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">Curriculum Summary</h3>
            
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $course->sections->count() }}</p>
                    <p class="text-sm text-gray-600">Sections</p>
                </div>
                <div class="bg-green-50 p-4 rounded text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $course->lectures->count() }}</p>
                    <p class="text-sm text-gray-600">Lectures</p>
                </div>
                <div class="bg-purple-50 p-4 rounded text-center">
                    <p class="text-2xl font-bold text-purple-600">
                        {{ floor($course->lectures->sum(fn($l) => $l->duration ?? 0) / 3600) }}h
                    </p>
                    <p class="text-sm text-gray-600">Duration</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($course->sections as $section)
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="font-semibold text-gray-800">{{ $section->title }}</p>
                        <p class="text-sm text-gray-600">{{ $section->lectures->count() }} lectures</p>
                    </div>
                @empty
                    <p class="text-orange-600">⚠️ No sections found</p>
                @endforelse
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">SEO Settings</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500">META TITLE</label>
                    <p class="text-gray-700">{{ $course->meta_title ?? '(Not set)' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">META DESCRIPTION</label>
                    <p class="text-gray-700">{{ $course->meta_description ?? '(Not set)' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">URL SLUG</label>
                    <p class="text-gray-700">{{ $course->slug ?? '(Not set)' }}</p>
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">Review & Action</h3>
            
            <div class="mb-6 p-4 bg-blue-50 rounded border border-blue-200">
                <p class="text-sm text-blue-900">
                    <strong>Current Status:</strong> 
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-semibold">
                        {{ ucfirst(str_replace('_', ' ', $course->status)) }}
                    </span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Approve Button -->
                <form action="{{ route('admin.course-approvals.approve', $course) }}" method="POST" onsubmit="return confirm('Approve this course?');">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                        ✓ Approve Course
                    </button>
                </form>

                <!-- Request Changes Button -->
                <button onclick="showChangeModal()" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold">
                    ⟲ Request Changes
                </button>

                <!-- Reject Button -->
                <button onclick="showRejectModal()" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold">
                    ✕ Reject Course
                </button>
            </div>
        </div>
    </div>

    <!-- Request Changes Modal -->
    <div id="changeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">Request Changes</h3>
            <form action="{{ route('admin.course-approvals.request-changes', $course) }}" method="POST">
                @csrf
                <textarea name="change_message" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4" 
                          placeholder="What changes do you want the instructor to make?" rows="5" required></textarea>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold">
                        Send Request
                    </button>
                    <button type="button" onclick="closeChangeModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">Reject Course</h3>
            <form action="{{ route('admin.course-approvals.reject', $course) }}" method="POST">
                @csrf
                <textarea name="rejection_reason" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent mb-4" 
                          placeholder="Why are you rejecting this course?" rows="5" required></textarea>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold">
                        Reject Course
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showChangeModal() {
            document.getElementById('changeModal').classList.remove('hidden');
        }

        function closeChangeModal() {
            document.getElementById('changeModal').classList.add('hidden');
        }

        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modals on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeChangeModal();
                closeRejectModal();
            }
        });
    </script>
</x-layouts.admin>
