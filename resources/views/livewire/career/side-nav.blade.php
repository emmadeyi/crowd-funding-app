<div>
    @if(auth()->user()->can('Create Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('careers.create')" href="{{ route('careers.create') }}"> 
        <i class="fa fa-file"></i> New Job Post
    </x-side-nav>
    @endif
    <x-side-nav :active="request()->routeIs('careers.career-list')" href="{{ route('careers.career-list') }}"> 
        <i class="fa fa-list"></i> All Job Posts 
    </x-side-nav>
</div>