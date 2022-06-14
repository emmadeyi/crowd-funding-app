<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-users"></i> Investors - ( 
        <span class="w-2/3 text-left"> <i class="far fa-address-book"></i> {{ $investors_count }} | <i class="fas fa-clipboard-list"></i> <span class="line-through">N</span>{{number_format($total_investment)}} | <i class="fas fa-hand-holding-usd"></i> <span class="line-through">N</span>{{number_format($total_expected)}} </span>
    )</p>
    @if ($investors_count > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Name</th></th>
                <th class="px-3 py-2 md:border">No. Projects</th>
                <th class="px-3 py-2 md:border">Invested (<span class="line-through">N</span>)</th>
                <th class="px-3 py-2 md:border">Payouts (<span class="line-through">N</span>)</th>
                <th class="px-3 py-2 md:border">Expectation (<span class="line-through">N</span>)</th>                      
                @if(auth()->user()->canany(['Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                    <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                <?php $expected = 0; ?>
                @foreach ($subscriptions as $subscription) 
                    @if ($subscription->subscriber)                        
                        <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                            <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>                    
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Investor</span> <span class="w-2/3 text-left">{{ $subscription->subscriber->name }}</span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                                <span class="font-bold w-1/3 text-left md:hidden block"> No. Project</span><span class="w-2/3 text-left">{{ App\Models\ProjectSubcription::where('user_id', $subscription->subscriber->id)->groupBy('project_id')->count() }}</span>
                            </td>
                            <?php
                                $amount_paid = App\Models\ProjectSubcription::where('user_id', $subscription->subscriber->id)->sum('amount_paid');
                                $payout = App\Models\SubscriptionPayout::where('user_id', $subscription->subscriber->id)->sum('amount');
                            ?>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Invested</span> <span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format($amount_paid) }}</span>
                            </td>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Payouts</span> <span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format($payout) }}</span>
                            </td>
                            <?php 
                                $expected = ((($subscription->project->roi_percent / 100) * $amount_paid) + $amount_paid);
                                $this->total_expected += $expected; 
                            ?>
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Expectation</span>
                                <span class="w-2/3 text-left"> > <span class="line-through">N</span>{{ number_format($expected, 2) }}</span>
                            </td>
                            @if(auth()->user()->canany(['Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                    <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                    <span class="w-2/3 text-left">
                                        <a href="{{route('projects.user-investment', Crypt::encrypt($subscription->subscriber->id))}}">
                                            <x-jet-button href="">
                                                <span class="text-xs">Details</span>
                                            </x-jet-button>
                                        </a>
                                    </span>
                                </td>
                            @endif
                        </tr>   
                    @endif
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $subscriptions->links() }}  
        </div>
    
    @else
        <p class="font-light">No investor record found.</p>
    @endif
</div>
@section('custome-styles')

@endsection
