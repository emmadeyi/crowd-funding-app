<div class="bg-white overflow-hidden sm:rounded-lg">      
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif           
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-newspaper"></i> Job Posts | {{ $careers->count()}} </p>
    @if ($careers->count() > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Position</th>
                <th class="px-3 py-2 md:border">Salary Range</th>
                <th class="px-3 py-2 md:border">Close_date</th>
                <th class="px-3 py-2 md:border">Status</th>
                <th class="px-3 py-2 md:border">Created At</th>
                <th class="px-3 py-2 md:border">Action</th>
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($careers as $career) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>  
                        @if(auth()->user()->can('Read Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))                  
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Position</span> <span class="w-2/3 text-left"><a href="{{route('careers.show-career', Crypt::encrypt($career->id))}}">{!! \Illuminate\Support\Str::words(strip_tags($career->position), 5)  !!}</a></span>
                            </td>
                        @else                        
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Position</span> <span class="w-2/3 text-left">{!! \Illuminate\Support\Str::words(strip_tags($career->position), 5)  !!}</span>
                            </td> 
                        @endif                       
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Salary Range</span> <span class="w-2/3 text-left">
                                {{$career->salary_range}}
                            </span>
                        </td>                       
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Close_date</span> <span class="w-2/3 text-left">
                                {{ \Carbon\Carbon::parse($career->close_date)->diffForHumans()}}
                            </span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Status</span> <span class="w-2/3 text-left">
                                @if (!$career->publish)
                                    Not Published                  
                                @else
                                    Published
                                @endif 
                            </span>
                        </td>                       
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Date</span> <span class="w-2/3 text-left">
                                {{ \Carbon\Carbon::parse($career->created_at)->diffForHumans()}}
                            </span>
                        </td>                        
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> #</span> <span class="w-2/3 text-left">
                                @if(auth()->user()->can('Manage Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))      
                                    @if (!$career->publish)
                                        <a href="#" wire:click.prevent="confirmUpdateCareerStatus({{$career->id}})" class="text-gray-400 text-sm hover:text-green-600 active:text-green-600" title="Publish">
                                            <x-jet-secondary-button>
                                                <i class="fa fa-share"></i>
                                            </x-jet-secondary-button>
                                        </a>                     
                                    @else
                                        <a href="#" wire:click.prevent="confirmUpdateCareerStatus({{$career->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600" title="Publish">
                                            <x-jet-secondary-button>
                                                <i class="fa fa-ban"></i>
                                            </x-jet-secondary-button>
                                        </a>
                                    @endif 
                                @endif
                                @if(auth()->user()->can('Read Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))      
                                    <a href="{{route('careers.show-career', Crypt::encrypt($career->id))}}">
                                        <x-jet-secondary-button>
                                            <i class="fa fa-info"></i>
                                        </x-jet-secondary-button>
                                    </a> 
                                @endif
                                @if(auth()->user()->can('Edit Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))      
                                    <a href="{{route('careers.edit', Crypt::encrypt($career->id))}}">
                                        <x-jet-secondary-button>
                                            <i class="fa fa-edit"></i>
                                        </x-jet-secondary-button>
                                    </a> 
                                @endif
                                @if(auth()->user()->can('Delete Career') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                    <a href="#" wire:click.prevent="confirmDeleteCareer({{$career->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600">
                                        <x-jet-secondary-button>
                                            <i class="fa fa-trash"></i>
                                        </x-jet-secondary-button>
                                    </a>
                                @endif
                            </span>
                        </td>                        
                    </tr>   
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $careers->links() }}  
        </div> 
        <x-jet-confirmation-modal wire:model="deleteCareerModal">
            <x-slot name="title">
                {{ __('Delete Career') }}
            </x-slot>
    
            <x-slot name="content">
                {{ __('Are you sure you would like to delete this Career?') }}
            </x-slot>
    
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('deleteCareerModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
    
                <x-jet-danger-button class="ml-2" wire:click="deleteCareer({{$career->id}})" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
        <x-jet-confirmation-modal wire:model="updateCareerStatusModal">
            <x-slot name="title">
                {{ __('Update Career') }}
            </x-slot>
    
            <x-slot name="content">
                Are you sure you would like to  update publish status of this Career?
            </x-slot>
    
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('updateCareerStatusModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
    
                <x-jet-button class="ml-2" wire:click="updateCareerStatus({{$career->id}})" wire:loading.attr="disabled">
                    Update
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @else
        <p class="font-light">No career record found.</p>
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
