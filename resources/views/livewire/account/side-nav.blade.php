<div>
    @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
        <x-side-nav :active="request()->routeIs('accounts.users-list')" href="{{ route('accounts.users-list') }}"> 
            <i class="fa fa-users"></i> All Users 
        </x-side-nav>
        @if(auth()->user()->hasanyrole('Developer|Super Admin'))
        <x-side-nav :active="request()->routeIs('accounts.roles')" href="{{ route('accounts.roles') }}"> 
            <i class="fas fa-user-secret"></i> Manage Roles
        </x-side-nav>
        <x-side-nav :active="request()->routeIs('accounts.permissions')" href="{{ route('accounts.permissions') }}"> 
            <i class="fas fa-user-shield"></i> Manage Permissions
        </x-side-nav>
        @endif
    @endif
    <x-side-nav :active="request()->routeIs('profile.show')" href="{{ route('profile.show') }}"> 
        <i class="fas fa-id-badge"></i> Basic Profile
    </x-side-nav>
    <x-side-nav :active="request()->routeIs('accounts.user-bio-profile')" href="{{ route('accounts.user-bio-profile', Crypt::encrypt(Auth::user()->id)) }}"> 
        <i class="far fa-id-card"></i> User Data
    </x-side-nav>
    
</div>