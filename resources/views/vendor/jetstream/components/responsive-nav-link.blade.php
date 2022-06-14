@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-yellow-200 text-base font-medium text-yellow-200 bg-gray-800 focus:outline-none focus:text-yellow-200 focus:bg-gray-800 focus:border-gray-800 transition'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 hover:border-yellow-300 focus:outline-none focus:text-yellow-300 focus:bg-gray-800 focus:border-yellow-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
