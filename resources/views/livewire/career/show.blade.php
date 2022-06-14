<div>
    
    <div class="grid grid-cols-1">
        <div class="p-3 text-gray-700 shadow-xl">
            {{-- title --}}
            <h3 class="text-lg uppercase py-2">{{$career->position}}</h3>
            @if ($career->creator->name)                
                <p class="text-sm my-1 font-light"><i class="fas fa-user text-blue-500"></i> <span class="font-semibold">Author : </span> {{$career->creator->name}}</p>
            @endif
            @if ($career->location)                
                <p class="text-sm my-1 font-light"><i class="fas fa-user text-blue-500"></i> <span class="font-semibold">Location : </span> {{$career->location}}</p>
            @endif
            @if ($career->salary_range)                
                <p class="text-sm my-1 font-light"><i class="fas fa-user text-blue-500"></i> <span class="font-semibold">Salary : </span> {{$career->salary_range}}</p>
            @endif
            @if ($career->close_date)                
                <p class="text-sm my-1 font-light"><i class="fas fa-user text-blue-500"></i> <span class="font-semibold">Close Date : </span> {{$career->close_date}}</p>
            @endif
            {{-- Published --}}            
            <p class="text-sm my-1 font-light"><i class="far fa-share-square text-yellow-500"></i> <span class="font-semibold">Published : </span> {{ $career->publish ? 'Published' : 'Not Published' }}
                @if(auth()->user()->can('Manage Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                    @if (!$career->publish)
                        <a href="#" wire:click.prevent="confirmUpdateCareerPostStatus({{$career->id}})" class="text-gray-400 text-sm hover:text-green-600 active:text-green-600" title="Publish"> {{ !$career->publish ? 'Publish' : 'Unpublish' }} <i class="far fa-share-square"></i></a>                     
                    @else
                        <a href="#" wire:click.prevent="confirmUpdateCareerPostStatus({{$career->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600" title="Publish"> {{ !$career->publish ? 'Publish' : 'Unpublish' }} <i class="fas fa-ban"></i></a>
                    @endif
                @endif 
            </p>
            <div class="text-gray-600 font-light prose-sm py-5">
                {!!$career->description!!}
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2 justify-end md:px-4 py-3 bg-gray-50 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
        @if(auth()->user()->can('Edit Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
            <a href="{{route('careers.edit', Crypt::encrypt($career->id))}}">
                <x-jet-button title="Edit">
                    <i class="fa fa-edit"></i> &nbsp; Update
                </x-jet-button>
            </a>
        @endif
        @if(auth()->user()->can('Delete Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
            <x-jet-danger-button title="Subscribe" wire:click.prevent="confirmDeleteCareerPost({{$career->id}})" >
                <i class="fa fa-trash"></i> &nbsp; Delete
            </x-jet-danger-button>
        @endif
    </div>
    <x-jet-confirmation-modal wire:model="deleteCareerPostModal">
        <x-slot name="title">
            {{ __('Delete Career Post') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this Career Post?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteCareerPostModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteCareerPost({{$career->id}})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="updateCareerPostStatusModal">
        <x-slot name="title">
            {{ __('Delete Career Post') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to  update publish status of this Career Post?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('updateCareerPostStatusModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updateCareerPostStatus({{$career->id}})" wire:loading.attr="disabled">
                Update
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
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
