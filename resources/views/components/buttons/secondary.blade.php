{{-- Secondary Button Component --}}
@props(['type' => 'button'])

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-2 rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500']) }}>
    {{ $slot }}
</button>
