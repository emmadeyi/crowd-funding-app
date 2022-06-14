@props(['initialValue' => ''])
<div 
    class="rounded" 
    wire:ignore
    {{ $attributes }}
    x-data
    @trix-blur="$dispatch('change', $event.target.value)"
>
    
    <input type="hidden" id="x" value="{{ $initialValue }}">
    <trix-editor class="font-light block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" input="x"></trix-editor>
</div>