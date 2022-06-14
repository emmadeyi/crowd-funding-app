<x-app-layout>
    <x-slot name="header">
        {{ __('Terms & Condition') }}
    </x-slot>
    @section('side-nav')
        @livewire('project.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('project.terms-and-condition')
    @endsection
</x-app-layout>