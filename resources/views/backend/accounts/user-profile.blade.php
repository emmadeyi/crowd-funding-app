<x-app-layout>
    <x-slot name="header">
        {{ __('User Bio Profile') }}
    </x-slot>
    @section('side-nav')        
    @livewire('account.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('account.user-profile', ['id' => $id])   
    @endsection
</x-app-layout>
