<x-app-layout>
    <x-slot name="header">
        {{ __('Projects & Innovations') }}
    </x-slot>
    @section('side-nav')
        @livewire('project.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('project.manage-projects')
    @endsection
</x-app-layout>