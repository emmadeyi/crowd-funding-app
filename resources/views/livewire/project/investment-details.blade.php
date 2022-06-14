<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    <p class="uppercase text-lg text-gray-700 md:p-1 my-1">Investment Details</p>
    <div class="flex flex-col md:flex-row md:max-w-5xl max-w-sm mx-auto font-medium shadow-lg rounded-lg overflow-hidden md:p-2 md:space-x-4">
        {{-- project summary --}}
        <div class="md:w-2/3 p-2 text-gray-500">
            <p class="uppercase text-base pb-3">                   
                @if(auth()->user()->canany(['Read Project']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                    <a href="{{route('projects.details', Crypt::encrypt($subscription->project->id))}}">{{$subscription->project->title}}</a> 
                @else
                {{$subscription->project->title}}
                @endif
                - (
                @if ($this->checkPayoutFulfillment($subscription))
                    <span class="text-green-400">Fulfilled</span>
                @else                                        
                    @if ($subscription->status && $subscription->confirmation == '2')
                        Active
                    @else
                        @if ($subscription->confirmation == '1')
                            Not Confirmed
                        @else
                            @if ($subscription->confirmation == '0')
                                Closed
                            @else
                                Error
                            @endif
                        @endif
                    @endif
                @endif
                )
            </p>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 border-b border-gray-300 pb-5">
                <div class="col-span-2">
                    @if (count($subscription->project->photo) > 0)
                        <div>
                            <img src="{{asset('./storage/'.$subscription->project->photo->first()->url)}}" class="w-full rounded-lg" />
                        </div>
                    @else
                        <div>
                            <img src="{{asset('./imgs/demo/demo-img-07.jpg')}}" class="w-full rounded-lg" />
                        </div>
                    @endif
                </div>
                <div class="col-span-3 h-full ">
                    <div class="text-sm">                        
                        @if ($subscription->project->author)                
                            <p class="text-sm font-light"><i class="fas fa-user text-blue-500"></i><span class="font-semibold mx-2">Author : </span> {{$subscription->project->creator->name}}</p>
                        @endif

                        {{-- Execution Cost --}}
                        <p class="text-sm font-light"><i class="fas fa-money-bill-alt text-green-500"></i><span class="font-semibold mx-2">Execution Cost : </span> <span class="line-through">N</span>{{number_format($subscription->project->execution_cost,2)}}</p>
                        {{-- Duration --}}
                        <p class="text-sm font-light"><i class="fas fa-business-time text-red-400"></i><span class="font-semibold mx-2">Payment Duration : </span> {{$subscription->project->duration}} <span class="italic">(Days)</span></p>

                        <p class="text-sm font-light"><i class="far fa-calendar-alt text-red-300"></i></i><span class="font-semibold mx-2">Launch Date : </span> {{ \Carbon\Carbon::parse($subscription->project->execution_start_date)->format('d/m/Y')}} </p>
                            
                        <p class="text-sm font-light"><i class="fas fa-percent text-green-500"></i></i><span class="font-semibold mx-2">ROI : </span> {{$subscription->project->roi_percent}} <span class="italic">(%)</span></p>
                            
                        <p class="text-sm font-light"><i class="fas fa-credit-card text-gray-500"></i></i><span class="font-semibold mx-2">Min Investment : </span> </span> <span class="line-through">N</span>{{number_format($subscription->project->min_investment,2)}} </span></p>
                            
                        <p class="text-sm font-light"><i class="fas fa-hourglass-half text-blue-500"></i><span class="font-semibold mx-2">Payment Cycle : </span> {{$subscription->project->payment_cycle}} <span class="italic">(Days)</span></p>
                            
                        <p class="text-sm font-light"> <i class="fas fa-money-check text-yellow-500"></i></i><span class="font-semibold mx-2">Payment Starts : </span> {{$subscription->project->payment_starts}} <span class="italic">(Days) after launching</span></p>                      
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                {{-- @if (!$this->checkPayoutFulfillment($subscription))                
                @endif --}}
                <div class="bg-transparent flex items-center gap-2 justify-end md:px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">                        
                    @if(auth()->user()->canany(['Delete Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                        @if (!$this->checkForPayout($subscription))                        
                            <x-jet-secondary-button wire:click.prevent="deleteSubscriptionPayment({{$subscription->id}})" class="text-red-400">
                                <i class="fa fa-trash"></i> 
                                <span class="ml-2 hidden md:block"> Delete </span>
                            </x-jet-secondary-button>
                        @endif
                    @endif                      
                    @if(auth()->user()->canany(['Manage Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                        <x-jet-secondary-button title="Cancel" wire:click.prevent="toggleSubscriptionConfirmation({{$subscription->id}})" >                    
                            <i class="far fa-window-close"></i> <span class="ml-2">{{ ($subscription->confirmation == 0 && !$subscription->status) ? 'Re-open' : 'Close'}}</span>
                        </x-jet-secondary-button>
                    @endif
                                         
                    @if(auth()->user()->canany(['Manage Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                        @if (!$this->checkForPayout($subscription))                        
                            @if ($subscription->confirmation == 2 && $subscription->status)
                                <x-jet-button wire:click.prevent="cancelSubscriptionConfirmation({{$subscription->id}})" >
                                    <span >Cancel</span>
                                </x-jet-button>
                            @endif
                            @if ($subscription->confirmation == 1 && !$subscription->status)
                                <x-jet-button wire:click.prevent="confirmSubscriptionPayment({{$subscription->id}})" >
                                    <span >Confirm</span>
                                </x-jet-button>
                            @endif
                        @endif
                    @endif
                </div>
            @endif
        </div>
        {{-- Payment Summary --}}
        <div class="md:w-1/3 p-3 border border-gray-200 rounded-lg bg-gray-100">
            <p class="uppercase text-base font-light mb-5">Investment Summary</p>
            <p class="text-sm font-light mt-2"> <span class="font-semibold mx-2">Investor : </span>{{$subscription->subscriber->name}} </p>
            <p class="text-sm font-light mt-2"> <span class="font-semibold mx-2">Amount Invested : </span> <span class="line-through">N</span>{{number_format($subscription->amount_paid,2)}} </p>
            <p class="text-sm font-light mt-2"> <span class="font-semibold mx-2">Amount Expected : </span> <span class="line-through">N</span>{{ number_format(((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid), 2) }} </p>
            <p class="text-sm font-light mt-2"> <span class="font-semibold mx-2">Cycle Payment : </span> <span class="line-through">N</span>{{number_format(((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid) / (ceil($subscription->project->duration / $subscription->project->payment_cycle)),2)}} </p>
            <p class="text-sm font-light mt-2"> <span class="font-semibold mx-2">Amount Received : </span> <span class="line-through">N</span>{{number_format($this->subscription->subscriptionPayOut->sum('amount'),2)}} </p>
            <p class="text-sm font-light mt-2"> <span class="font-semibold mx-2">Amount Pending : </span> <span class="line-through">N</span>{{number_format(($this->total_expected - $this->subscription->subscriptionPayOut->sum('amount')),2)}} </p> 
            @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                @if ($subscription->status && $subscription->confirmation == '2')                
                    <div class="bg-transparent flex items-center gap-2 justify-end md:px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button title="Pay" wire:click.prevent="confirmSubscriptionPayOut({{$subscription->id}})" >
                            <i class="fa fa-credit-card"></i> 
                            <span class="ml-2">
                                Pay
                            </span>
                        </x-jet-button>
                    </div>
                @endif
                {{-- @if (!$this->checkPayoutFulfillment($subscription))            
                @endif --}}
            @endif
        </div>
    </div>
    <div class="mt-5">
        <p class="uppercase text-base text-gray-400 md:p-2 my-2"> <i class="fa fa-suitcase"></i> <span class="mx-3">Current Project Investments (</span><span class="line-through">N</span>{{number_format(Auth::user()->projectSubscription->where('project_id', $subscription->project->id)->sum('amount_paid'),2)}})</span></p>
        @if (count($projectSubscriptions) > 0)                
            <table class="table-auto border-collapse w-full text-xs">
                <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                    <tr>
                    <th class="px-3 py-2 md:border">#</th>
                    <th class="px-3 py-2 md:border">Paid (<span class="line-through">N</span>)</th>
                    <th class="px-3 py-2 md:border">Expectation</th>
                    <th class="px-3 py-2 md:border">Received</th>
                    <th class="px-3 py-2 md:border">Status</th>
                    <th class="px-3 py-2 md:border">Date</th>
                    </tr>
                </thead>
                <tbody class="font-light text-gray-600 content md:table-row-group">
                    @foreach ($projectSubscriptions as $subscription)                     
                        <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3 {{ $subscription->id == $subscription_id ? 'bg-gray-500 text-yellow-300 text-sm' : '' }}">
                            <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                   
                            @if(auth()->user()->canany(['Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> Amount Paid</span>
                                <a href="{{route('projects.investment-details', ['user' => Crypt::encrypt($subscription->user_id), 'id' => Crypt::encrypt($subscription->id)])}}" class="underline">  
                                    <span class="w-2/3 text-left">{{ number_format($subscription->amount_paid, 2) }}</span>
                                </a>
                            </td>
                            @else
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> Amount Paid</span><span class="w-2/3 text-left">{{ number_format($subscription->amount_paid, 2) }}</span>
                            </td>
                            @endif
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Expectation</span>
                                <span class="w-2/3 text-left"> > {{ number_format(((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid), 2) }}</span>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Received</span>
                                <span class="w-2/3 text-left">{{ number_format($subscription->subscriptionPayOut->sum('amount'), 2) }}</span>
                            </td>
                            
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Status</span>
                                <span class="w-2/3 text-left">
                                    @if ($this->checkPayoutFulfillment($subscription))
                                        Fulfilled
                                    @else                                        
                                        @if ($subscription->status && $subscription->confirmation == '2')
                                            Active
                                        @else
                                            @if ($subscription->confirmation == '1')
                                                    Not Confirmed
                                            @else
                                                @if ($subscription->confirmation == '0')
                                                        Closed
                                                @else
                                                    Error
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </span>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Date</span>
                                <span class="w-2/3 text-left">{{ \Carbon\Carbon::parse($subscription->created_at)->diffForHumans()}}</span>
                            </td>
                        </tr>   
                    @endforeach
                    
                </tbody>
            </table>
            <div class="mt-5 border-t border-gray-300 py-5">
                {{ $projectSubscriptions->links() }}  
            </div>
        
        @else
            <p class="font-light">No subscription record found.</p>
        @endif
    </div>
    <x-jet-confirmation-modal wire:model="confirmSubscriptionModal">
        <x-slot name="title">
            {{ __('Confirm Subscription') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to confirm to this Subscription?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmSubscriptionModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="confirmPayment({{$subscription->id}})" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="deleteSubscriptionModal">
        <x-slot name="title">
            {{ __('Delete Subscription') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to delete to this Subscription?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteSubscriptionModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="deletePayment({{$subscription->id}})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="cancelSubscriptionModal">
        <x-slot name="title">
            {{ __('Cancel Subscription') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to Cancel to this Subscription?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('cancelSubscriptionModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="cancelConfirmation({{$subscription->id}})" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-confirmation-modal wire:model="toggleSubscriptionModal">
        <x-slot name="title">
            Change Subscription Status
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to this subscription status?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('toggleSubscriptionModal')" wire:loading.attr="disabled">
                close
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="toggleSubscription({{$subscription->id}})" wire:loading.attr="disabled">
                {{ __('Continue') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
    
    <x-jet-dialog-modal wire:model="subscriptionPayOutModal">
        <x-slot name="title">           
            <i class="fa fa-credit-card"></i> <span class="mx-2">Subscription Payout</span>
            <?php
                // if($cycle_payment * $cycle_count > ($this->total_expected - $this->subscription->subscriptionPayOut->sum('amount'))){
                //     $this->pay_amount = ($this->total_expected - $this->subscription->subscriptionPayOut->sum('amount'));
                //     $this->cycle_count = ceil($subscription->project->duration / $subscription->project->payment_cycle) - count($this->subscription->subscriptionPayOut);
                // }else{
                //     $this->pay_amount = $cycle_payment * $cycle_count;
                // }
            ?>
        </x-slot>
        
        <x-slot name="content">
            {{-- <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="cycle_count" value="{{ __('Cycle Count') }}" />
                <x-jet-input id="cycle_count" class="block mt-1 w-full" type="number" name="cycle_count" :value="old('cycle_count')" required autofocus autocomplete="cycle_count" wire:model.debounce.500ms="cycle_count" />
                @error('cycle_count') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div> --}}
            <div class="col-span-6 sm:col-span-4 my-4">
                <x-jet-label for="pay_amount" value="{{ __('Amount') }}" />
                <x-jet-input id="pay_amount" class="block mt-1 w-full" type="number" name="pay_amount" :value="old('pay_amount')" required autofocus wire:model.debounce.500ms="pay_amount" />
                @error('pay_amount') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('subscriptionPayOutModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
            <x-jet-button wire:click="subscriptionPayOut">
                {{ __('Save')}}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
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