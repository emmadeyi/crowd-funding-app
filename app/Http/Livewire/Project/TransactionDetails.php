<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use \App\Models\Transaction;
use Livewire\WithPagination;
use \App\Models\SubscriptionPayout;
use \App\Models\RoutineMaintenanceFee;
use \App\Models\ProjectSubcription;
use Auth;

class TransactionDetails extends Component
{

    use WithPagination;

    public $transactions;
    public $transaction;
    public $transaction_type;
    public $transactions_total;
    public $confirmPayoutStatusModal = false;
    public $transaction_details = null;
    
    public function mount($id, $type){
        $this->transaction_type = $type;
        $this->transaction = Transaction::find($id); 
        switch ($type) {
            case '1':
                # code... Payout
                $this->transactions = SubscriptionPayout::where('transaction_id', $id)->get();
                break;
            case '2':
                # code... Subscriptions
                $this->transactions = ProjectSubcription::where('transaction_id', $id)->get();
                break;
            case '3':
                # code... maintenance
                $this->transactions = RoutineMaintenanceFee::where('transaction_id', $id)->get();
                break;
            
            default:
                return redirect()->route('projects.transactions');
                break;
        }
    }

    public function render()
    {
        // dd($this->transaction, $this->transactions);
        return view('livewire.project.transaction-details');
    }

    public function confirmPayoutStatus(Transaction $transaction){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Transaction']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->transaction_details = $transaction;
        $this->confirmPayoutStatusModal = true;
    }

    public function togglePaymentStatus(Transaction $transaction){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Transaction']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $transaction = $this->transactions->find($this->transaction_details->id);
        if($transaction){
            $transaction->status = !$transaction->status;
            if($transaction->update()){  
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

    private function checkTransactionsStatus($transactions){        
        // check updates
        $pendingTransactionsCount = $this->transactions->where('status', false)->count();
        if($pendingTransactionsCount <= 0) return $this->transaction->update(['status' => true]);
        return $this->transaction->update(['status' => false]);
    }

    public function resetState(){        
        $this->confirmPayoutStatusModal = false;
        $this->checkTransactionsStatus($this->transactions);        
    }
}
