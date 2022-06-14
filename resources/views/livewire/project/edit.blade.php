<div>
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fas fa-marker"></i> Update Project Details </p>
    <div class="px-4 sm:px-0">
        <form wire:submit.prevent="submitData"> 
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div> 
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <x-jet-input id="title" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="text" name="title" :value="old('title', $project->title)" required wire:model.debounce.500ms="title" autofocus />
                    @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-jet-label for="execution_cost" value="{{ __('Execution Cost in Naira (Optional)') }}" />
                    <x-jet-input id="execution_cost" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="number" name="execution_cost" value="{{old('execution_cost', 0)}}" min="0" wire:model.debounce.500ms="execution_cost" autofocus />
                    @error('execution_cost') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-jet-label for="duration" value="{{ __('Execution Duration in Days (optional)') }}" />
                    <x-jet-input id="duration" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="number" name="duration" value="{{old('duration', 0)}}" min="0" wire:model.debounce.500ms="duration" autofocus />
                    @error('duration') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <x-jet-label for="files" value="{{ __('Project file(s) PDF or MS WORD') }}" />
                    <x-jet-input id="files" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="file" name="files" wire:model.debounce.500ms="files" multiple autofocus />
                    <div wire:loading wire:target="files">Uploading <i wire:loading wire:target="files" class="fas fa-spinner fa-pulse"></i></div>
                    @error('files.*') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div x-data="{ isUploadingPhoto: false, progress: 0 }"
                x-on:livewire-upload-start="isUploadingPhoto = true"
                x-on:livewire-upload-finish="isUploadingPhoto = false"
                x-on:livewire-upload-error="isUploadingPhoto = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                @if (count($photos) > 0)
                    @foreach ($photos as $photo)                    
                    <img src="{{$photo->temporaryUrl()}}" width="200" alt="" class="m-b-20 rounded" />                    
                    @endforeach
                @endif
                    <x-jet-label for="photos" value="{{ __('Project Image') }}" />
                    <x-jet-input id="photos" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="file" name="photos" wire:model.debounce.500ms="photos" multiple autofocus />
                    <div wire:loading wire:target="photos">Uploading <i wire:loading wire:target="photos" class="fas fa-spinner fa-pulse"></i></div>
                    @error('photos.*') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 py-4">
                <div>
                    <x-jet-label for="description" value="{{ __('Project Details') }}" />
                    <textarea id="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50"name="description" required autofocus autocomplete="description" wire:model.debounce.500ms="description" rows="5"> </textarea>
                    @error('description') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                <x-jet-button class="" wire:loading.attr="disabled">
                    {{ __('Submit') }}
                </x-jet-button>
            </div>
        </form>
    </div>
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