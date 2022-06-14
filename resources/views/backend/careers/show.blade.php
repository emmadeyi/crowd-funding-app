<x-app-layout>
    <x-slot name="header">
        {{ __('Career') }}
    </x-slot>
    @section('side-nav')        
        @livewire('career.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('career.show', ['career' => $career])   
    @endsection
</x-app-layout>
