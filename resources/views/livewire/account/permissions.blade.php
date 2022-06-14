<div>
    @if(auth()->user()->hasanyrole('Developer'))
        <x-jet-button wire:click.prevent="showPermissionFormModal" >
            <i class="fas fa-plus-circle"></i> <span class="ml-2">New Permission</span>
        </x-jet-button>
    @endif
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fas fa-user-secret"></i> Permissions | <i class="fas fa-clipboard-list"></i> {{$permissions_count}} | 
    </p>
    @if ($permissions->count() > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Name</th></th>
                <th class="px-3 py-2 md:border">Date</th>
                @if(auth()->user()->hasanyrole('Developer'))
                    <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($permissions as $permission) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Name</span> <span class="w-2/3 text-left">{{ $permission->name }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block">Created Date</span> <span class="w-2/3 text-left">{{$permission->created_at}}</span>
                        </td>
                        @if(auth()->user()->hasanyrole('Developer'))
                            <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                <span class="w-2/3 text-left">
                                    <x-jet-secondary-button wire:click.prevent="showUpdatePermissionFormModal({{$permission->id}})" title="Update">
                                        <i class="fas fa-edit"></i>
                                    </x-jet-secondary-button>
                                    <x-jet-secondary-button wire:click.prevent="showDeletePermissionModal({{$permission->id}})" title="Delete">
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
            {{ $permissions->links() }}  
        </div> 
        <x-jet-confirmation-modal wire:model="deletePermissionModal">
            <x-slot name="title">
                {{ __('Delete Permission') }}
            </x-slot>
    
            <x-slot name="content">
                Are you sure you would like to delete this permission?
            </x-slot>
    
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('deletePermissionModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
    
                <x-jet-danger-button class="ml-2" wire:click="deletePermission()" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal> 
    @else
        <p class="font-light">No Role record found.</p>
    @endif
        
        
        <x-jet-dialog-modal wire:model="permissionFormModal">
            <x-slot name="title">
                {{ __('Update Permissions') }}
            </x-slot>
    
            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="permission_name" value="{{ __('Permission Name') }}" />
                    <x-jet-input id="permission_name" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="text" name="permission_name" value="{{old('permission_name', 1)}}" min="0" wire:model.debounce.500ms="permission_name" placeholder="Input permission Name" autofocus />
                    @error('permission_name') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>
    
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('permissionFormModal', false)" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-jet-secondary-button>
    
                <x-jet-button class="ml-2" wire:click="updatePermissions" wire:loading.attr="disabled">
                    {{ __('Confirm') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
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