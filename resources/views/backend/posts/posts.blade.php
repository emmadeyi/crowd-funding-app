<x-app-layout>
    <x-slot name="header">
        {{ __('Blog') }}
    </x-slot>
    @section('side-nav')        
        @livewire('blog.side-nav')
    @endsection
    @section('content-div')                                  
        @livewire('blog.posts', ['posts' => $posts])   
    @endsection
</x-app-layout>
