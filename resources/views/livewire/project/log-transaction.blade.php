<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    @if($msg != null or $msg != '')
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ $msg }}</p>
    @endif 
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-calculator"></i> Log Transaction </p>
    <div class="px-4 sm:px-0">
        <form wire:submit.prevent="confirmPayout">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-jet-label for="User" value="{{ __('Select User') }}" />
                    <x-select-search :data="$users" wire:model="selected_user" placeholder="Select user(s)"/>
                    @error('selected_user') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-jet-label for="title" value="{{ __('Select Project(s)') }}" />
                    <x-select-search :data="$projects" wire:model="selected_projects" placeholder="Select project"/>
                    @error('selected_projects') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex space-x-4">                    
                    <div>
                        <x-jet-label for="amount_paid" value="{{ __('Amount Paid') }}" />
                        <x-jet-input id="amount_paid" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="number" name="amount_paid" value="{{old('amount_paid', 1)}}" min="0" wire:model.debounce.500ms="amount_paid" placeholder="Enter Amount Paid" autofocus />
                        @error('amount_paid') <span class="error text-red-500">{{ $message }}</span> @enderror
                    </div>                
                </div>      
                
                @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))         
                    <div class="sm:py-1 md:mt-5 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button class="" wire:loading.attr="disabled" wire:click.prevent="toggleConfirmTransactionModal()">
                            <i class="fa fa-credit-card"></i> 
                            <span class="ml-2">Comfirm Transaction</span>
                        </x-jet-button>                    
                    </div>

                    <x-jet-confirmation-modal wire:model="confirmTransactionModal">
                        <x-slot name="title">
                            {{ __('Confirm Payment') }}
                        </x-slot>
                
                        <x-slot name="content">
                            {{ __('Are you sure you would like to continue this transaction status?') }}
                        </x-slot>
                
                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$toggle('confirmTransactionModal')" wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-jet-secondary-button>
                
                            <x-jet-button class="ml-2" wire:click="confirmPayout()" wire:loading.attr="disabled">
                                Continue
                            </x-jet-button>
                        </x-slot>
                    </x-jet-confirmation-modal>
                @endif
            </div>
        </form>
    </div>
</div>

@section('custom-scripts')
    <script >
        window.livewire.on('alert', param => {
            // toastr[param['type']](param['message']);
            console.log(param['message']);
            iziToast[param['type']]({
                title: param['title'],
                message: param['message'],
                position: 'topRight'
            });
        });
    </script>
@endsection