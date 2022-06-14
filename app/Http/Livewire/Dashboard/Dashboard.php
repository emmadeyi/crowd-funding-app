<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use \App\Models\Transaction;
use \App\Models\SubscriptionPayout;
use \App\Models\RoutineMaintenanceFee;
use \App\Models\ProjectSubcription;
use Auth;

class Dashboard extends Component
{
    public $confirmtotal_tatusModal = false;
    public $total_ = [];
    public $transaction;
    public $allTransaction;
    public $unconfirmedTransactions;
    public $unconfirmedTransactionsByUser;

    public function mount(){
        $this->allTransaction = Transaction::orderBy('id', 'DESC')->get();
        $this->unconfirmedTransactions = $this->getUnconfirmedTransactions($this->allTransaction);
        $this->unconfirmedTransactionsByUser = $this->getUnconfirmedTransactionsByUser($this->allTransaction);
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

    private function getUnconfirmedTransactionsByUser($transactions){
        $unconfirmedTransactionsByUser = 0;
        foreach ($transactions as $transaction) {
            # code...
            switch ($transaction->type) {
                case '1':
                    # code... Payout
                    $unconfirmedTransactionsByUser += SubscriptionPayout::where('transaction_id', $transaction->id)->where('status', false)->where('user_id', Auth::user()->id)->sum('amount');
                    break;
                case '2':
                    # code... Subscriptions
                    $unconfirmedTransactionsByUser += ProjectSubcription::where('transaction_id', $transaction->id)->where('status', false)->where('user_id', Auth::user()->id)->sum('amount_paid');
                    break;
                case '3':
                    # code... maintenance
                    $unconfirmedTransactionsByUser += RoutineMaintenanceFee::where('transaction_id', $transaction->id)->where('status', false)->where('user_id', Auth::user()->id)->sum('amount_paid');
                    break;
                
                default:
                    $unconfirmedTransactionsByUser += 0;
                    break;
            }
        }
        return $unconfirmedTransactionsByUser;
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard', [
            'transactions' => Transaction::orderBy('id', 'DESC')->get(),
            'subscriptions' => ProjectSubcription::where('status', true)->sum('amount_paid'),
            'maintenance_fees' => RoutineMaintenanceFee::where('status', true)->sum('amount_paid'),
            'total_payouts' => SubscriptionPayout::where('status', true)->sum('amount'),
            'projectSubscriptions' => ProjectSubcription::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->limit(10)->get(),
            'myProjectSubscriptions' => ProjectSubcription::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->get(),
        ]);
    }

    public function checkPayoutFulfillment($subscription){
        if($subscription->subscriptionPayout->sum('amount') >= ((($subscription->project->roi_percent / 100) * $subscription->amount_paid) + $subscription->amount_paid)){
            return true;
        }
        return false;
    }
}
