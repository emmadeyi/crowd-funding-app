<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fas fa-file-invoice-dollar"></i> Transaction History - ( 
        <span class="w-2/3 text-left"><i class="fas fa-clipboard-list"></i> {{ $transactions->count() }} | <i class="fas fa-coins"></i> <span class="line-through">N</span>{{number_format($transactions->sum('amount'))}} | <span class="text-yellow-400"><i class="fas fa-exclamation-triangle"></i> <span class="line-through">N</span>{{number_format($unconfirmedTransactions)}} </span></span>
    )</p>
    @if ($page_transactions->count() > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">User</th></th>
                <th class="px-3 py-2 md:border">Admin</th>
                <th class="px-3 py-2 md:border">Amount (<span class="line-through">N</span>)</th>
                <th class="px-3 py-2 md:border">Type</th>
                <th class="px-3 py-2 md:border">Status</th>                    
                @if(auth()->user()->canany(['Read Transaction', 'Manage Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                    <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                <?php $expected = 0; ?>
                @foreach ($page_transactions as $transaction) 
                    @if ($transaction->user)                        
                        <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                            <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> User</span>
                                <a href="{{route('projects.user-transactions', Crypt::encrypt($transaction->user->id))}}"> <span class="w-2/3 text-left">{{ $transaction->user->name }}</span>
                                </a>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Admin</span> <span class="w-2/3 text-left">
                                    {{($transaction->admin_id > 0) ? $transaction->administrator->name : 'N/A'}}
                                </span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Amount</span> <span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format($transaction->amount) }}</span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Type</span> <span class="w-2/3 text-left">
                                    @switch($transaction->type)
                                        @case('1')
                                            Payout
                                            @break
                                        @case('2')
                                            Subscription
                                            @break
                                        @case('3')
                                            Maintanance Fee
                                            @break
                                        @default
                                            Unknown
                                    @endswitch
                                </span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> status</span>
                                <span class="w-2/3 text-left">
                                    @if ($transaction->status)
                                        Confirmed
                                    @else
                                        Not Confirmed
                                    @endif
                            </td>
                                    
                            @if(auth()->user()->canany(['Read Transaction', 'Manage Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                    <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                    <span class="w-2/3 text-left font-light">                                         
                                        @if(auth()->user()->canany(['Read Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                            <a href="{{route('projects.transaction-details', ['id' => Crypt::encrypt($transaction->id), 'type' => Crypt::encrypt($transaction->type)])}}">
                                                <x-jet-secondary-button title="Details">
                                                    <i class="fa fa-info"></i>
                                                </x-jet-secondary-button>
                                            </a>
                                            <a href="{{route('projects.user-transactions', Crypt::encrypt($transaction->user->id))}}"> 
                                                <x-jet-secondary-button title="User Transactions">
                                                    <i class="fa fa-user"></i>
                                                </x-jet-secondary-button>                                    
                                            </a>
                                        @endif    
                                        @if(auth()->user()->canany(['Manage Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                            @if ($transaction->status)
                                                <x-jet-secondary-button title="Cancel" wire:click.prevent="confirmPayoutStatus({{$transaction->id}})" >
                                                    <i class="fa fa-times"></i>
                                                </x-jet-secondary-button>
                                            @else
                                                <x-jet-button title="Confirm" wire:click.prevent="confirmPayoutStatus({{$transaction->id}})" >
                                                    <i class="fa fa-check"></i>
                                                </x-jet-button>
                                            @endif  
                                        @endif                              
                                    </span>
                                </td>
                            @endif
                        </tr>   
                    @endif
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $page_transactions->links() }}  
        </div>
    
        <x-jet-confirmation-modal wire:model="confirmPayoutStatusModal">
            <x-slot name="title">
                {{ __('Confirm Payment') }}
            </x-slot>
    
            <x-slot name="content">
                {{ __('Are you sure you would like to continue this transaction status?') }}
            </x-slot>
    
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmPayoutStatusModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
    
                <x-jet-button class="ml-2" wire:click="togglePaymentStatus({{$transaction->id}})" wire:loading.attr="disabled">
                    Continue
                </x-jet-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @else
        <p class="font-light">No transaction record found.</p>
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
