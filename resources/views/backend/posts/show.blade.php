<x-app-layout>
    <x-slot name="header">
        {{ __('Blog') }}
    </x-slot>
    @section('side-nav')        
        @livewire('blog.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('blog.show', ['post' => $post])   
    @endsection
</x-app-layout>
