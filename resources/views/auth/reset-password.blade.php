<x-layouts.auth>
    <div class='mb-6 text-center'>
        <h2 class='text-3xl font-bold text-gray-900'>Reset Password</h2>
        <p class='text-gray-600 mt-2'>Enter your new password below.</p>
    </div>
    
    <form method='POST' action='{{ route('password.store') }}'>
        @csrf
        
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <x-forms.text-input 
            label='Email' 
            name='email' 
            type='email' 
            :value="old('email', $request->email)" 
            required 
            autofocus 
        />
        
        <x-forms.text-input 
            label='New Password' 
            name='password' 
            type='password' 
            required 
        />
        
        <x-forms.text-input 
            label='Confirm Password' 
            name='password_confirmation' 
            type='password' 
            required 
        />
        
        <x-buttons.primary class='w-full mt-4'>Reset Password</x-buttons.primary>
        
        <p class='mt-4 text-center text-gray-600'>
            <a href='{{ route('login') }}' class='text-indigo-600 hover:underline'>Back to Login</a>
        </p>
    </form>
</x-layouts.auth>
