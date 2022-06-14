<div class="bg-white overflow-hidden sm:rounded-lg">    
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif            
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-newspaper"></i> Blog Posts | {{ $posts->count()}} </p>
    @if ($posts->count() > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Title</th></th>
                {{-- <th class="px-3 py-2 md:border">Body</th> --}}
                <th class="px-3 py-2 md:border">Status</th>
                <th class="px-3 py-2 md:border">Created At</th>
                <th class="px-3 py-2 md:border">Action</th>
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($posts as $post) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>   
                        @if(auth()->user()->can('Read Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))                 
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Title</span> <span class="w-2/3 text-left"><a href="{{route('posts.show', Crypt::encrypt($post->id))}}">{!! \Illuminate\Support\Str::words(strip_tags($post->title), 5)  !!}</a></span>
                            </td>
                        @else
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Title</span> <span class="w-2/3 text-left">{!! \Illuminate\Support\Str::words(strip_tags($post->title), 5)  !!}</span>
                            </td>
                        @endif
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Status</span> <span class="w-2/3 text-left">
                                @if (!$post->status)
                                    Not Published                  
                                @else
                                    Published
                                @endif 
                            </span>
                        </td>                        
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Date</span> <span class="w-2/3 text-left">
                                {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}}
                            </span>
                        </td>                        
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> #</span> <span class="w-2/3 text-left">
                                @if(auth()->user()->can('Manage Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                                    @if (!$post->status)
                                        <a href="#" wire:click.prevent="confirmUpdatePostStatus({{$post->id}})" class="text-gray-400 text-sm hover:text-green-600 active:text-green-600" title="Publish">
                                            <x-jet-secondary-button>
                                                <i class="fa fa-share"></i>
                                            </x-jet-secondary-button>
                                        </a>                     
                                    @else
                                        <a href="#" wire:click.prevent="confirmUpdatePostStatus({{$post->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600" title="Publish">
                                            <x-jet-secondary-button>
                                                <i class="fa fa-ban"></i>
                                            </x-jet-secondary-button>
                                        </a>
                                    @endif 
                                @endif
                                @if(auth()->user()->can('Read Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                                    <a href="{{route('posts.show', Crypt::encrypt($post->id))}}">
                                        <x-jet-secondary-button>
                                            <i class="fa fa-info"></i>
                                        </x-jet-secondary-button>
                                    </a> 
                                @endif
                                @if(auth()->user()->can('Edit Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                                    <a href="{{route('blogs.edit', Crypt::encrypt($post->id))}}">
                                        <x-jet-secondary-button>
                                            <i class="fa fa-edit"></i>
                                        </x-jet-secondary-button>
                                    </a> 
                                @endif
                                @if(auth()->user()->can('Delete Post') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|')) 
                                    <a href="#" wire:click.prevent="confirmDeletePost({{$post->id}})" class="text-gray-400 text-sm hover:text-red-600 active:text-red-600">
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
            {{ $posts->links() }}  
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
                {{ __('Update Post') }}
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
    @else
        <p class="font-light">No post record found.</p>
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
