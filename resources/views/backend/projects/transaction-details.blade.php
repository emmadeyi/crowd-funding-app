<x-app-layout>
    <x-slot name="header">
        {{ __('Projects & Innovations') }}
    </x-slot>
    @section('side-nav')
        @livewire('project.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('project.transaction-details', ['type' => $type, 'id' => $id])
    @endsection
</x-app-layout>