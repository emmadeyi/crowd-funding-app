<div>
    <div x-data="{ isUploadingPhoto: false, progress: 0 }"
        x-on:livewire-upload-start="isUploadingPhoto = true"
        x-on:livewire-upload-finish="isUploadingPhoto = false"
        x-on:livewire-upload-error="isUploadingPhoto = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">
        @if ($photo)                
            <img src="{{$photo->temporaryUrl()}}" width="200" alt="" class="m-b-20 rounded" />
        @endif
        <x-jet-label for="photo" value="{{ __('Post Image') }}" />
        <x-jet-input id="photo" class="block mt-1 md:w-1/2 focus:border-gray-300 focus:ring focus:ring-gray-200" type="file" name="photo" wire:model.debounce.500ms="photo" autofocus />
        <div wire:loading wire:target="photo">Uploading <i wire:loading wire:target="photo" class="fas fa-spinner fa-pulse"></i></div>
            @error('photo') <span class="error text-red-500">{{ $message }}</span> @enderror
    </div>
    <div class="col-span-6 sm:col-span-4 my-4">
        <x-jet-label for="title" value="{{ __('Title') }}" />
        <x-jet-input id="title" class="block mt-1 md:w-1/2" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" wire:model.debounce.500ms="title" />
        @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
    </div>
    <div wire:ignore class="col-span-6 sm:col-span-4">
        <x-jet-label for="editor" value="{{ __('Body') }}" />
        <textarea id="editor" class="block mt-1 w-1/2 rounded-md shadow-sm border-gray-300 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" name="body" required autofocus autocomplete="body" wire:model.lazy="body" rows="3" data-body="@this"> </textarea> 
        @error('body') <span class="error text-red-500">{{ $message }}</span> @enderror
    </div>
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
        <button wire:click="savePost" id="save_post" type='submit' class='inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-yellow-300 uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' >
            {{ __('Save')}}
        </button>
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
    
    <script>
        ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    // editor.model.document.on('change:data', () => {
                    //     let body = $('#editor').data('body')
                    //     eval(body).set('body', editor.getData());
                    // })
                    document.querySelector('#save_post').addEventListener('click', () => {
                        let body = $('#editor').data('body')
                        eval(body).set('body', editor.getData());
                        console.log(editor.getData());
                    })
                } )
                .catch( error => {
                        console.error( error );
                } );
    </script>
@endsection
