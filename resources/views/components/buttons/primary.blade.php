{{-- Primary Button Component --}}
@props(['type' => 'submit'])

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>
