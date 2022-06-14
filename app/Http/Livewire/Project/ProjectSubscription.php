<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectSubcription;
use App\Models\RoutineMaintenanceFee;
use App\Models\AppSetting;
use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
use Paystack;
use Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

class ProjectSubscription extends Component
{
    public $project;    
    public $project_id;
    public $amount;
    public $maintenance_fee; //make a global variable
    public $cancelSubscriptiontModal = false;
    public $subcribeProjectModal = false;
    public $setting_data;
    public $acceptTerms = false;

    protected $rules = [
        'amount' => 'required|numeric',
        'maintenance_fee' => 'required|numeric',
    ];

    protected $listeners = ['continueTransaction' => 'continueTransaction'];

    public function mount($project)
    {
        $this->project = $project;
        $this->project_id = $project->id;
        $this->amount = $project->min_investment;
        $this->setting_data = AppSetting::where('name', 'annual_subscription')->first();
        count(Auth::user()->routineMaintenanceFee->where('renewal_date', '>=', Carbon::now()->toDateTimeString())->where('status', true)) <= 0 ?  $this->maintenance_fee = $this->setting_data->value : $this->maintenance_fee = 0;
    }
    public function render()
    {
        return view('livewire.project.project-subscription');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function confirmCancelSubscription(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        return redirect()->route('projects.details', Crypt::encrypt($this->project_id));
    }

    public function confirmSubscriptionPayment(Project $project){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        if(!$this->acceptTerms) {
            $this->emit('alert', ['type' => 'Info', 'title' => 'Subscription Info', 'message' => 'Please accept Terms and Conditions before proceeding.']);
            return;
        }
        $this->subcribeProjectModal = true;        
        $this->project_id = $project->id;
    }

    public function confirmPayment(){   
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }  
        if(!$this->acceptTerms) {
            $this->emit('alert', ['type' => 'Info', 'title' => 'Subscription Info', 'message' => 'Please accept Terms and Conditions before proceeding.']);
            return;
        }             
        $this->subcribeProjectModal = false;
        $this->validatedData = $this->validate([
            'amount' => 'required|numeric|min:'.$this->project->min_investment,
            'maintenance_fee' => 'required|numeric|min:'.$this->maintenance_fee,
        ]);
        // Check Account and bank details set
        $reference = Paystack::genTranxRef(); //create transaction reference
        // dispatche event for paystack api call
        $this->dispatchBrowserEvent('make_payment', ['email' => Auth::user()->email, 'amount' => $this->maintenance_fee + $this->amount, 'reference' => $reference]); 
    }

    public function saveTransaction($amount, $type, $status, $user, $admin){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Transaction']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $transaction = New Transaction();
        $transaction->user_id = $user;
        $transaction->admin_id = $admin;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->status = $status;

        if($transaction->save()) return $transaction;
        return false;
    }

    public function continueTransaction($reference){
        $response = $this->verifyPaysatckTransaction($reference);
        if($response->data->status == 'success'){
            if($this->maintenance_fee > 0){
                if($transaction = $this->saveTransaction($this->maintenance_fee, '3', true, Auth::user()->id, 0)){
                    $transaction_id = $transaction->id; 
                    $paid = RoutineMaintenanceFee::create([
                        'reference' => $reference,
                        'transaction_id' => $transaction_id,
                        'user_id' => Auth::user()->id,
                        'amount_paid' => $this->maintenance_fee,
                        'status' => true,
                        'confirmation' => '2',
                        'renewal_date' => $current_date_time = Carbon::now()->addDays(365)->toDateTimeString(),
                    ]);
        
                    if($paid){
                        $this->emit('alert', ['type' => 'info', 'title' => 'Saved', 'message' => 'Annual Maintenance '.$response->data->status]);
                    }
                }
            }

            if($transaction = $this->saveTransaction($this->amount, '2', true, Auth::user()->id, 0)){
                $transaction_id = $transaction->id;                
                $subscription = ProjectSubcription::create([
                    'reference' => $reference,
                    'transaction_id' => $transaction_id,
                    'project_id' => $this->project->id,
                    'user_id' => Auth::user()->id,
                    'amount_paid' => $this->amount,
                    'status' => true,
                    'confirmation' => '2',
                    'acceptTerms' => $this->acceptTerms,
                ]);
        
                
                if($subscription){
                    $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project Subscription '.$response->data->status]);
        
                    $this->resetState();
                    // redirect to subscription list page
                    return redirect()->route('projects.user-investment', Crypt::encrypt(Auth::user()->id));
                }
            }
            // redirect back        
            $this->resetState();
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while updating subscription']); 
        }
        
        $this->emit('alert', ['type' => 'info', 'title' => 'Transaction Info', 'message' => 'Trasaction: '.$response->data->status.'']);  
    }

    private function verifyPaysatckTransaction($reference){
        $curl = curl_init();  
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/".rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY')."",
            "Cache-Control: no-cache",
            ),
        ));        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);        
        if ($err) {
            $this->emit('alert', ['type' => 'error', 'Payment Verification Error' => 'Error', 'message' => 'Error #:'.$err]);
            $this->resetState();
            return;   
        } 
        return json_decode($response);
    }

    private function resetState(){        
        $this->amount = $this->project->min_investment;
        count(Auth::user()->routineMaintenanceFee->where('renewal_date', '>=', Carbon::now()->toDateTimeString())->where('status', true)) <= 0 ?  $this->maintenance_fee = $this->setting_data->value : $this->maintenance_fee = 0;
        $this->subcribeProjectModal = false;
        $this->acceptTerms = false;
    }
}
