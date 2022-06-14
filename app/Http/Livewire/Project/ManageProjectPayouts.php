<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use \App\Models\Project;
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

class ManageProjectPayouts extends Component
{
    use WithPagination;

    public $projects;
    public $amount_paid = 0;
    public $cycle_count = 1;
    public $selected_projects;
    public $pendingPayouts;
    public $paginate_value = 10;
    public $confirmPayoutModal = false;
    public $msg = null;

    public function mount(){
        $this->projects = Project::whereHas('creator')->where('approved', true)->pluck('title', 'id');
        $projects = [];
        foreach ($this->projects as $key => $value) {
            # code...
            array_push($projects, $key);
        }
        $this->pendingPayouts = $this->getPendingSubscriptionPayouts($projects);
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
            $this->pendingPayouts = $this->getPendingSubscriptionPayouts($projects);
        }else{
            $this->pendingPayouts = $this->getPendingSubscriptionPayouts($this->selected_projects);
        }        
        return view('livewire.project.manage-project-payouts', [
            'payouts' => $this->paginate($this->pendingPayouts, $this->paginate_value)
        ]);
    }

    public function toggleConfirmPayoutModal(){
        // check role and permission 
        if(!Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->confirmPayoutModal = true;
    }

    public function confirmPayout(){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->confirmPayoutModal = false;              
        if($this->selected_projects == null or $this->amount_paid <= 0){ 
            $this->msg = 'select project and Fill in amount';
            return;
        }
        $this->msg = null;
        foreach ($this->pendingPayouts as $data) {
            $this->subscriptionPayOut($data);
        }
    }

    public function subscriptionPayOut($data){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        // check if subscription is active
        $subscription = $data[0];
        $recieved = $data[1];
        $expected = $data[2];
        // $cycle_amount = $data[3];
        // $cycle_count = $data[5];
        // $subscription_cycle_count = ceil($subscription['project']['duration'] / $subscription['project']['payment_cycle']);
        // $cycle_payment = $expected / $subscription_cycle_count;
        $user_id = $subscription['subscriber']['id'];

        if($subscription['confirmation'] != '2' || !$subscription['status']){
            $this->emit('alert', ['type' => 'info', 'title' => 'Inactive', 'message' => 'Subscription not active']);
            return;
        }

        // check payouts of subscription
        // if($this->checkPayoutFulfillment($subscription['id'])){
        //     $this->emit('alert', ['type' => 'info', 'title' => 'Fulfilled', 'message' => 'Subscription payout completely fulfilled']);
        //     return;
        // }

        // if($cycle_count <= 0){
        //     $this->emit('alert', ['type' => 'info', 'title' => 'Invalid Data', 'message' => 'Invalid Cycle count']);
        //     return;
        // }

        // if($cycle_count > $subscription_cycle_count){
        //     $cycle_count = ($expected - $recieved) / $cycle_payment;
        // }

        // if(($recieved + $cycle_amount) > $expected){
        //     $cycle_amount = ($expected - $recieved) / $cycle_count;
        // }
        
        $transaction = $this->saveTransaction($subscription, $this->amount_paid);
        if($transaction){
            $payout = SubscriptionPayout::create(['transaction_id' => $transaction, 'subscription_id' => $subscription['id'], 'user_id' => $user_id, 'admin_id' => Auth::user()->id, 'amount' => $this->amount_paid]);
            if($payout){
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Subsription Payout submitted']);
            }else{
                $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting Subsription Payout']);
            }
            // for ($i=1; $i <= intval($cycle_count); $i++) { 
            // }
            $this->emit('alert', ['type' => 'info', 'title' => 'Saved', 'message' => 'Subscription Transaction data saved']);
            // $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting transaction details']);
        // $this->resetState();
        return;
    }

    public function saveTransaction($subscription, $amount_paid){
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Transaction']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $transaction = New Transaction();
        $transaction->user_id = $subscription['subscriber']['id'];
        $transaction->admin_id = Auth::user()->id;
        $transaction->amount = $amount_paid;
        $transaction->type = '1';

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
                // if($recieved >= $expected) continue;
                $cycle_amount = ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid) / (ceil($subscription->project->duration / $subscription->project->payment_cycle));
                $subscription_cycle_count = ceil($subscription->project->duration / $subscription->project->payment_cycle);
                $cycle_count = $this->cycle_count;

                // if($cycle_count <= 0) $cycle_count = 1;

                // if($cycle_count > $subscription_cycle_count){
                //     $cycle_count = ($expected - $recieved) / $cycle_amount;                    
                // }

                // if(($cycle_amount * $cycle_count) + $recieved > $expected){
                //     $cycle_count = ($expected - $recieved) / $cycle_amount;
                // }

                array_push($getAllPendingSubscriptionPayouts, [$subscription, $recieved, $expected]);
                // array_push($getAllPendingSubscriptionPayouts, [$subscription, $recieved, $expected, $cycle_amount * $cycle_count, $cycle_amount, $cycle_count,]);
                // dd($getAllPendingSubscriptionPayouts);
                // if(($expected - $recieved) <= $expected) array_push($getAllPendingSubscriptionPayouts, [$subscription, $recieved, $expected, $cycle_amount * $cycle_count, $cycle_amount, $cycle_count,]);
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
        $this->projects = [];
        $this->cycle_count = 1;
        $this->amount_paid = 0;
        $this->paginate_value = 10;
        $this->confirmPayoutModal = false;
        $this->msg = null;
        $projects = [];
        if(empty($this->selected_projects)){
            foreach ($this->projects as $key => $value) {
                # code...
                array_push($projects, $key);
            }
            $this->pendingPayouts = $this->getPendingSubscriptionPayouts($projects);
        }else{
            $this->pendingPayouts = $this->getPendingSubscriptionPayouts($this->selected_projects);
        }
        
        if($this->cycle_count <= 0) $this->cycle_count = 1;
        
    }
}
