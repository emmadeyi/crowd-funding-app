<div>
    @if(Session::has('err-msg'))
        <p class="p-3 text-gray-200 bg-red-400 font-light rounded">{{ Session::get('err-msg') }}</p>
    @endif 
    <p class="uppercase text-base text-gray-700 md:p-2 my-2"> <i class="fa fa-list"></i> Project List</p>
    @if (count($projects) > 0)                
        <table class="table-auto border-collapse w-full text-xs">
            <thead class="bg-gray-700 text-yellow-300 border-b border-gray-300 text-left md:table-row-group hidden">
                <tr>
                <th class="px-3 py-2 md:border">#</th>
                <th class="px-3 py-2 md:border">Project</th>
                <th class="px-3 py-2 md:border">Launch</th>
                <th class="px-3 py-2 md:border">Cost (<span class="line-through">N</span>)</th>
                <th class="px-3 py-2 md:border">Subs</th>
                <th class="px-3 py-2 md:border">Status</th>
                <th class="px-3 py-2 md:border">Date</th>
                @if(auth()->user()->canany(['Read Project', 'Manage Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                <th class="px-3 py-2 md:border">Action</th>
                @endif
                </tr>
            </thead>
            <tbody class="font-light text-gray-600 content md:table-row-group">
                @foreach ($projects as $project) 
                    <tr class="block md:table-row border border-gray-300 md:border-0 p-3 rounded mb-3">
                        <td class="hidden md:table-cell md:px-3 py-2 md:border">{{ $loop->iteration }}</td>
                        @if(auth()->user()->can('Read Project') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Project</span>
                                <a href="{{route('projects.details', Crypt::encrypt($project->id))}}">
                                    <span class="w-2/3 text-left">{{ $project->title }}</span>
                                </a>
                            </td>
                        @else
                            <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                                <span class="font-bold w-1/3 text-left md:hidden block"> Project</span>
                                <span class="w-2/3 text-left">{{ $project->title }}</span>
                            </td>
                        @endif
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                            <span class="font-bold w-1/3 text-left md:hidden block"> Launch</span><span class="w-2/3 text-left">{{ $project->execution_start_date }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                            <span class="font-bold w-1/3 text-left md:hidden block"> Cost</span><span class="w-2/3 text-left"><span class="line-through">N</span>{{ number_format($project->execution_cost) }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border"> 
                            <span class="font-bold w-1/3 text-left md:hidden block"> Subscriptions</span><span class="w-2/3 text-left">{{ count($project->projectSubscription) }} | <span class="line-through">N</span>{{ number_format($project->projectSubscription->sum('amount_paid')) }}</span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Status</span>
                            <span class="w-2/3 text-left">
                                @if ($project->approved && $project->published)
                                    <span class="text-green-400">Published</span>
                                @else                                        
                                    @if ($project->approved && !$project->published)
                                        Confirmed
                                    @else
                                        @if (!$project->approved && !$project->published)
                                            Not Confirmed
                                        @else
                                            Error
                                        @endif
                                    @endif
                                @endif
                            </span>
                        </td>
                        <td class="flex text-left md:table-cell md:px-3 py-2 md:border">
                            <span class="font-bold w-1/3 text-left md:hidden block"> Date</span>
                            <span class="w-2/3 text-left">{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans()}}</span>
                        </td>
                        @if(auth()->user()->canany(['Read Project', 'Read Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                        <td class="flex justify-end md:table-cell md:py-2 px-2 md:border" data-label='Action'>
                            <span class="text-right">
                                @if(auth()->user()->can('Read Project') || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                    <a title="Project Details" href="{{route('projects.details', Crypt::encrypt($project->id))}}">
                                        <x-jet-button href="">
                                            <span class="text-xs">
                                                <i class="fa fa-info"></i>
                                            </span>
                                        </x-jet-button>
                                    </a>
                                @endif
                                @if(auth()->user()->canany(['Manage Subscription']) || auth()->user()->hasanyrole('Administrator|Developer|Super Admin|'))
                                    <a title="Subscriptions" href="{{route('project.subscriptions', Crypt::encrypt($project->id))}}">
                                        <x-jet-button href="">
                                            <span class="text-xs">
                                                <i class="fas fa-credit-card"></i>
                                            </span>
                                        </x-jet-button>
                                    </a>
                                @endif
                            </span>
                            
                        </td>
                        @endif
                    </tr>   
                @endforeach
                
            </tbody>
        </table>
        <div class="mt-5 border-t border-gray-300 py-5">
            {{ $projects->links() }}  
        </div>
    
    @else
        <p class="font-light">No project record found.</p>
    @endif
</div>
@section('custome-styles')

@endsection
