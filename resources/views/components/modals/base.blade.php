{{-- Modal Component --}}
@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
$maxWidth = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="{ show: @js($show) }"
    x-on:open-modal.window="$event.detail === '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="show = false"
    x-show="show"
    x-cloak
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;">
    
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="relative min-h-screen flex items-center justify-center">
        <div 
            x-on:click.away="show = false"
            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all {{ $maxWidth }} w-full">
            {{ $slot }}
        </div>
    </div>
</div>
