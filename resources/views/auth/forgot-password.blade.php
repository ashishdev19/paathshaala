<x-layouts.auth>
    <div class='mb-6 text-center'>
        <h2 class='text-3xl font-bold text-gray-900'>Forgot Password</h2>
        <p class='text-gray-600 mt-2'>Enter your email to receive a password reset link.</p>
    </div>
    <form method='POST' action='{{ route('password.email') }}'>
        @csrf
        <x-forms.text-input label='Email' name='email' type='email' required />
        <x-buttons.primary class='w-full'>Send Reset Link</x-buttons.primary>
        <p class='mt-4 text-center text-gray-600'><a href='{{ route('login') }}' class='text-indigo-600 hover:underline'>Back to Login</a></p>
    </form>
</x-layouts.auth>
