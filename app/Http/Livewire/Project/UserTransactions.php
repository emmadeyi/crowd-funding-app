<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use \App\Models\Transaction;
use \App\Models\SubscriptionPayout;
use \App\Models\RoutineMaintenanceFee;
use \App\Models\ProjectSubcription;
use Livewire\WithPagination;
use Auth;

class UserTransactions extends Component
{   
    use WithPagination;

    public $confirmPayoutStatusModal = false;
    public $payouts = [];
    public $transaction;
    public $user;
    public $allTransaction;
    public $unconfirmedTransactions;

    public function mount($user){
        $this->user = $user;
        $this->allTransaction = Transaction::where('user_id', $this->user->id)->orderBy('id', 'DESC')->get();
        $this->unconfirmedTransactions = $this->getUnconfirmedTransactions($this->allTransaction);
    }
    
    private function getUnconfirmedTransactions($transactions){
        $unconfirmedTransactions = 0;
        foreach ($transactions as $transaction) {
            # code...
            switch ($transaction->type) {
                case '1':
                    # code... Payout
                    $unconfirmedTransactions += SubscriptionPayout::where('transaction_id', $transaction->id)->where('status', false)->sum('amount');
                    break;
                case '2':
                    # code... Subscriptions
                    $unconfirmedTransactions += ProjectSubcription::where('transaction_id', $transaction->id)->where('status', false)->sum('amount_paid');
                    break;
                case '3':
                    # code... maintenance
                    $unconfirmedTransactions += RoutineMaintenanceFee::where('transaction_id', $transaction->id)->where('status', false)->sum('amount_paid');
                    break;
                
                default:
                    $unconfirmedTransactions += 0;
                    break;
            }
        }
        return $unconfirmedTransactions;
    }

    public function render()
    {
        return view('livewire.project.user-transactions',[
            'transactions' => Transaction::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function confirmPayoutStatus(Transaction $transaction){
        // check role and permission
        if(Auth::user()->id !== $transaction->user_id && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->transaction = $transaction;
        $this->confirmPayoutStatusModal = true;        
    }

    public function togglePaymentStatus(Transaction $transaction){
        // check role and permission
        if(Auth::user()->id !== $transaction->user_id && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $transaction = Transaction::find($this->transaction->id);
        if($transaction){
            $transaction->status = !$transaction->status;
            if($transaction->update()){
                switch ($transaction->type) {
                    case '1':
                        # code... Payout
                        $this->updatePayoutStatus($transaction->id, $transaction->status);
                        break;
                    case '2':
                        # code... Subscription
                        $this->updateProjectSubscriptionStatus($transaction->id, $transaction->status);
                        break;
                    case '3':
                        # code... Maintenance
                        $this->updateMaintenanceFeeStatus($transaction->id, $transaction->status);
                        break;
                    
                    default:
                        $this->emit('alert', ['type' => 'info', 'title' => 'Update', 'message' => 'Transaction type status not updated']);
                        break;
                }

                $this->emit('alert', ['type' => 'info', 'title' => 'Update', 'message' => 'Transaction status updated']);
                $this->resetState();
                return;
            }
            $this->emit('alert', ['type' => 'info', 'title' => 'Update Failed', 'message' => 'Transaction status not updated']);
            $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'info', 'title' => 'Invalid data', 'message' => 'Transaction data not found']);
        $this->resetState();
        return;
    }

    public function updatePayoutStatus($id, $status){
        $transactions = SubscriptionPayout::where('transaction_id', $id)->get();
        foreach ($transactions as $transaction) {
           $transaction->status = $status;
            $transaction->update();
        }
        $this->emit('alert', ['type' => 'info', 'title' => 'Update', 'message' => 'Payout transaction status updated']);
        return;
    }

    public function updateMaintenanceFeeStatus($id, $status){
        $transactions = RoutineMaintenanceFee::where('transaction_id', $id)->get();
        foreach ($transactions as $transaction) {
           $transaction->status = $status;
            $transaction->update();
        }
        $this->emit('alert', ['type' => 'info', 'title' => 'Update', 'message' => 'Maintenance Fee transaction status updated']);
        return;
    }

    public function updateProjectSubscriptionStatus($id, $status){
        $transactions = ProjectSubcription::where('transaction_id', $id)->get();
        foreach ($transactions as $transaction) {
           $transaction->status = $status;
            $transaction->update();
        }
        $this->emit('alert', ['type' => 'info', 'title' => 'Update', 'message' => 'Subscription transaction status updated']);
        return;
    }

    public function resetState(){        
        $this->transaction = null;
        $this->confirmPayoutStatusModal = false;     
        $this->unconfirmedTransactions = $this->getUnconfirmedTransactions($this->allTransaction);    
    }
}
