<div class="bg-white overflow-hidden sm:rounded-lg"> 
    
    @if ($projects->count() > 0)
        @foreach ($projects as $project)
            <div class="block">
                <div class="flex flex-col md:flex-row md:max-w-4xl max-w-sm mx-auto font-medium border-gray-500 my-5 shadow-lg rounded-lg overflow-hidden">
                    @if (count($project->photo) > 0)
                        <div class="p-4 md:w-1/3">
                            <img src="{{asset('./storage/'.$project->photo->first()->url)}}" class="w-full rounded-lg" />
                        </div>
                    @else
                        <div class="p-4 md:w-1/3">
                            <img src="{{asset('./imgs/demo/demo-img-07.jpg')}}" class="w-full rounded-lg" />
                        </div>
                    @endif
                    {{-- <div class="p-4 md:w-1/2">
                        <img src="{{asset('./imgs/demo/demo-img-01.jpg')}}" class="w-full rounded-lg" />
                    </div> --}}
                    <div class="p-4 md:w-2/3 h-full ">
                        <div class="flex flex-col justify-between text-sm ">
                            <div class="text-xl font-bold text-yellow-500 uppercase">
                                <a href="{{route('projects.details', $project->id)}}">{{$project->title}}</a>                                
                            </div>
                            <p class="my-2 text-gray-700 text-justify font-light">
                                {!! \Illuminate\Support\Str::words($project->description, 20)  !!}
                            </p>
                            <div class="text-gray-700 text-justify font-light">
                                <p class="my-1">
                                    <span class="font-semibold">Approved: </span> {{ $project->approved ? 'Yes' : 'No' }}
                                </p>
                                <p class="my-1">
                                    <span class="font-semibold">Published: </span> {{ $project->published ? 'Yes' : 'No' }}
                                </p>
                            </div>
                            
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                            <x-jet-secondary-button title="Edit"  wire:click.prevent="confirmUpdateProject({{$project->id}})" >
                                <i class="fa fa-edit"></i> 
                            </x-jet-secondary-button>
                            <x-jet-button title="{{ $project->published ? 'Unpublish' : 'Publish' }}" class="ml-2" wire:click.prevent="confirmPublishProject({{$project->id}})" >
                                <i class="{{ $project->published ? 'fa fa-ban' : 'far fa-share-square' }} "></i> 
                            </x-jet-button>
                            <x-info-button title="{{ $project->approved ? 'Unapprove' : 'Approve' }}" class="ml-2" wire:click.prevent="confirmApproveProject({{$project->id}})" >
                                <i class="far {{ $project->approved ? 'fa-thumbs-down' : 'fa-thumbs-up' }} "></i>                              
                            </x-info-button>
                            <x-jet-danger-button title="Delete" class="ml-2" wire:click.prevent="confirmDeleteProject({{$project->id}})" >
                                <i class="fa fa-trash"></i> 
                            </x-jet-danger-button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach    
        {{ $projects->links() }}        
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
    @else
        <p>No record found</p>
    @endif
</div>
@section('project-content')
    
@endsection
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
    