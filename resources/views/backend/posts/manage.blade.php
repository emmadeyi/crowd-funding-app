<x-app-layout>
    <x-slot name="header">
        {{ __('Manage Blog Posts') }}
    </x-slot>
    @section('side-nav')
        <div>
            <x-side-nav :active="request()->routeIs('posts')" href="{{ route('posts') }}"> 
                <i class="fa fa-list"></i> All Posts 
            </x-side-nav>
            <x-side-nav :active="request()->routeIs('posts.manage')" href="{{ route('posts.manage') }}"> 
                <i class="fa fa-cogs"></i> Manage Post
            </x-side-nav>
        </div>
    @endsection
    @section('content-div')                                  
        @livewire('blog.posts', ['posts' => $posts])   
    @endsection
</x-app-layout>
