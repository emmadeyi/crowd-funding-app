<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    {{-- Be like water. --}}
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-file"></i> Project Details</p>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="col-span-2">
            <div class="grid grid-rows-2 gap-2 p-2 md:w-auto">
                @if (count($project->photo) > 0)
                    <div class="row-span-3 ">
                        <a href="{{asset('./storage/'.$project->photo->first()->url)}}" data-lightbox="project-image">
                            <img src="{{asset('./storage/'.$project->photo->first()->url)}}"   class="w-full rounded-lg" />                        
                        </a>
                    </div>
                @else
                    <div class="row-span-3 ">
                        <a href="{{asset('./imgs/demo/demo-img-07.jpg')}}" data-lightbox="project-image">
                            <img src="{{asset('./imgs/demo/demo-img-07.jpg')}}" class="w-full rounded-lg" />
                        </a>
                    </div>
                @endif
                @if (count($project->photo) > 1)                    
                    <div class="grid grid-cols-3 bg-transparent gap-2 grid-flow-row p-2 rounded shadow-lg">
                        @foreach ($project->photo as $photo)
                            <a href="{{asset('./storage/'.$photo->url)}}" data-lightbox="project-image">
                                <img src="{{asset('./storage/'.$photo->url)}}" class="rounded-lg" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="col-span-3 p-3 text-gray-700 shadow-xl">
            {{-- title --}}
            <h3 class="text-lg uppercase py-2">{{$project->title}} 
            
                @if (Auth::user()->status == 1)
                    @if(auth()->user()->can('Delete Project') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                        <x-jet-danger-button title="Delete" class="ml-2" wire:click.prevent="confirmDeleteProject({{$project->id}})" >
                            <i class="fa fa-trash"></i> <span class="ml-2">Delete</span>
                        </x-jet-danger-button>
                    @endif
                @endif
            </h3>
            @if ($project->creator)                
                <p class="text-sm font-light"><i class="fas fa-user text-blue-500"></i><span class="font-semibold mx-2">Author : </span> {{$project->creator->name}}</p>
            @endif

            {{-- Execution Cost --}}
            <p class="text-sm font-light"><i class="fas fa-money-bill-alt text-green-500"></i><span class="font-semibold mx-2">Start-Up Cost : </span> <span class="line-through">N</span>{{number_format($project->execution_cost,2)}}</p>
            {{-- Duration --}}
            <p class="text-sm font-light"><i class="fas fa-business-time text-red-400"></i><span class="font-semibold mx-2">Set Up Duration : </span> {{$project->duration}} <span class="italic">(Days)</span></p>
            
            @if ($checkROIDetailsState)
                <p class="text-sm font-light"><i class="far fa-calendar-alt text-red-300"></i></i><span class="font-semibold mx-2">Launch Date : </span> {{ \Carbon\Carbon::parse($project->execution_start_date)->format('d/m/Y')}} </p>
                {{-- <p class="text-sm font-light"><i class="fas fa-percent text-green-500"></i></i><span class="font-semibold mx-2">ROI : </span> {{$project->roi_percent}} <span class="italic">(%)</span></p> --}}
                <p class="text-sm font-light"><i class="fas fa-credit-card text-gray-500"></i></i><span class="font-semibold mx-2">Min Investment : </span> </span> <span class="line-through">N</span>{{number_format($project->min_investment,2)}} </span></p>
                <p class="text-sm font-light"><i class="fas fa-hourglass-half text-blue-500"></i><span class="font-semibold mx-2">Payment Cycle : </span> {{$project->payment_cycle}} <span class="italic">(Days)</span></p>
                <p class="text-sm font-light"> <i class="fas fa-money-check text-yellow-500"></i></i><span class="font-semibold mx-2">Payment Starts : </span> {{$project->payment_starts}} <span class="italic">(Days) after launching</span></p>
            @endif
            
            <div class="my-2 p-1 bg-gray-100 bg-opacity-50"></div>
            {{-- Approval --}}
            <p class="text-sm font-light"><i class="far fa-thumbs-up text-blue-500"></i><span class="font-semibold mx-2">Approval : </span> {{ $project->approved ? 'Approved' : 'Not Approved' }}
            
                @if (Auth::user()->status == 1)
              
                    @if(auth()->user()->can('Manage Project') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                        @if (!$project->approved)
                            <a href="#" wire:click.prevent="confirmApproveProject({{$project->id}})" class="text-gray-400 text-sm hover:text-green-600 active:text-green-600" title="Publish"> {{ !$project->approved ? 'Approve' : 'Disapprove' }} <i class="far fa-thumbs-up"></i></a>                     
                        @else
                            <a href="#" wire:click.prevent="confirmApproveProject({{$project->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600" title="Publish"> {{ !$project->approved ? 'Approve' : 'Disapprove' }} <i class="far fa-thumbs-down"></i></a>
                        @endif
                    @endif
                @endif
                </p>
                {{-- Published --}}            
                <p class="text-sm font-light"><i class="far fa-share-square text-yellow-500"></i><span class="font-semibold mx-2">Published : </span> {{ $project->published ? 'Published' : 'Not Published' }} 
                    
                    @if (Auth::user()->status == 1)
                        @if(auth()->user()->can('Manage Project') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                            @if (!$project->published)
                                <a href="#" wire:click.prevent="confirmPublishProject({{$project->id}})" class="text-gray-400 text-sm hover:text-green-600 active:text-green-600" title="Publish"> {{ !$project->published ? 'Publish' : 'Unpublish' }} <i class="far fa-share-square"></i></a>                     
                            @else
                                <a href="#" wire:click.prevent="confirmPublishProject({{$project->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600" title="Publish"> {{ !$project->published ? 'Publish' : 'Unpublish' }} <i class="fas fa-ban"></i></a>
                            @endif
                        @endif                  
                    @endif
                </p>
            
            @if (Auth::user()->status == 1)
                @if(auth()->user()->can('Manage Project') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                    @if (count($this->project->projectSubscription) <= 0)                
                        <p class="py-4">
                            <x-jet-button title="Update ROI Details" wire:click.prevent="showROIDetailsModal({{$project->id}})" >
                                <i class="fas fa-file-invoice-dollar"></i> <span class="ml-2">Update ROI Details</span>
                            </x-jet-button>                    
                        </p>
                    @endif
                @endif    
            @endif
            {{-- description --}}
            <p class="text-sm font-light py-4">
                {{$project->description}}
            </p>
            {{-- Project Documents --}}
            @if ($project->file->count() > 0)
                @foreach($project->file as $file)
                    <p class="py-2 font-light"><i class="fa fa-file-pdf text-red-400"></i> <a href="{{asset('./storage/'.$file->url)}}">Project Document {{$loop->iteration}}</a></p>
                @endforeach
            @endif
        </div>
    </div>
    
    @if (Auth::user()->status == 1)
        @if(auth()->user()->canany(['Edit Project', 'Create Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
            <div class="bg-transparent flex items-center gap-2 justify-end md:px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">  
                @if(Auth::user()->id == $project->id || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))      
                    <x-jet-button title="Edit" wire:click.prevent="confirmUpdateProject({{$project->id}})" >
                        <i class="fa fa-edit"></i> <span class="ml-2">Update</span>
                    </x-jet-button>
                @endif
                @if($project->published) 
                    @if(auth()->user()->can('Create Subscription') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                        <x-info-button title="Subscribe" wire:click.prevent="confirmSubscribeProject({{$project->id}})" >
                            <i class="fa fa-credit-card"></i> 
                            <span class="ml-2">
                                Subscribe
                            </span>
                        </x-info-button>
                    @endif
                @endif
            </div>
        @endif
    @else
        <p class="text-red-400 px-2 py-5 font-semibold">
            Account is pending Activation. Please contact Administrator. 
        </p>                    
    @endif
    <x-jet-dialog-modal wire:model="roiDetailsModal">
        <x-slot name="title">
            {{ __('Update ROI Details') }}
        </x-slot>
        
        <x-slot name="content">            
            <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="execution_start_date" value="{{ __('Launch Date (Approx.)') }}" />
                <x-jet-input id="execution_start_date" class="block mt-1 w-full" type="date" name="execution_start_date" :value="old('execution_start_date')" required autofocus autocomplete="execution_start_date" wire:model.debounce.500ms="execution_start_date" />
                @error('execution_start_date') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
            {{-- 
            <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="roi_percentage" value="{{ __('ROI Percentage (%)') }}" />
                <x-jet-input id="roi_percentage" class="block mt-1 w-full" type="number" name="roi_percentage" :value="old('roi_percentage')" required autofocus autocomplete="roi_percentage" wire:model.debounce.500ms="roi_percentage" />
                @error('roi_percentage') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
            --}}
            <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="min_investment" value="{{ __('Min Amount (Naira)') }}" />
                <x-jet-input id="min_investment" class="block mt-1 w-full" type="number" name="min_investment" :value="old('min_investment')" required autofocus autocomplete="min_investment" wire:model.debounce.500ms="min_investment" />
                @error('min_investment') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="payment_cycle" value="{{ __('Payment Cycle (Days)') }}" />
                <x-jet-input id="payment_cycle" class="block mt-1 w-full" type="number" name="payment_cycle" :value="old('payment_cycle')" required autofocus autocomplete="payment_cycle" wire:model.debounce.500ms="payment_cycle" />
                @error('payment_cycle') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="payment_start" value="{{ __('Payment Starts in x (Days)') }}" />
                <x-jet-input id="payment_start" class="block mt-1 w-full" type="number" name="payment_start" :value="old('payment_start')" required autofocus autocomplete="payment_start" wire:model.debounce.500ms="payment_start" />
                @error('payment_start') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('roiDetailsModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
            <x-jet-button wire:click="saveROIDetails">
                {{ __('Save')}}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-confirmation-modal wire:model="updateProjectModal">
        <x-slot name="title">
            {{ __('Update Project') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to  update this Project?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('updateProjectModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updateProjectRedirect({{$project->id}})" wire:loading.attr="disabled">
                {{ __('Update Project') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="subcribeProjectModal">
        <x-slot name="title">
            {{ __('Subscribe to Project') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to subscribe to this Project?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('subcribeProjectModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="subscribeProjectRedirect({{$project->id}})" wire:loading.attr="disabled">
                {{ __('Subscribe Project') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="deleteProjectModal">
        <x-slot name="title">
            {{ __('Delete Project') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this Project?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteProjectModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteProject({{$project->id}})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="approveProjectModal">
        <x-slot name="title">
            {{ __('Approve Project') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to update approved status of this Project?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('approveProjectModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="approveProject({{$project->id}})" wire:loading.attr="disabled">
                Update
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="publishProjectModal">
        <x-slot name="title">
            {{ __('Publish Project') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to update publish status of this Project?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('publishProjectModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="publishProject({{$project->id}})" wire:loading.attr="disabled">
                Update
            </x-jet-button>
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

