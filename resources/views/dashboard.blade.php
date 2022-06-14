<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>  
    @section('side-nav')
        <div>
            <x-side-nav :active="request()->routeIs('projects.manage')" href="{{ route('projects.manage') }}"> 
                <i class="fas fa-tasks"></i> Projects & Innovations 
            </x-side-nav>
            <x-side-nav :active="request()->routeIs('posts')" href="{{ route('posts') }}"> 
                <i class="fa fa-newspaper"></i> Posts 
            </x-side-nav>
            {{-- <x-side-nav :active="request()->routeIs('projects.personal')" href="{{ route('projects.personal') }}"> 
                <i class="fa fa-credit-card"></i> Maintenance Fee 
            </x-side-nav> --}}
            <x-side-nav :active="request()->routeIs('careers.career-list')" href="{{ route('careers.career-list') }}"> 
                <i class="fa fa-folder"></i> Career 
            </x-side-nav>
            <x-side-nav :active="request()->routeIs('profile.show')" href="{{ route('profile.show') }}"> 
                <i class="fa fa-user"></i> Profile 
            </x-side-nav>
            @if(auth()->user()->hasanyrole('Developer|Super Admin|'))
                <x-side-nav :active="request()->routeIs('accounts.users-list')" href="{{ route('accounts.users-list') }}"> 
                    <i class="fas fa-users-cog"></i> Manage Accounts 
                </x-side-nav>
                @if(auth()->user()->hasanyrole('Developer'))            
                    <x-side-nav href="{{url('./create_symlink.php')}}"> 
                        <i class="fas fa-hdd"></i> Link Storage 
                    </x-side-nav>
                    <x-side-nav :active="request()->routeIs('config.cache')" href="{{ route('config.cache') }}"> 
                        <i class="fas fa-database"></i> Config Cache 
                    </x-side-nav>
                @endif
            @endif
        </div>
    @endsection
    @section('content-div')        
        @livewire('dashboard.dashboard')
    @endsection
</x-app-layout>
