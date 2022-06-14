<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use \App\Models\Project;
use \App\Models\ProjectSubcription;
use \App\Models\Transaction;
use \App\Models\SubscriptionPayout;
use Auth;

class InvestmentDetails extends Component
{
    public $subscription;
    public $subscription_id;
    public $project;
    public $confirmSubscriptionModal = false;
    public $cancelSubscriptionModal = false;
    public $toggleSubscriptionModal = false;
    public $deleteSubscriptionModal = false;
    public $subscriptionPayOutModal = false;
    public $confirmation;
    public $cycle_count = 1;
    public $cycle_payment = 0;
    public $total_expected = 0;
    public $current_payout = 0;
    public $pay_amount = 0;

    protected $rules = [
        // 'cycle_count' => 'required|numeric',
        'pay_amount' => 'required|numeric',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($subscription){
        $this->subscription = $subscription;
        $this->subscription_id = $subscription->id;
        $this->project = $this->subscription->project;
        $this->cycle_payment = ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid) / (ceil($subscription->project->duration / $subscription->project->payment_cycle));
        $this->total_expected = ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid);
    }
    
    public function render()
    {
        return view('livewire.project.investment-details', [
            'projectSubscriptions' => ProjectSubcription::where('user_id', $this->subscription->subscriber->id)->where('project_id', $this->project->id)->orderBy('updated_at', 'DESC')->paginate(10)
        ]);
    }

    public function confirmSubscriptionPayment(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->confirmSubscriptionModal = true;  
        $this->subscription_id = $subscription->id;
        $this->subscription = $subscription;
    }

    public function cancelSubscriptionConfirmation(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->cancelSubscriptionModal = true;  
        $this->subscription_id = $subscription->id;
        $this->subscription = $subscription;
    }

    public function toggleSubscriptionConfirmation(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->toggleSubscriptionModal = true;  
        $this->subscription_id = $subscription->id;
        $this->subscription = $subscription;
    }

    public function confirmSubscriptionPayOut(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->subscriptionPayOutModal = true;  
        $this->subscription_id = $subscription->id;
        $this->subscription = $subscription;
    }

    public function subscriptionPayOut(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Payout']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        // check if subscription is active

        if($this->subscription->confirmation != '2' || !$this->subscription->status){
            $this->emit('alert', ['type' => 'info', 'title' => 'Inactive', 'message' => 'Subscription not active']);
            $this->resetState();
            return;
        }

        // check payouts of subscription
        // if($this->checkPayoutFulfillment($this->subscription)){
        //     $this->emit('alert', ['type' => 'info', 'title' => 'Fulfilled', 'message' => 'Subscription payout completely fulfilled']);
        //     $this->resetState();
        //     return;
        // }

        $validatedData = $this->validate([
            // 'cycle_count' => 'required|numeric|max:'.(ceil($this->subscription->project->duration / $this->subscription->project->payment_cycle)),
            'pay_amount' => 'required|numeric|max:'.$this->pay_amount,
        ]);

        if($validatedData['pay_amount'] < 0){
            $this->emit('alert', ['type' => 'info', 'title' => 'Invalid Data', 'message' => 'Invalid amount']);
            $this->resetState();
            return;
        }
        
        $transaction = $this->saveTransaction();
        if($transaction){
            $payout = SubscriptionPayout::create(['transaction_id' => $transaction, 'subscription_id' => $this->subscription_id, 'user_id' => $this->subscription->subscriber->id, 'admin_id' => Auth::user()->id, 'amount' => $this->pay_amount]);
            if($payout){
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Subsription Payout submitted']);
            }else{
                $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting Subsription Payout']);
            }
            // for ($i=1; $i <= intval($validatedData['cycle_count']); $i++) { 
            // }
            $this->emit('alert', ['type' => 'info', 'title' => 'Saved', 'message' => 'Subscription Transaction data saved']);
            $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting transaction details']);
        $this->resetState();
    }

    public function saveTransaction(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Transaction']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $transaction = New Transaction();
        $transaction->user_id = $this->subscription->subscriber->id;
        $transaction->admin_id = Auth::user()->id;
        $transaction->amount = $this->pay_amount;
        $transaction->type = '1';

        if($transaction->save()) return $transaction->id;
        return false;
    }

    public function checkPayoutFulfillment($subscription){
        if($subscription->subscriptionPayout->sum('amount') >= ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)){
            return true;
        }
        return false;
    }

    public function checkForPayout($subscription){
        if($subscription->subscriptionPayOut->sum('amount') > 0){
            return true;
        }
        return false;
    }

    public function deleteSubscriptionPayment(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Delete Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->deleteSubscriptionModal = true;  
        $this->subscription_id = $subscription->id;
        $this->subscription = $subscription;
    }

    public function confirmPayment(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $subscription = ProjectSubcription::find($this->subscription_id);
        if($subscription){
            if($subscription->confirmation == '2'){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Subscription already confirmed']);                
                $this->resetState();
                return;
            }
            $subscription->confirmation = '2';
            $subscription->status = true;
            if($subscription->update()) {
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Subscription confirmed successfully.']);
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while confirming Subscription']);
        }

        $this->resetState();
    }

    public function cancelConfirmation(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $subscription = ProjectSubcription::find($this->subscription_id);
        if($subscription){
            if($subscription->confirmation == '0' || $subscription->confirmation == '1'){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Subscription not confirmed yet']);                
                $this->resetState();
                return;
            }
            $subscription->confirmation = '1';
            $subscription->status = false;
            if($subscription->update()) {
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Subscription cancelled successfully.']);
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while cancelling Subscription']);
        }

        $this->resetState();
    }
    public function toggleSubscription(ProjectSubcription $subscription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $subscription = ProjectSubcription::find($this->subscription_id);
        if($subscription){

            // Check if existing pay order/ request.
            if(($subscription->status && $subscription->confirmation > 0) || !$subscription->status && $subscription->confirmation > 0){
                $subscription->confirmation = '0';
                $subscription->status = false;
            }elseif($this->checkForPayout($subscription)){
                $subscription->confirmation = '2';
                $subscription->status = true;
            }else{
                $subscription->confirmation = '1';
                $subscription->status = false;
            }

            if($subscription->update()) {
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Subscription closed successfully.']);
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while closing Subscription']);
        }

        $this->resetState();
    }

    public function deletePayment(ProjectSubcription $projectSubcription){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Delete Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $subscription = ProjectSubcription::find($this->subscription_id);
        if($this->checkForPayout($subscription)){
            $this->emit('alert', ['type' => 'info', 'title' => 'Existing Payment', 'message' => 'Cannot delete data. Subscription payout exist']);
            $this->resetState();
            return;
        }
        if($subscription){
            if($subscription->confirmation == '2'){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Subscription not Deleted. Cannot delete a confirmed subscription']);                
                $this->resetState();
                return;
            }
            if($subscription->delete()) {
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Subscription deleted successfully.']);

                return redirect()->route('projects.my-investment');
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while deleting Subscription']);
        }
        $this->resetState();
        return;
    }

    public function resetState(){        
        $this->confirmSubscriptionModal = false;    
        $this->cancelSubscriptionModal = false;    
        $this->toggleSubscriptionModal = false;    
        $this->deleteSubscriptionModal = false;
        $this->subscriptionPayOutModal = false;     
        $this->subscription = ProjectSubcription::find($this->subscription_id);   
        $this->confirmation = $this->subscription->confirmation; 
        $this->cycle_payment = ((($this->subscription->project->roi_percent / 100) * $this->subscription->amount_paid) + $this->subscription->amount_paid) / (ceil($this->subscription->project->duration / $this->subscription->project->payment_cycle));
        $this->total_expected = ((($this->subscription->project->roi_percent / 100) * $this->subscription->amount_paid) + $this->subscription->amount_paid);  
        $this->cycle_count = 1;
        $this->current_payout = 0;
        $this->pay_amount = 0;
    }
}
