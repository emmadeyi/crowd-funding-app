<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectSubcription;
use Auth;

class ProjectSubscriptions extends Component
{
    use WithPagination;

    public $project_id;
    public $project_title;

    public function mount($project){
        $this->project_id = $project;
        $this->project_title = ProjectSubcription::where('project_id', $this->project_id)->first()->project->title;
    }
    
    public function render()
    {
        return view('livewire.project.project-subscriptions', [
            'subscriptions' => ProjectSubcription::where('project_id', $this->project_id)->orderBy('updated_at', 'DESC')->paginate(10)
        ]);
    }

    public function checkPayoutFulfillment($subscription){
        if($subscription->subscriptionPayOut->sum('amount') >= ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)){
            return true;
        }
        return false;
    }
}
