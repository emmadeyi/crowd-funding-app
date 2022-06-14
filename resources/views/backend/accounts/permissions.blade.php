<x-app-layout>
    <x-slot name="header">
        {{ __('Manage Permissions') }}
    </x-slot>
    @section('side-nav')        
    @livewire('account.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('account.permissions')   
    @endsection
</x-app-layout>
