<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectSubcription;
use App\Models\User;
use Auth;

class Investors extends Component
{
    use WithPagination;

    public $investors_count;
    public $total_investment;
    public $total_expected = 0;

    public function mount(){
        
        $this->total_investment = ProjectSubcription::whereHas('subscriber')->sum('amount_paid');
        $this->investors_count = count(ProjectSubcription::whereHas('subscriber')->groupBy('user_id')->get());
        $allSubscriptions = ProjectSubcription::whereHas('subscriber')->groupBy('user_id')->get();
        foreach ($allSubscriptions as $subscription) {
            $amount_paid = ProjectSubcription::where('user_id', $subscription->subscriber->id)->sum('amount_paid');
            $this->total_expected += ((($subscription->project->roi_percent / 100) * $amount_paid) + $amount_paid); 
        }
    }

    public function render()
    {        
        return view('livewire.project.investors', [
            'subscriptions' => ProjectSubcription::groupBy('user_id')->paginate(10),
        ]);
    }
}
