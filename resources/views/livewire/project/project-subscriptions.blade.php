<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    <a href="{{route('projects.details', Crypt::encrypt($project_id))}}"><p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-credit-card"></i> Subscriptions - ( 
        <span class="w-2/3 text-left">{{ $project_title }}</span>
    )</p></a>
    @if (count($subscriptions) > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Investor</th></th>
                <th class="px-3 py-2 md:border">Paid (<span class="line-through">N</span>)</th>
                <th class="px-3 py-2 md:border">Status</th>
                <th class="px-3 py-2 md:border">ROI (%)</th>
                <th class="px-3 py-2 md:border">Expectation</th>
                <th class="px-3 py-2 md:border">Date</th>
                @if(auth()->user()->canany(['Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                    <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($subscriptions as $subscription) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>
                        {{-- <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Subs</span>
                            <a href="{{route('projects.investment-details', ['user' => Crypt::encrypt($subscription->user_id), 'id' => Crypt::encrypt($subscription->id)])}}">
                                <span class="w-2/3 text-left">{{ $subscription->project->title }}</span>
                            </a>
                        </td> --}}                        
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Investor</span> <span class="w-2/3 text-left">{{ $subscription->subscriber->name }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                            <span class="font-bold w-1/3 text-left md:hidden block"> Amount Paid</span><span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format($subscription->amount_paid) }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Status</span>
                            <span class="w-2/3 text-left">@if ($this->checkPayoutFulfillment($subscription))
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
                            </span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> ROI %</span> <span class="w-2/3 text-left">{{ $subscription->project->roi_percent }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Expectation</span>
                            <span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format(((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)) }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Date</span>
                            <span class="w-2/3 text-left">{{ \Carbon\Carbon::parse($subscription->created_at)->diffForHumans()}}</span>
                        </td>
                        @if(auth()->user()->canany(['Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))                        
                            <td class="flex text-left md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                                <span class="font-bold w-1/3 text-left md:hidden block"> #</span>
                                <span class="w-2/3 text-left">
                                    <a href="{{route('projects.investment-details', ['user' => Crypt::encrypt($subscription->user_id), 'id' => Crypt::encrypt($subscription->id)])}}">
                                        <x-jet-button href="">
                                            <span class="text-xs">Details</span>
                                        </x-jet-button>
                                    </a>
                                </span>                            
                            </td>
                        @endif
                    </tr>   
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $subscriptions->links() }}  
        </div>
    
    @else
        <p class="font-light">No subscription record found.</p>
    @endif
</div>
@section('custome-styles')

@endsection
