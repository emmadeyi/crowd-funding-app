<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectSubcription;
use Auth;

class ManageSubscriptions extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.project.manage-subscriptions', [
            'projectSubscriptions' => ProjectSubcription::orderBy('updated_at', 'DESC')->paginate(10)
        ]);
    }

    public function checkPayoutFulfillment($subscription){
        if($subscription->subscriptionPayOut->sum('amount') >= ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)){
            return true;
        }
        return false;
    }
}
