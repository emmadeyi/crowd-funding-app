<x-app-layout>
    <x-slot name="header">
        {{ __('Users Lists') }}
    </x-slot>
    @section('side-nav')        
    @livewire('account.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('account.users-list')   
    @endsection
</x-app-layout>
