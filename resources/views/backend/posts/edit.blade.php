<x-app-layout>
    <x-slot name="header">
        {{ __('Blog') }}
    </x-slot>
    @section('side-nav')        
        @livewire('blog.side-nav')
    @endsection
    @section('content-div')                                  
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-newspaper"></i> Edit Posts | {{$post->title}} </p>
        <form class="image-upload" method="post" action="{{ route('blogs.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <div>
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="thumbnail" value="{{ __('Post Image') }}" />
                    <x-jet-input id="thumbnail" class="block mt-1 md:w-1/2 focus:border-gray-300 focus:ring focus:ring-gray-200" type="file" name="thumbnail" autofocus />
                    @error('thumbnail') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <x-jet-input id="title" class="block mt-1 md:w-1/2" type="text" name="title" value="{{old('title', $post->title)}}" required autofocus autocomplete="title" />
                    @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="editor" value="{{ __('Body') }}" />
                    <textarea id="editor" class="tinymce-editor block mt-1 w-1/2 rounded-md shadow-sm border-gray-300 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" name="body" required autofocus autocomplete="body"> {{old('body', $post->body)}} </textarea> 
                    @error('body') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div> 
                <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <button id="save_post" type='submit' class='inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-yellow-300 uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' >
                        {{ __('Save')}}
                    </button> 
                </div>
            </div> 
        </form>
    @endsection
</x-app-layout>