<x-app-layout>
    <x-slot name="header">
        {{ __('Manage Roles') }}
    </x-slot>
    @section('side-nav')        
    @livewire('account.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('account.roles')   
    @endsection
</x-app-layout>
