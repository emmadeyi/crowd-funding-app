<div>
    <div class="border-b mb-5 md:px-5">
        <div class="col-span-6 sm:col-span-4 my-4">
            <x-jet-label for="user_name" value="{{ __('User') }}" />
            <x-jet-input id="user_name" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="text" name="user_name" value="{{old('user_name', 1)}}" min="0" wire:model.debounce.500ms="user_name" placeholder="Input user Name" disabled />
            @error('user_name') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-6 sm:col-span-4 my-4 ">
            <x-jet-label for="roles" value="{{ __('Roles') }}" />
            <div class="flex flex-wrap">
                <div class="flex border-r border-gray-400 cursor-pointer p-2 w-auto mt-2 hover:bg-gray-100">
                    <x-jet-input id="SelectAllRoles" class="block mr-1 focus:border-gray-400 focus:ring focus:ring-gray-400 cursor-pointer" type="checkbox"  wire:model="SelectAllRoles"/>
                    <x-jet-label class="cursor-pointer" for="SelectAllRoles" value="{{$SelectAllRolesName}}" /> 
                </div>
                @foreach ($roles as $key => $role)
                    <div class="flex border-r border-gray-400 cursor-pointer p-2 w-auto mt-2 hover:bg-gray-100">
                        <x-jet-input id="selected_roles.{{$key}}" class="block mr-1 focus:border-gray-400 focus:ring focus:ring-gray-400 cursor-pointer" type="checkbox"  wire:model="selected_roles.{{$key}}" value="{{$key}}" />
                        <x-jet-label class="cursor-pointer" for="selected_roles.{{$key}}" value="{{ $role }}" /> 
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-6 sm:col-span-4 my-4 ">
            <x-jet-label for="permissions" value="{{ __('Permissions') }}" />
            <div class="flex flex-wrap">
                <div class="flex border-r border-gray-400 cursor-pointer p-2 w-auto mt-2 hover:bg-gray-100">
                    <x-jet-input id="SelectAllPermissions" class="block mr-1 focus:border-gray-400 focus:ring focus:ring-gray-400 cursor-pointer" type="checkbox"  wire:model="SelectAllPermissions"/>
                    <x-jet-label class="cursor-pointer" for="SelectAllPermissions" value="{{$SelectAllPermissionsName}}" /> 
                </div>
                @foreach ($permissions as $key => $permission)
                    <div class="flex border-r border-gray-400 cursor-pointer p-2 w-auto mt-2 hover:bg-gray-100">
                        <x-jet-input id="selected_permissions.{{$key}}" class="block mr-1 focus:border-gray-400 focus:ring focus:ring-gray-400 cursor-pointer" type="checkbox"  wire:model="selected_permissions.{{$key}}" value="{{$key}}" />
                        <x-jet-label class="cursor-pointer" for="selected_permissions.{{$key}}" value="{{ $permission }}" /> 
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button class="ml-2" wire:click.prevent="updateUserAcl" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-jet-button>
        </div>   
    </div>
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-users"></i> Users | <i class="far fa-address-book"></i> {{$usersCount}}</p>
    @if ($users->count() > 0)

        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Name</th></th>
                <th class="px-3 py-2 md:border">Email</th>
                <th class="px-3 py-2 md:border">Role</th>
                <th class="px-3 py-2 md:border">status</th>
                <th class="px-3 py-2 md:border">Date</th>
                <th class="px-3 py-2 md:border">Action</th>
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($users as $user) 
                    @if(auth()->user()->hasanyrole('Developer'))
                        <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                            <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Name</span> <span class="w-2/3 text-left">{{ $user->name }}</span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> Email</span><span class="w-2/3 text-left">{{ $user->email}}</span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Role</span> <span class="w-2/3 text-left">
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="italic">{{$role}}, </span>
                                    @endforeach
                                </span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Status</span> <span class="w-2/3 text-left">
                                    @switch($user->status)
                                        @case('0')
                                            Pending
                                            @break
                                        @case('1')
                                            Active
                                            @break
                                        @case('2')
                                            Suspended
                                            @break
                                        @default
                                            Unknown
                                    @endswitch    
                                </span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Date</span> <span class="w-2/3 text-left">{{$user->created_at}}</span>
                            </td>
                            <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                <span class="w-2/3 text-left">
                                    <a href="{{route('accounts.user-bio-profile', Crypt::encrypt($user->id))}}"> 
                                        <x-jet-secondary-button title="User Data">
                                            <i class="far fa-id-card"></i>
                                        </x-jet-secondary-button>
                                    </a>
                                    <x-jet-secondary-button wire:click.prevent="updateUserAclForm({{$user->id}})" title="Update User Access Control">
                                        <i class="fas fa-users-cog"></i>
                                    </x-jet-secondary-button>
                                    {{-- <x-jet-secondary-button wire:click.prevent="updatePermissionsFormModal({{$user->id}})" title="Update Permissions">
                                        <i class="fas fa-user-shield"></i>
                                    </x-jet-secondary-button> --}}
                                    <a href="{{route('projects.user-transactions', Crypt::encrypt($user->id))}}"> 
                                        <x-jet-secondary-button wire:click.prevent="toggleStatusModal({{$user->id}})">
                                            @switch($user->status)
                                                @case('0')
                                                    <i class="fa fa-check"></i>
                                                    @break
                                                @case('1')
                                                    <i class="fa fa-ban"></i>
                                                    @break
                                                @case('2')
                                                    <i class="fa fa-check"></i>
                                                    @break
                                                @default
                                                    Unknown
                                            @endswitch
                                        </x-jet-secondary-button>                                    
                                    </a>
                                </span>
                                
                            </td>
                        </tr> 
                    @else
                        @if(!$user->hasanyrole('Developer'))
                            <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                                <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                                <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                    <span class="font-bold w-1/3 text-left md:hidden block"> Name</span> <span class="w-2/3 text-left">{{ $user->name }}</span>
                                </td>
                                <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                                    <span class="font-bold w-1/3 text-left md:hidden block"> Email</span><span class="w-2/3 text-left">{{ $user->email}}</span>
                                </td>
                                <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                    <span class="font-bold w-1/3 text-left md:hidden block"> Role</span> <span class="w-2/3 text-left">
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="italic">{{$role}}, </span>
                                        @endforeach
                                    </span>
                                </td>
                                <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                    <span class="font-bold w-1/3 text-left md:hidden block"> Status</span> <span class="w-2/3 text-left">
                                        @switch($user->status)
                                            @case('0')
                                                Pending
                                                @break
                                            @case('1')
                                                Active
                                                @break
                                            @case('2')
                                                Suspended
                                                @break
                                            @default
                                                Unknown
                                        @endswitch    
                                    </span>
                                </td>
                                <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                    <span class="font-bold w-1/3 text-left md:hidden block"> Date</span> <span class="w-2/3 text-left">{{$user->created_at}}</span>
                                </td>
                                <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                    <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                    <span class="w-2/3 text-left">
                                        <a href="{{route('accounts.user-bio-profile', Crypt::encrypt($user->id))}}"> 
                                            <x-jet-secondary-button title="User Data">
                                                <i class="far fa-id-card"></i>
                                            </x-jet-secondary-button>
                                        </a>
                                        <x-jet-secondary-button wire:click.prevent="updateUserAclForm({{$user->id}})" title="Update User Access Control">
                                            <i class="fas fa-users-cog"></i>
                                        </x-jet-secondary-button>
                                        {{-- <x-jet-secondary-button wire:click.prevent="updatePermissionsFormModal({{$user->id}})" title="Update Permissions">
                                            <i class="fas fa-user-shield"></i>
                                        </x-jet-secondary-button> --}}
                                        <a href="{{route('projects.user-transactions', Crypt::encrypt($user->id))}}"> 
                                            <x-jet-secondary-button wire:click.prevent="toggleStatusModal({{$user->id}})">
                                                @switch($user->status)
                                                    @case('0')
                                                        <i class="fa fa-check"></i>
                                                        @break
                                                    @case('1')
                                                        <i class="fa fa-ban"></i>
                                                        @break
                                                    @case('2')
                                                        <i class="fa fa-check"></i>
                                                        @break
                                                    @default
                                                        Unknown
                                                @endswitch
                                            </x-jet-secondary-button>                                    
                                        </a>
                                    </span>
                                    
                                </td>
                            </tr> 
                        @endif
                    @endif  
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $users->links() }}  
        </div>
        
        <x-jet-confirmation-modal wire:model="updateUserStatusModal">
            <x-slot name="title">
                {{ __('Update Status') }}
            </x-slot>

            <x-slot name="content">
                Are you sure you would like to update this user status?
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('updateUserStatusModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="toggleUserStatus()" wire:loading.attr="disabled">
                    {{ __('Confirm') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @else
        <p class="font-light">No user record found.</p>
    @endif
</div>

@section('custom-scripts')
    <script>
        window.livewire.on('alert', param => {
            // toastr[param['type']](param['message']);
            iziToast[param['type']]({
                title: param['title'],
                message: param['message'],
                position: 'topRight'
            });
        });
    </script>
@endsection
