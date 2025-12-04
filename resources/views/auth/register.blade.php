<x-layouts.auth>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900">Register</h2>
        <p class="text-gray-600 mt-2">Create your account to get started.</p>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <x-forms.text-input label="Name" name="name" required />
        <x-forms.text-input label="Email" name="email" type="email" required />
        <x-forms.text-input label="Password" name="password" type="password" required />
        <x-forms.text-input label="Confirm Password" name="password_confirmation" type="password" required />
        <x-buttons.primary class="w-full">Register</x-buttons.primary>
        <p class="mt-4 text-center text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a></p>
    </form>
</x-layouts.auth>
