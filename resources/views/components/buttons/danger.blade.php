{{-- Danger Button Component --}}
@props(['type' => 'button'])

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2 rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500']) }}>
    {{ $slot }}
</button>
