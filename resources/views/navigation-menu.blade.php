<nav x-data="{ open: false }" class="bg-gray-700 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 lg:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"><i class="fas fa-home"></i> &nbsp;
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-jet-nav-link href="{{ route('projects.manage') }}" :active="request()->routeIs('projects.manage')">
                        <i class="fas fa-tasks"></i> &nbsp;
                        {{ __('Projects & Innovaitions') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-jet-nav-link href="{{ route('posts') }}" :active="request()->routeIs('posts')">
                        <i class="fa fa-newspaper"></i> &nbsp;
                        {{ __('Blog') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-jet-nav-link href="{{ route('careers.career-list') }}" :active="request()->routeIs('careers.career-list')">
                        <i class="fa fa-folder"></i> &nbsp;
                        {{ __('Career') }}
                    </x-jet-nav-link>
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:ml-6">
                
                <!-- Settings Dropdown -->
                <div class="ml-3 relative ">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-yellow-300 transition bg-gray-700">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-300 bg-white hover:text-yellow-400 focus:outline-none transition bg-gray-700">
                                        
                                        <i class="fa fa-user-circle"></i> &nbsp;
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            
                            @if(auth()->user()->hasanyrole('Developer|Super Admin|'))
                                <x-jet-dropdown-link href="{{ route('accounts.users-list') }}">
                                    <i class="fa fa-users"></i> &nbsp;
                                    {{ __('Manage Users') }}
                                </x-jet-dropdown-link>
                            @endif
                            
                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                <i class="fa fa-user"></i> &nbsp;
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            {{-- @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif --}}

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fa fa-lock"></i> &nbsp;
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-yellow-400 hover:yellow-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-yellow-400 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('projects.manage') }}" :active="request()->routeIs('projects.manage')">
                {{ __('Projects & Innovaitions') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('posts') }}" :active="request()->routeIs('posts')">
                {{ __('Posts') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('careers.career-list') }}" :active="request()->routeIs('careers.career-list')">
                {{ __('Career') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-yellow-400">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-yellow-400">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-yellow-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
