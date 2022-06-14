<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use \App\Models\Project;
use App\Models\User;
use \App\Models\SubscriptionPayout;
use \App\Models\RoutineMaintenanceFee;
use \App\Models\ProjectSubcription;
use \App\Models\Transaction;
use Livewire\WithPagination;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LogTransaction extends Component
{
    use WithPagination;

    public $projects;
    protected $users;
    public $amount_paid = 0;
    public $cycle_count = 1;
    public $selected_projects;
    public $selected_user;
    public $pendingPayouts;
    public $paginate_value = 10;
    public $confirmTransactionModal = false;
    public $msg = null;

    public function mount(){
        $this->projects = Project::whereHas('creator')->where('approved', true)->pluck('title', 'id');
        $this->users = User::orderBy('id', 'DESC')->pluck('name', 'id');
        
        $projects = [];
        foreach ($this->projects as $key => $value) {
            # code...
            array_push($projects, $key);
        }        
        // $this->pendingPayouts = $this->getPendingSubscriptionPayouts($projects);
    }    

    public function render()
    {
        $this->paginate_value <= 0 ? $this->paginate_value = 1 : $this->paginate_value = $this->paginate_value;
        $this->cycle_count <= 0 ? $this->cycle_count = 1 : $this->cycle_count = $this->cycle_count;
        
        $projects = [];
        if(empty($this->selected_projects)){
            foreach ($this->projects as $key => $value) {
                # code...
                array_push($projects, $key);
            }
            // $this->pendingPayouts = $this->getPendingSubscriptionPayouts($projects);
        }else{
            // $this->pendingPayouts = $this->getPendingSubscriptionPayouts($this->selected_projects);
        }        
        return view('livewire.project.log-transaction', [
            // 'payouts' => $this->paginate($this->pendingPayouts, $this->paginate_value),
            'users' => User::orderBy('id', 'DESC')->pluck('name', 'id')
        ]);
    }

    public function toggleConfirmTransactionModal(){
        // check role and permission        
        if($this->selected_user == null or $this->selected_projects == null or $this->amount_paid <= 0){ 
            $this->msg = 'Fill in amount and select user and project';
            return;
        }
        $this->msg = null;
        if(!Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->confirmTransactionModal = true;
    }

    public function confirmPayout(){
        // check role and permission
        $this->confirmTransactionModal = false;
        if(!Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        if($this->selected_user == null or $this->selected_projects == null or $this->amount_paid <= 0){ 
            $this->msg = 'Fill in amount and select user and project';
            return;
        }
        $this->msg = null;
        $this->logTransaction(intval($this->selected_user), intval($this->selected_projects), intval($this->amount_paid));        
    }

    public function logTransaction($user, $project, $amount){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        
        if($transaction = $this->saveTransaction($user, $project, $amount)){
            $transaction_id = $transaction;                
            $subscription = ProjectSubcription::create([
                    'reference' => 'null_by_admin',
                    'transaction_id' => $transaction_id,
                    'project_id' => $project,
                    'user_id' => $user,
                    'amount_paid' => $amount,
                    'status' => true,
                    'confirmation' => '2',
                    'acceptTerms' => true,
            ]);
            if($subscription){
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project Subscription Added']);    
                $this->resetState();
                return redirect()->route('subscriptions.manage');
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting transaction details']);
        }
        
        $this->resetState();
        return;
    }

    public function saveTransaction($user, $project, $amount){
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Transaction']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $transaction = New Transaction();
        $transaction->user_id = $user;
        $transaction->admin_id = Auth::user()->id;
        $transaction->amount = $amount;
        $transaction->type = '2';

        if($transaction->save()) return $transaction->id;
        return false;
    }
   
    public function paginate($items, $perPage = 10, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);  
        // ['path' => Paginator::resolveCurrentPath()]      
    }

    private function getPendingSubscriptionPayouts($projects){
        $getAllPendingSubscriptionPayouts = [];
        foreach ($projects as $project) {
            # code...
            $subscriptions = ProjectSubcription::where('project_id', $project)->where('status', true)->get();
            foreach($subscriptions as $subscription){
                $recieved = $subscription->subscriptionPayout->sum('amount');
                $expected = ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid);
                if($recieved >= $expected) continue;
                $cycle_amount = ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid) / (ceil($subscription->project->duration / $subscription->project->payment_cycle));
                $subscription_cycle_count = ceil($subscription->project->duration / $subscription->project->payment_cycle);
                $cycle_count = $this->cycle_count;

                if($cycle_count <= 0) $cycle_count = 1;

                if($cycle_count > $subscription_cycle_count){
                    $cycle_count = ($expected - $recieved) / $cycle_amount;                    
                }

                if(($cycle_amount * $cycle_count) + $recieved > $expected){
                    $cycle_count = ($expected - $recieved) / $cycle_amount;
                }

                if(($expected - $recieved) <= $expected) array_push($getAllPendingSubscriptionPayouts, [$subscription, $recieved, $expected, $cycle_amount * $cycle_count, $cycle_amount, $cycle_count,]);
            }
        }
        return $getAllPendingSubscriptionPayouts;
    }

    public function checkPayoutFulfillment($subscription){
        $subscription = ProjectSubcription::find($subscription);
        // dd($subscription->subscriptionPayout->sum('amount'));
        if($subscription->subscriptionPayout->sum('amount') >= ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)){
            return true;
        }
        return false;
    }

    public function getSubscriptionPayouts(){
        // get pending payouts for selected projects
        $this->pendingPayouts = $this->getPendingSubscriptionPayouts($this->selected_projects);
    }

    public function resetState(){
        $this->selected_projects = [];
        $this->selected_user = 0;
        $this->projects = [];
        $this->cycle_count = 1;
        $this->paginate_value = 10;
        $this->confirmTransactionModal = false;
        $projects = [];
        $this->msg = null;
        $users = User::orderBy('id', 'DESC')->pluck('name', 'id');
        // if(empty($this->selected_projects)){
        //     foreach ($this->projects as $key => $value) {
        //         # code...
        //         array_push($projects, $key);
        //     }
        //     $this->pendingPayouts = $this->getPendingSubscriptionPayouts($projects);
        // }else{
        //     $this->pendingPayouts = $this->getPendingSubscriptionPayouts($this->selected_projects);
        // }
        
        if($this->cycle_count <= 0) $this->cycle_count = 1;
        
    }
    // public function render()
    // {
    //     return view('livewire.project.log-transaction');
    // }
}
