<div>
    <?php
        $total_expected = 0;
        $total_received = 0;
        foreach ($myProjectSubscriptions as $subscription) {
            $total_expected += ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid);
            $total_received += $subscription->subscriptionPayOut->sum('amount');
        }
    ?>
    
    
    @if (Auth::user()->status != 1)
        <p class="text-red-400 px-2 py-5 font-semibold">
            Account is Pending Activation. Please contact Administrator. 
        </p>                    
    @endif
    
    @if(auth()->user()->hasanyrole('Developer|Super Admin|Administrator'))
        <p class="uppercase text-sm text-gray-700 md:p-2 my-2"> <i class="fas fa-file-invoice-dollar"></i> Transaction History - ( 
            <span class="w-2/3 text-left"><i class="fas fa-clipboard-list"></i> {{ $transactions->count() }} | <i class="fas fa-coins"></i> <span class="line-through">N</span>{{number_format($transactions->sum('amount'))}} | <span class="text-yellow-400"><i class="fas fa-exclamation-triangle"></i> <span class="line-through">N</span>{{number_format($unconfirmedTransactions)}} </span></span>
        )</p>
        <div class="grid grid-cols-1 md:grid-cols-3 p-5 w-full gap-4 border-t-2 border-gray-300">            
            <div class="grid grid-rows-2 grid-cols-4 shadow-xl text-gray-700">
                <div class="row-span-2 p-5 grid content-center justify-center text-gray-700 bg-gray-200">
                    <span class="text-3xl font-lighr"><i class="fas fa-credit-card"></i></span>
                </div>
                <div class="col-span-3 row-span-2 text-2xl text-center bg-gray-700 text-gray-200 font-semibold">
                    <div class="grid grid-row-4">                        
                        <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{ number_format($subscriptions)}}</div>
                        <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">Confirmed Investement</div>
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2 grid-cols-4 shadow-xl text-gray-700">
                <div class="row-span-2 p-5 grid content-center justify-center text-yellow-300 bg-gray-700">
                    <span class="text-3xl font-lighr"><i class="fas fa-receipt"></i></span>
                </div>
                <div class="col-span-3 row-span-2 text-2xl text-center bg-gray-200 text-gray-700 font-semibold">
                    <div class="grid grid-row-4">                        
                        <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{ number_format($total_payouts) }}</div>
                        <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">Total Payouts</div>
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2 grid-cols-4 shadow-xl">
                <div class="row-span-2 p-5 grid content-center justify-center bg-yellow-300 text-gray-700">
                    <span class="text-3xl font-lighr"><i class="fas fa-user-cog"></i></span>
                </div>
                <div class="col-span-3 row-span-2 text-2xl text-center bg-gray-200 text-gray-700 font-semibold">
                    <div class="grid grid-row-4">                        
                        <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{ number_format($maintenance_fees)}}</div>
                        <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">Maintenance Fees</div>
                    </div>
                </div>
            </div>
        </div>  
    @endif  
    <p class="uppercase text-sm text-gray-700 md:p-2 my-2"> <i class="fa fa-suitcase"></i> My Investment - ( 
        <span class="w-2/3 text-left"><i class="fas fa-clipboard-list"></i> {{ $myProjectSubscriptions->count() }} | <i class="fas fa-coins"></i> <span class="line-through">N</span>{{number_format($myProjectSubscriptions->sum('amount_paid'))}} | <span class="text-yellow-400"><i class="fas fa-exclamation-triangle"></i> <span class="line-through">N</span>{{number_format($total_expected - ($total_received - $unconfirmedTransactionsByUser))}} </span></span>
    )</p>
    <div class="grid grid-cols-1 md:grid-cols-4 p-5 w-full gap-4 border-t-2 border-gray-300">            
        <div class="grid grid-rows-2 grid-cols-3 shadow-xl text-gray-700">
            <div class="row-span-2 p-5 grid content-center justify-center text-gray-700 bg-gray-200">
                <span class="text-3xl font-lighr"><i class="fas fa-credit-card"></i></span>
            </div>
            <div class="col-span-2 row-span-2 text-2xl text-center bg-gray-700 text-gray-200 font-semibold">
                <div class="grid grid-row-4">                        
                    <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{number_format($myProjectSubscriptions->sum('amount_paid'))}}</div>
                    <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">Invested</div>
                </div>
            </div>
        </div>
        <div class="grid grid-rows-2 grid-cols-3 shadow-xl text-gray-700">
            <div class="row-span-2 p-5 grid content-center justify-center text-yellow-300 bg-gray-700">
                <span class="text-3xl font-lighr"><i class="fas fa-file-invoice-dollar"></i></span>
            </div>
            <div class="col-span-2 row-span-2 text-2xl text-center bg-gray-200 text-gray-700 font-semibold">
                <div class="grid grid-row-4">                        
                    <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{ number_format($total_received - $unconfirmedTransactionsByUser) }}</div>
                    <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">Received</div>
                </div>
            </div>
        </div>
        <div class="grid grid-rows-2 grid-cols-3 shadow-xl">
            <div class="row-span-2 p-5 grid content-center justify-center bg-yellow-300 text-gray-700">
                <span class="text-3xl font-lighr"><i class="fas fa-exclamation-circle"></i></span>
            </div>
            <div class="col-span-2 row-span-2 text-2xl text-center bg-gray-200 text-gray-700 font-semibold">
                <div class="grid grid-row-4">                        
                    <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{number_format($unconfirmedTransactionsByUser)}}</div>
                    <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">unconfirmated</div>
                </div>
            </div>
        </div>
        <div class="grid grid-rows-2 grid-cols-3 shadow-xl">
            <div class="row-span-2 p-5 grid content-center justify-center bg-yellow-300 text-gray-700">
                <span class="text-3xl font-lighr"><i class="fas fa-hand-holding-usd"></i></span>
            </div>
            <div class="col-span-2 row-span-2 text-2xl text-center bg-gray-200 text-gray-700 font-semibold">
                <div class="grid grid-row-4">                        
                    <div class="row-span-3 text-base text-center p-2 text-xl font-semibold"><span class="line-through">N</span>{{number_format($total_expected)}}</div>
                    <div class="row-span-1 bg-gray-300 text-gray-700 text-center py-1 text-base font-semibold">Expecting</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <p class="uppercase text-sm text-gray-700 md:p-2 my-2"> <i class="fa fa-suitcase"></i> Latest Project Investments | <span class="line-through">N</span>{{ number_format($myProjectSubscriptions->sum('amount_paid'))}} </p>
        @if (count($projectSubscriptions) > 0)                
            <table class="table-auto border-collapse w-full text-xs">
                <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                    <tr>
                    <th class="px-3 py-2 md:border">#</th>
                    {{-- <th class="px-3 py-2 md:border">Investor</th> --}}
                    <th class="px-3 py-2 md:border">Paid (<span class="line-through">N</span>)</th>
                    <th class="px-3 py-2 md:border">Status</th>
                    {{--<th class="px-3 py-2 md:border">Cycle Payment</th>--}}
                    <th class="px-3 py-2 md:border">Expectation</th>
                    <th class="px-3 py-2 md:border">Received</th>
                    <th class="px-3 py-2 md:border">Date</th>
                    </tr>
                </thead>
                <tbody class="font-light text-gray-600 content md:table-row-group">
                    @foreach ($projectSubscriptions as $subscription)                     
                        <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                            <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                             
                            {{-- <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> Amount Paid</span><span class="w-2/3 text-left">{{ $subscription->subscriber->name }}</span>
                            </td>                   --}}
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
                            {{--<td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Cycle Payment</span> <span class="w-2/3 text-left">{{number_format(((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid) / (ceil($subscription->project->duration / $subscription->project->payment_cycle)),2)}}</span>
                            </td>--}}
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Expectation</span>
                                <span class="w-2/3 text-left"> > {{ number_format(((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid), 2) }}</span>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Received</span>
                                <span class="w-2/3 text-left">{{ number_format($subscription->subscriptionPayOut->sum('amount'), 2) }}</span>
                            </td>
                            <td class="flex text-right md:text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Date</span>
                                <span class="w-2/3 text-left">{{ \Carbon\Carbon::parse($subscription->created_at)->diffForHumans()}}</span>
                            </td>
                        </tr>   
                    @endforeach
                    
                </tbody>
            </table>        
        @else
            <p class="font-light">No investment record found.</p>
        @endif
    </div>
</div>
