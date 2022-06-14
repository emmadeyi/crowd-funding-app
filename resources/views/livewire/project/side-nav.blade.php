<div>
    
    @if(auth()->user()->canany(['Create Project']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.register')" href="{{ route('projects.register') }}"> 
        <i class="fas fa-folder-plus"></i> New Project 
    </x-side-nav>
    @endif
    
    @if(auth()->user()->canany(['Read Project']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.personal')" href="{{ route('projects.personal') }}"> 
        <i class="fa fa-address-card"></i> My Project 
    </x-side-nav>
    @endif
    
    @if(auth()->user()->canany(['Read Project']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.manage')" href="{{ route('projects.manage') }}"> 
        <i class="fa fa-list"></i> Project List 
    </x-side-nav>
    @endif
    
    @if(auth()->user()->canany(['Manage Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('subscriptions.manage')" href="{{ route('subscriptions.manage') }}"> 
        <i class="fa fa-cogs"></i> Manage Subscriptions
    </x-side-nav>
    @endif    
    
    @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.log.transaction')" href="{{ route('projects.log.transaction') }}"> 
        <i class="fa fa-calculator"></i>  Log Transaction
    </x-side-nav>
    @endif

    @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.manage.payouts')" href="{{ route('projects.manage.payouts') }}"> 
        <i class="fas fa-hand-holding-usd"></i>  Manage Project Payouts
    </x-side-nav>
    @endif
    
    @if(auth()->user()->canany(['Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.user-investment')" href="{{ route('projects.user-investment', Crypt::encrypt(Auth::user()->id)) }}"> 
        <i class="fa fa-suitcase"></i> User Investment
    </x-side-nav>
    @endif
    
    @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.investors')" href="{{ route('projects.investors') }}"> 
        <i class="fa fa-users"></i> Investors
    </x-side-nav>
    @endif
    
    @if(auth()->user()->canany(['Read Transaction', 'Manage Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.user-transactions')" href="{{ route('projects.user-transactions', Crypt::encrypt(Auth::user()->id)) }}">
        <i class="fas fa-address-book"></i> User Transactions
    </x-side-nav>
    @endif
    
    @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
    <x-side-nav :active="request()->routeIs('projects.transactions')" href="{{ route('projects.transactions') }}"> 
        <i class="fas fa-file-invoice-dollar"></i> Transactions History
    </x-side-nav>
    @endif
</div>