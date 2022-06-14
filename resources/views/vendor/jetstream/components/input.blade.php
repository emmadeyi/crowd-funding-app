@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-200 focus:border-gray-300 focus:ring focus:ring-gray-200 text-gray-700 focus:ring-opacity-50 rounded-md  sm:text-sm sm:leading-5']) !!}>
