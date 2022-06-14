@props(['active'])

@php
$classes = ($active ?? false)
            ? 'border-b-2 border-yellow-400 bg-gray-700 text-yellow-300 block py-2.5 px-4 focus:bg-gray-700 focus:border-yellow-400 rounded transition duration-200'
            : 'border-b-2 border-transparent block py-2.5 px-4 hover:bg-gray-700 hover:border-yellow-400 hover:text-white focus:bg-gray-700 focus:border-yellow-400 focus:text-white rounded transition duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
