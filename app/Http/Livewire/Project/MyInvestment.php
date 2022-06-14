<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectSubcription;
use Auth;

class MyInvestment extends Component
{
    use WithPagination;

    public $user;

    public $investors_count;
    public $total_investment;
    public $total_expected = 0;

    public function mount($user){        
        $this->user = $user;
        $this->total_investment = ProjectSubcription::where('user_id', $this->user->id)->sum('amount_paid');
        $this->investors_count = ProjectSubcription::where('user_id', $this->user->id)->count();
        $allSubscriptions = ProjectSubcription::where('user_id', $this->user->id)->get();
        foreach ($allSubscriptions as $subscription) {
            $this->total_expected += ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid); 
        }
    }

    public function render()
    {
        return view('livewire.project.my-investment', [
            'projectSubscriptions' => ProjectSubcription::where('user_id', $this->user->id)->orderBy('updated_at', 'DESC')->paginate(10)
        ]);
    }

    public function checkPayoutFulfillment($subscription){
        if($subscription->subscriptionPayOut->sum('amount') >= ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)){
            return true;
        }
        return false;
    }
}
