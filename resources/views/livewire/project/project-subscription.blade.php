<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    {{-- The whole world belongs to you. --}}
    <p class="uppercase text-lg text-gray-700 md:p-2 my-1">Project Subscription</p>
    <div class="flex flex-col md:flex-row md:max-w-5xl max-w-sm mx-auto font-medium shadow-lg rounded-lg overflow-hidden md:p-2 md:space-x-4">
        {{-- project summary --}}
        <div class="md:w-2/3 p-2 text-gray-500">
            <p class="uppercase text-base font-light pb-3"><a href="{{route('projects.details', Crypt::encrypt($project->id))}}">{{$project->title}}</a> </p>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 border-b border-gray-300 pb-5">
                <div class="col-span-2">
                    @if (count($project->photo) > 0)
                        <div>
                            <img src="{{asset('./storage/'.$project->photo->first()->url)}}" class="w-full rounded-lg" />
                        </div>
                    @else
                        <div>
                            <img src="{{asset('./imgs/demo/demo-img-07.jpg')}}" class="w-full rounded-lg" />
                        </div>
                    @endif
                </div>
                <div class="col-span-3 h-full ">
                    <div class="text-sm">                        
                        @if ($project->author)                
                            <p class="text-sm font-light"><i class="fas fa-user text-blue-500"></i><span class="font-semibold mx-2">Author : </span> {{$project->creator->name}}</p>
                        @endif

                        {{-- Execution Cost --}}
                        <p class="text-sm font-light"><i class="fas fa-money-bill-alt text-green-500"></i><span class="font-semibold mx-2">Start-Up Cost : </span> <span class="line-through">N</span>{{number_format($project->execution_cost,2)}}</p>
                        {{-- Duration --}}
                        <p class="text-sm font-light"><i class="fas fa-business-time text-red-400"></i><span class="font-semibold mx-2">Payment Duration : </span> {{$project->duration}} <span class="italic">(Days)</span></p>

                        <p class="text-sm font-light"><i class="far fa-calendar-alt text-red-300"></i></i><span class="font-semibold mx-2">Launch Date : </span> {{ \Carbon\Carbon::parse($project->execution_start_date)->format('d/m/Y')}} </p>
                            
                        {{-- <p class="text-sm font-light"><i class="fas fa-percent text-green-500"></i></i><span class="font-semibold mx-2">ROI : </span> {{$project->roi_percent}} <span class="italic">(%)</span></p> --}}
                            
                        <p class="text-sm font-light"><i class="fas fa-credit-card text-gray-500"></i></i><span class="font-semibold mx-2">Min Investment : </span> </span> <span class="line-through">N</span>{{number_format($project->min_investment,2)}} </span></p>
                            
                        <p class="text-sm font-light"><i class="fas fa-hourglass-half text-blue-500"></i><span class="font-semibold mx-2">Payment Cycle : </span> {{$project->payment_cycle}} <span class="italic">(Days)</span></p>
                            
                        <p class="text-sm font-light"> <i class="fas fa-money-check text-yellow-500"></i></i><span class="font-semibold mx-2">Payment Starts : </span> {{$project->payment_starts}} <span class="italic">(Days) after launching</span></p>                      
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-700 font-light mt-2 text-right"> <i class="fas fa-money-check-alt"></i><span class="font-semibold mx-2">Current Investment : </span> <span class="line-through">N</span>{{number_format(Auth::user()->projectSubscription->where('project_id', $this->project->id)->sum('amount_paid'),2)}} </p>
        </div>
        {{-- Payment Summary --}}
        <div class="md:w-1/3 p-3 border border-gray-200 rounded-lg bg-gray-100">
            <p class="uppercase text-base font-light mb-5">Payment Summary</p>
            <p class="text-sm font-light mt-2 text-right"> <i class="fas fa-credit-card text-yellow-500"></i><span class="font-semibold mx-2">Maintenance Fee : </span> <span class="line-through">N</span>{{number_format($maintenance_fee,2)}} </p>
            <p class="text-right text-gray-600 font-semibold text-lg">+</p>
            <div class=" my-2 border-b pb-4 border-gray-600 text-right">
                <x-jet-label class="font-semibold" for="amount" >Subscription Amount in (<span class="line-through">N</span>)</x-jet-label>
                <div class="p-1 flex justify-end">
                    <x-jet-input id="maintenance_fee" class="block mt-1 w-3/5 text-sm text-right" type="hidden" name="maintenance_fee" :value="old('maintenance_fee')" min="{{$maintenance_fee}}" required wire:model.debounce.500ms="maintenance_fee" autofocus /> <br>
                </div>
                <div class="p-1 flex justify-end">
                    <x-jet-input id="amount" class="block mt-1 w-3/5 text-sm text-right" type="number" name="amount" :value="old('amount')" min="{{$project->min_investment}}" required wire:model.debounce.500ms="amount" autofocus /> <br>
                </div>
                <div class="flex justify-end">
                    @error('amount') <p class="pt-1 error text-sm text-right text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
            <p class="text-sm font-light mt-2 text-right"> <i class="fas fa-credit-card text-yellow-500"></i><span class="font-semibold mx-2">Total : </span> <span class="line-through">N</span>{{number_format((floatval($amount) + $maintenance_fee),2)}} </p>
            <div class="flex cursor-pointer space-x-1 justify-end p-2 w-auto mt-2 hover:bg-gray-100">
                <x-jet-input id="acceptTerms" class="border border-gray-300 block focus:border-gray-400 focus:ring focus:ring-gray-400 cursor-pointer" type="checkbox"  wire:model="acceptTerms"/>
                <x-jet-label class="cursor-pointer font-semibold" for="acceptTerms">
                    Accept Terms and Condition    
                </x-jet-label> 
            </div>
            <p class="text-sm mt-2 text-right underline"><span class="font-light mx-2"><a href="{{route('projects.terms-conditions')}}" target="_blank">
                Click to read Terms and Condition    
            </a></span></p>
        </div>
    </div>
    
    @if (Auth::user()->status == 1)
        @if (Auth::user()->bankDetails)
            @if(auth()->user()->canany(['Create Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))        
                <div class="bg-transparent flex items-center gap-2 justify-end md:px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">        
                    <x-jet-secondary-button title="Cancel" wire:click.prevent="confirmCancelSubscription({{$project->id}})" >
                        <i class="far fa-window-close"></i> <span class="ml-2">Cancel</span>
                    </x-jet-button>
                    @if ($acceptTerms)
                        <x-jet-button title="{{(Auth::user()->projectSubscription->where('project_id', $this->project->id)->where('status', true)->first()) ? 'Update Subscription' : 'Make Payment'}}" wire:click.prevent="confirmSubscriptionPayment({{$project->id}})" >
                            <i class="fa fa-credit-card"></i> 
                            <span class="ml-2">
                                {{(Auth::user()->projectSubscription->where('project_id', $this->project->id)->where('status', true)->first()) ? 'Pay' : 'Pay'}}
                            </span>
                        </x-jet-button>                        
                    @endif              
                </div>
            @endif
        @else
            <p class="text-red-400 px-2 py-5 font-semibold">
                Your bank details are required before any subscription. <a href="{{ route('accounts.user-bio-profile', Crypt::encrypt(Auth::user()->id)) }}" class="text-gray-700 underline">Click here</a>
            </p>
        @endif
    @else
        <p class="text-gray-400 px-2 py-5 font-semibold">
            Account is pending Activation. Please contact Administrator. 
        </p>                    
    @endif
    
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

            <x-jet-button class="ml-2" wire:click="confirmPayment({{$project->id}})" wire:loading.attr="disabled">
                {{ __('Subscribe Project') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>

@section('custom-scripts')
<script src="https://js.paystack.co/v1/inline.js"></script> 
    <script>
        window.livewire.on('alert', param => {
            // toastr[param['type']](param['message']);
            iziToast[param['type']]({
                title: param['title'],
                message: param['message'],
                position: 'topRight'
            });
        });
        window.addEventListener('make_payment', event => {
            var handler = PaystackPop.setup({
                key: '{{ env('PAYSTACK_PUBLIC_KEY')}}', // Replace with your public key
                email: event.detail.email,
                amount: event.detail.amount * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
                currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
                ref: event.detail.reference, // Replace with a reference you generated
                callback: function(response) {
                    //this happens after the payment is completed successfully
                    var reference = response.reference;  
                    Livewire.emit('continueTransaction', reference);                  
                    // Make an AJAX call to your server with the reference to verify the transaction                
                },
                onClose: function() {
                    Livewire.emit('continueTransaction', event.detail.reference);  
                    // alert('Transaction was not completed, window closed.');
                },
            });
            handler.openIframe();
        });
    </script>
@endsection