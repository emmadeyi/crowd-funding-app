<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    @if($msg != null or $msg != '')
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ $msg }}</p>
    @endif 
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fas fa-hand-holding-usd"></i> Manage Project Payouts </p>
    <div class="px-4 sm:px-0">
        <form wire:submit.prevent="confirmPayout">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-jet-label for="title" value="{{ __('Select Project(s)') }}" />
                    <x-select-search :data="$projects" wire:model="selected_projects" placeholder="Select project(s)" multiple/>
                    @error('selected_projects') <span class="error text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex space-x-4"> 
                    <div>
                        <x-jet-label for="amount_paid" value="{{ __('Amount Paid') }}" />
                        <x-jet-input id="amount_paid" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="number" name="amount_paid" value="{{old('amount_paid', 1)}}" min="0" wire:model.debounce.500ms="amount_paid" placeholder="Enter Amount Paid" autofocus />
                        @error('amount_paid') <span class="error text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-jet-label for="title" value="{{ __('Record Count') }}" />
                        <x-jet-input id="paginate_value" class="block mt-1 w-full focus:border-gray-300 focus:ring focus:ring-gray-200" type="number" name="paginate_value" value="{{old('paginate_value', 10)}}" min="0" wire:model.debounce.500ms="paginate_value" autofocus />
                        @error('paginate_value') <span class="error text-red-500">{{ $message }}</span> @enderror
                    </div>                
                </div>      
                
                @if(auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))         
                    <div class="sm:py-1 md:mt-5 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button class="" wire:loading.attr="disabled" wire:click.prevent="toggleConfirmPayoutModal()">
                            <i class="fa fa-credit-card"></i> 
                            <span class="ml-2">Comfirm Pay</span>
                        </x-jet-button>                    
                    </div>
                @endif
            </div>
        </form>
    </div>
    <div class="mt-5">
        @if (count($payouts) > 0)                
            <table class="table-auto border-collapse w-full text-xs">
                <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                    <tr>
                    <th class="px-3 py-2 md:border">#</th>
                    <th class="px-3 py-2 md:border">Project</th>
                    <th class="px-3 py-2 md:border">User</th>
                    <th class="px-3 py-2 md:border">Paid (<span class="line-through">N</span>)</th>
                    <th class="px-3 py-2 md:border">Expectation</th>
                    <th class="px-3 py-2 md:border">Received</th>
                    <th class="px-3 py-2 md:border">Status</th>
                    </tr>
                </thead>
                <tbody class="font-light text-gray-600 content md:table-row-group">
                    @foreach ($payouts as $payout)                     
                        <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                            <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Project</span>
                                <a href="{{route('project.subscriptions', Crypt::encrypt($payout[0]->project->id))}}" class="underline">
                                    <span class="w-2/3 text-left">{!! \Illuminate\Support\Str::words($payout[0]->project->title, 4)  !!}</span>
                                </a>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> User</span>
                                <a href="{{route('projects.user-investment', Crypt::encrypt($payout[0]->subscriber->id))}}" class="underline"> 
                                    <span class="w-2/3 text-left">{{ $payout[0]->subscriber->name }}</span>
                                </a>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> Amount Paid</span>
                                <a href="{{route('projects.investment-details', ['user' => Crypt::encrypt($payout[0]->user_id), 'id' => Crypt::encrypt($payout[0]->id)])}}" class="underline">  
                                    <span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format($payout[0]->amount_paid, 2) }}</span>
                                </a>
                            </td>                            
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Expectation</span>
                                <span class="w-2/3 text-left"> > {{ number_format($payout[2]) }}</span>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Received</span>
                                <span class="w-2/3 text-left">{{ number_format($payout[1]) }}</span>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Status</span>
                                <span class="w-2/3 text-left">
                                    {{-- $payout[0]->subscriber->id --}}
                                    @if ($this->checkPayoutFulfillment($payout[0]->id))
                                        Fulfilled
                                    @else                                        
                                        @if ($payout[0]->status && $payout[0]->confirmation == '2')
                                            Active
                                        @else
                                            @if ($payout[0]->confirmation == '1')
                                                    Not Confirmed
                                            @else
                                                @if ($payout[0]->confirmation == '0')
                                                        Closed
                                                @else
                                                    Error
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </span>
                            </td>
                        </tr>   
                    @endforeach
                    
                </tbody>
            </table>
            <div class="mt-5 border-t border-gray-300 py-5">
                {{ $payouts->links() }}  
            </div>
            <x-jet-confirmation-modal wire:model="confirmPayoutModal">
                <x-slot name="title">
                    {{ __('Confirm Payment') }}
                </x-slot>
        
                <x-slot name="content">
                    {{ __('Are you sure you would like to continue this transaction status?') }}
                </x-slot>
        
                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmPayoutModal')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
        
                    <x-jet-button class="ml-2" wire:click="confirmPayout()" wire:loading.attr="disabled">
                        Continue
                    </x-jet-button>
                </x-slot>
            </x-jet-confirmation-modal>
        @else
            <p class="font-light text-gray-700">No pending payout record found.</p>
        @endif
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