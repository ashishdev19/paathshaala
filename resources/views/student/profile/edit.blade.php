<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Edit Profile
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Picture -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-indigo-200">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 -mx-6 -mt-6 px-6 py-4 mb-6 border-b border-indigo-200 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-900">Profile Picture</h3>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if(auth()->user()->profile_image && file_exists(storage_path('app/public/' . auth()->user()->profile_image)))
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Picture" class="h-24 w-24 rounded-full object-cover shadow-lg">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <input type="file" name="profile_picture" accept="image/*" class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-blue-50 file:to-blue-100 file:text-blue-700 hover:file:from-blue-100 hover:file:to-blue-200 file:shadow-sm">
                        <p class="mt-1 text-sm text-gray-500">JPG, PNG or GIF. Max size 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-blue-200">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 -mx-6 -mt-6 px-6 py-4 mb-6 border-b border-blue-200 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', auth()->user()->dob) }}" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="3" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">{{ old('address', auth()->user()->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-green-200">
                <div class="bg-gradient-to-r from-green-50 to-green-100 -mx-6 -mt-6 px-6 py-4 mb-6 border-b border-green-200 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-900">Academic Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Qualification</label>
                        <input type="text" name="qualification" value="{{ old('qualification', auth()->user()->qualification) }}" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Institution</label>
                        <input type="text" name="institution" value="{{ old('institution', auth()->user()->institution) }}" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-purple-200">
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 -mx-6 -mt-6 px-6 py-4 mb-6 border-b border-purple-200 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div></div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('student.dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold shadow-md transition duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.student>
