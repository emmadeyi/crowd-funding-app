<x-app-layout>
    <x-slot name="header">
        {{ __('Career') }}
    </x-slot>
    @section('side-nav')        
        @livewire('career.side-nav')
    @endsection
    @section('content-div')    
        <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-folder"></i> New Job Post </p>
        <form class="image-upload" method="post" action="{{ route('careers.update', $career->id) }}" >
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <div>
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="position" value="{{ __('Position') }}" />
                    <x-jet-input id="position" class="block mt-1 md:w-1/2" type="text" name="position" value="{{old('position', $career->position)}}" required autofocus autocomplete="position" />
                    @error('position') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="location" value="{{ __('Location') }}" />
                    <x-jet-input id="location" class="block mt-1 md:w-1/2" type="text" name="location" value="{{old('location', $career->location)}}" required autofocus autocomplete="location" />
                    @error('location') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="salary" value="Salary (e.g 100,000 NGN or 50,000 NGN - 300,000 NGN)" />
                    <x-jet-input id="salary" class="block mt-1 md:w-1/2" type="text" name="salary_range" value="{{old('salary_range', $career->salary_range)}}" autofocus autocomplete="salary_range" />
                    @error('salary_range') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6 sm:col-span-4 my-4">
                    <x-jet-label for="close_date" value="{{ __('Close Date') }}" />
                    <x-jet-input id="close_date" class="block mt-1 md:w-1/2" type="date" name="close_date" value="{{old('close_date', $career->close_date)}}" required autofocus autocomplete="close_date" />
                    @error('close_date') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex border-r border-gray-400 cursor-pointer p-2 w-auto mt-2 hover:bg-gray-100">
                    <x-jet-input id="publish" class="block mr-1 focus:border-gray-400 focus:ring focus:ring-gray-400 cursor-pointer" type="checkbox" value="{{$career->publish}}" name="publish" />
                    <x-jet-label class="cursor-pointer" for="publish" value="Publish?" /> 
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="editor" value="{{ __('Description') }}" />
                    <textarea id="editor" class="tinymce-editor block mt-1 w-1/2 rounded-md shadow-sm border-gray-300 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" name="description" required autofocus autocomplete="description"> {{old('description', $career->description)}} </textarea> 
                    @error('description') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div> 
                <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <button id="save_post" type='submit' class='inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-yellow-300 uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' >
                        {{ __('Save')}}
                    </button> 
                </div>
            </div> 
        </form>
        
           
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
    @endsection
</x-app-layout>