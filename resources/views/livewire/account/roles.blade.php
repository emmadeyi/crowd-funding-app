<div>
    @if(auth()->user()->hasanyrole('Developer'))
    <p class="uppercase text-base text-gray-700 md:p-2 md:my-2"> <i class="fas fa-plus-circle"></i> Create/ Update Role</p>
    <div class="border-b mb-5 md:px-5">
        <div class="col-span-6 sm:col-span-4 my-4">
            <x-jet-label for="role_name" value="{{ __('Role Name') }}" />
            <x-jet-input id="role_name" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="text" name="role_name" value="{{old('role_name', 1)}}" min="0" wire:model.debounce.500ms="role_name" placeholder="Input Role Name" autofocus />
            @error('role_name') <span class="error text-red-500">{{ $message }}</span> @enderror
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
            <x-jet-button class="ml-2" wire:click.prevent="updateRoles" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-jet-button>
        </div>   
    </div>
    @endif
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fas fa-user-secret"></i> Roles | <i class="fas fa-clipboard-list"></i> {{$role_count}} | 
    </p>
    @if ($roles->count() > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Name</th></th>
                {{-- <th class="px-3 py-2 md:border">Permissions</th> --}}
                <th class="px-3 py-2 md:border">Date</th>                
                @if(auth()->user()->hasanyrole('Developer'))
                    <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($roles as $role) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Name</span> <span class="w-2/3 text-left">{{ $role->name }}</span>
                        </td>
                        {{-- <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Permissions</span> <span class="w-2/3 text-left">
                            </span>
                        </td> --}}
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block">Created Date</span> <span class="w-2/3 text-left">{{$role->created_at}}</span>
                        </td>
                        
                        @if(auth()->user()->hasanyrole('Developer'))
                        <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                            <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                            <span class="w-2/3 text-left">
                                <x-jet-secondary-button wire:click.prevent="showUpdateRoleFormModal({{$role->id}})" title="Update">
                                    <i class="fas fa-edit"></i>
                                </x-jet-secondary-button>
                                <x-jet-secondary-button wire:click.prevent="showDeleteRoleModal({{$role->id}})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </x-jet-secondary-button>
                            </span>                            
                        </td>
                        @endif
                    </tr>   
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $roles->links() }}  
        </div> 
        <x-jet-confirmation-modal wire:model="deleteRoleModal">
            <x-slot name="title">
                {{ __('Delete Role') }}
            </x-slot>
    
            <x-slot name="content">
                Are you sure you would like to delete this role?
            </x-slot>
    
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('deleteRoleModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
    
                <x-jet-danger-button class="ml-2" wire:click="deleteRole({{$role->id}})" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal> 
    @else
        <p class="font-light">No Role record found.</p>
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