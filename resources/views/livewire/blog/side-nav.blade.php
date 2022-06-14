<div>
    @if(auth()->user()->can('Create Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
        <x-side-nav :active="request()->routeIs('blogs.create')" href="{{ route('blogs.create') }}"> 
            <i class="fa fa-file"></i> New Post
        </x-side-nav>    
    @endif

    <x-side-nav :active="request()->routeIs('posts')" href="{{ route('posts') }}"> 
        <i class="fa fa-list"></i> All Posts 
    </x-side-nav>
</div>