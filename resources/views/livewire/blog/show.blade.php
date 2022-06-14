<div>
    
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="col-span-2">
            <div class="row-span-3 ">
                @if ($post->image)     
                    <a href="{{asset('./storage/'.$post->image)}}" data-lightbox="project-image">               
                        <img src="{{asset('./storage/'.$post->image)}}" class="w-full rounded-lg" /> 
                    </a>
                @else      
                    <a href="{{asset('./imgs/demo/demo-img-03.jpg')}}" data-lightbox="project-image">                   
                        <img src="{{asset('./imgs/demo/demo-img-03.jpg')}}" class="w-full rounded-lg" />
                    </a>
                @endif
            </div>
        </div>
        <div class="col-span-3 p-3 text-gray-700 shadow-xl">
            {{-- title --}}
            <h3 class="text-lg uppercase py-2">{{$post->title}}</h3>
            @if ($post->creator->name)                
                <p class="text-sm font-light"><i class="fas fa-user text-blue-500"></i> <span class="font-semibold">Author : </span> {{$post->creator->name}}</p>
            @endif
            {{-- Published --}}            
            <p class="text-sm font-light"><i class="far fa-share-square text-yellow-500"></i> <span class="font-semibold">Published : </span> {{ $post->status ? 'Published' : 'Not Published' }}
                @if(auth()->user()->can('Manage Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))  
                    @if (!$post->status)
                        <a href="#" wire:click.prevent="confirmUpdatePostStatus({{$post->id}})" class="text-gray-400 text-sm hover:text-green-600 active:text-green-600" title="Publish"> {{ !$post->status ? 'Publish' : 'Unpublish' }} <i class="far fa-share-square"></i></a>                     
                    @else
                        <a href="#" wire:click.prevent="confirmUpdatePostStatus({{$post->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600" title="Publish"> {{ !$post->status ? 'Publish' : 'Unpublish' }} <i class="fas fa-ban"></i></a>
                    @endif 
                @endif
            </p>
            <div class="text-gray-600 font-light prose-sm py-5">
                {!!$post->body!!}
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2 justify-end md:px-4 py-3 bg-gray-50 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
        @if(auth()->user()->can('Edit Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
            <a href="{{route('blogs.edit', Crypt::encrypt($post->id))}}">
                <x-jet-button title="Edit">
                    <i class="fa fa-edit"></i> &nbsp; Update
                </x-jet-button>
            </a>
        @endif
        @if(auth()->user()->can('Delete Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
            <x-jet-danger-button title="Subscribe" wire:click.prevent="confirmDeletePost({{$post->id}})" >
                <i class="fa fa-trash"></i> &nbsp; Delete
            </x-jet-danger-button>
        @endif
    </div>
    <x-jet-confirmation-modal wire:model="deletePostModal">
        <x-slot name="title">
            {{ __('Delete Post') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this Post?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deletePostModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deletePost({{$post->id}})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="updatePostStatusModal">
        <x-slot name="title">
            {{ __('Delete Post') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to  update publish status of this Post?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('updatePostStatusModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updatePostStatus({{$post->id}})" wire:loading.attr="disabled">
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
