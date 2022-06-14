<div>
    <div class="max-w-7xl mx-auto px-2 py-1 md:py-2 sm:px-2 lg:px-4 font-light">
        <x-jet-form-section submit="saveIdentityInformation">
            <x-slot name="title">
                {{ __('Identity Information') }}
            </x-slot>
        
            <x-slot name="description">
                {{ __('Update your identity information. Includes ') }} <span class="italic">
                    (Date of birth, Sex, Nationality, State of origin, Marital status, NIN, Passport Photograph, Identification Card)
                </span>
                @if ($this->passport_photo)                        
                    <div class="p-2 mt-3">
                        <img src="{{asset('./storage/'.$user->identificationDetails->passport_photo)}}" width="200" alt="" class="m-b-20 rounded" /> 
                    </div>
                @endif
            </x-slot>
        
            <x-slot name="form">
                <!-- DOB -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="dob" value="{{ __('DOB') }}" />
                    <x-jet-input id="dob" type="date" class="mt-1 block w-full" wire:model.defer="dob" autocomplete="dob" />
                    @error('dob') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
        
                <!-- Gender -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="gender" value="{{ __('Gender') }}" />
                    <select class="mt-1 block w-full border-gray-200 focus:border-gray-300 focus:ring focus:ring-gray-200 text-gray-700 focus:ring-opacity-50 rounded-md  sm:text-sm sm:leading-5 pointer" wire:model.defer="gender">
                        <option class="py-2 px-1" value="">Select</option>    
                        <option class="py-2 px-1" value="M">Male</option>    
                        <option class="py-2 px-1" value="F">Female</option>    
                    </select>
                    @error('gender') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                {{-- Marital Status --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="marital_status" value="{{ __('Marital Status') }}" />
                    <select class="mt-1 block w-full border-gray-200 focus:border-gray-300 focus:ring focus:ring-gray-200 text-gray-700 focus:ring-opacity-50 rounded-md  sm:text-sm sm:leading-5 pointer" wire:model.defer="marital_status">
                        <option class="py-2 px-1" value="">Select</option> 
                        <option class="py-2 px-1" value="S">Single</option>    
                        <option class="py-2 px-1" value="M">Married</option>    
                        <option class="py-2 px-1" value="D">Divorced</option>    
                    </select>
                    @error('marital_status') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <!-- Nationality -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="nationality" value="{{ __('Nationality') }}" />
                    <x-jet-input id="nationality" type="text" class="mt-1 block w-full" wire:model.defer="nationality" autocomplete="nationality" />
                    @error('nationality') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <!-- State of origin -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="state_of_origin" value="{{ __('State of origin') }}" />
                    <x-jet-input id="state_of_origin" type="text" class="mt-1 block w-full" wire:model.defer="state_of_origin" autocomplete="state_of_origin" />
                    @error('state_of_origin') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <!-- NIN -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="nin" value="{{ __('NIN') }}" />
                    <x-jet-input id="nin" type="text" class="mt-1 block w-full" wire:model.defer="nin" autocomplete="nin" />
                    @error('nin') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <!-- Qualification -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="qualification" value="Qualification (E.g School Cert, BSc, Masters, Others etc.)" />
                    <x-jet-input id="qualification" type="text" class="mt-1 block w-full" wire:model.defer="qualification" autocomplete="qualification" />
                    @error('qualification') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                
                
                <div class="col-span-6 sm:col-span-4" x-data="{ isUploadingPhoto: false, progress: 0 }"
                x-on:livewire-upload-start="isUploadingPhoto = true"
                x-on:livewire-upload-finish="isUploadingPhoto = false"
                x-on:livewire-upload-error="isUploadingPhoto = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">                
                @if ($passport_photo_temp)
                <img src="{{$passport_photo_temp->temporaryUrl()}}" width="200" alt="" class="m-b-20 rounded" />  
                @endif
                <x-jet-label for="passport_photo_temp" value="{{ __('Passport Photo') }}" />
                <x-jet-input id="passport_photo_temp" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="file" name="passport_photo_temp" wire:model.debounce.500ms="passport_photo_temp"/>
                <div wire:loading wire:target="passport_photo_temp">Uploading <i wire:loading wire:target="passport_photo_temp" class="fas fa-spinner fa-pulse"></i></div>
                @error('passport_photo_temp') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6 sm:col-span-4" x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <x-jet-label for="id_card" value="{{ __('Identity Card') }}" />
                    <x-jet-input id="id_card" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="file" name="id_card" wire:model.debounce.500ms="id_card"/>
                    <div wire:loading wire:target="id_card">Uploading <i wire:loading wire:target="id_card" class="fas fa-spinner fa-pulse"></i></div>
                    @error('id_card.*') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>
        
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
        
                <x-jet-button wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
    <div class="max-w-7xl mx-auto px-2 py-2 md:py-2 sm:px-2 lg:px-4 font-light">
        <x-jet-form-section submit="saveContactInformation">
            <x-slot name="title">
                {{ __('Contact Information') }}
            </x-slot>
        
            <x-slot name="description">
                {{ __('Update your bank information. Includes ') }} <span class="italic">
                    (Phone, Address, State, Country)
                </span>
            </x-slot>
        
            <x-slot name="form">
                <!-- Phone -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="phone" value="{{ __('Phone') }}" />
                    <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="phone" autocomplete="phone" />
                    @error('phone') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
        
                <!-- Address -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="address" value="{{ __('Address') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="address" />
                    @error('address') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- State -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="state" value="{{ __('State') }}" />
                    <x-jet-input id="state" type="text" class="mt-1 block w-full" wire:model.defer="state" />
                    @error('state') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Country -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="country" value="{{ __('Country') }}" />
                    <x-jet-input id="country" type="text" class="mt-1 block w-full" wire:model.defer="country" />
                    @error('country') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>
        
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
        
                <x-jet-button wire:loading.attr="disabled" >
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
    <div class="max-w-7xl mx-auto px-2 py-2 md:py-2 sm:px-2 lg:px-4 font-light">
        <x-jet-form-section submit="saveBvnInformation">
            <x-slot name="title">
                {{ __('Bank Information') }}
            </x-slot>
        
            <x-slot name="description">
                {{ __('Update your bank information. Includes ') }} <span class="italic">
                    (Bank, Account Number, BVN )
                </span>
                <p class="font-semibold text-red-400 p-2 italic">Please Enter valid bank details. </p>
            </x-slot>
        
            <x-slot name="form">
                <!-- Bank -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="bank" value="Banl (E.g First Bank)" />
                    <x-jet-input id="bank" type="text" class="mt-1 block w-full" wire:model.defer="bank" autocomplete="bank" />
                    @error('bank') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <!-- Account Number -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="account_number" value="{{ __('Account Number') }}" />
                    <x-jet-input id="account_number" type="text" class="mt-1 block w-full" wire:model.defer="account_number" autocomplete="account_number" />
                    @error('account_number') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <!-- BVN -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="bvn" value="{{ __('BVN') }}" />
                    <x-jet-input id="bvn" type="text" class="mt-1 block w-full" wire:model.defer="bvn" autocomplete="bvn" />
                    @error('bvn') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>
        
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
        
                <x-jet-button wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
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