<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    <p class="uppercase text-base text-gray-700 md:p-2 my-2">
         <i class="fas fa-file-invoice-dollar"></i> Transaction Details - ( 
        <span class="w-2/3 text-left"><i class="fas fa-coins"></i> <span class="line-through">N</span>{{number_format($transaction->amount)}} </span>
    )</p>
    @if ($transactions->count() > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">User</th></th>
                <th class="px-3 py-2 md:border">Amount (<span class="line-through">N</span>)</th>
                <th class="px-3 py-2 md:border">Status</th>
                <th class="px-3 py-2 md:border">Date</th>                         
                @if(auth()->user()->canany(['Manage Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                    <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                <?php $expected = 0; ?>
                @foreach ($transactions as $transaction) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> User</span> <span class="w-2/3 text-left">
                                @if ($transaction_type != '1')
                                    {{ $transaction->subscriber->name }}
                                @else
                                    {{ $transaction->user->name }}
                                @endif
                            </span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Amount</span> <span class="w-2/3 text-left"><span class="line-through">N</span>
                            @switch($transaction_type)
                                @case('1')
                                    {{ number_format($transaction->amount) }}
                                    @break
                                @case('2')
                                    {{ number_format($transaction->amount_paid) }}
                                    @break
                                @case('3')
                                    {{ number_format($transaction->amount_paid) }}
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
                                    Acknowledged
                                @else
                                    Not Acknowledged
                                @endif
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Date</span> <span class="w-2/3 text-left">
                                {{ $transaction->created_at}}
                            </span>
                        </td>                        
                        @if(auth()->user()->canany(['Manage Transaction']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                            <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                <span class="w-2/3 text-left font-light">
                                    @if ($transaction->status)
                                        <x-jet-secondary-button title="Cancel" wire:click.prevent="confirmPayoutStatus({{$transaction->id}})" >
                                            <i class="fa fa-times"></i>
                                        </x-jet-secondary-button>
                                    @else
                                        <x-jet-button title="Confirm" wire:click.prevent="confirmPayoutStatus({{$transaction->id}})" >
                                            <i class="fa fa-check"></i>
                                        </x-jet-button>
                                    @endif                                
                                </span>
                            </td>                        
                        @endif
                    </tr>   
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{-- {{ $transactions->links() }}   --}}
        </div>
    
    @else
        <p class="font-light">No investment record found.</p>
    @endif
    <x-jet-confirmation-modal wire:model="confirmPayoutStatusModal">
        <x-slot name="title">
            {{ __('Confirm Payment') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to this transaction status?') }}
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
