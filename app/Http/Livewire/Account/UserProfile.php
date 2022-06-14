<?php

namespace App\Http\Livewire\Account;

use Livewire\Component;
use \App\Models\User;
use \App\Models\UserIdentityDetails;
use \App\Models\UserContactDetails;
use \App\Models\UserBankDetails;
use Livewire\WithFileUploads;
use Str;

class UserProfile extends Component
{
    use WithFileUploads;

    public $user = null;
    private $userIdentityDetails = null;
    private $userContactDetails = null;
    private $userBankDetails = null;
    public $passport_photo;
    public $passport_photo_temp;
    public $id_card;
    public $dob;
    public $gender;
    public $marital_status;
    public $nationality;
    public $state_of_origin;
    public $nin;
    public $qualification;
    public $phone;
    public $address;
    public $state;
    public $country;
    public $bank;
    public $account_number;
    public $bvn;
    
    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    public function mount($id){
        $this->user = User::find($id);
        if($this->user->identificationDetails){
            $this->dob = $this->user->identificationDetails->dob;
            $this->gender = $this->user->identificationDetails->gender;
            $this->marital_status = $this->user->identificationDetails->marital_status;
            $this->nationality = $this->user->identificationDetails->nationality;
            $this->state_of_origin = $this->user->identificationDetails->state_of_origin;
            $this->nin = $this->user->identificationDetails->NIN;
            $this->qualification = $this->user->identificationDetails->qualification;
            $this->passport_photo = $this->user->identificationDetails->passport_photo;
            $this->id_card = $this->user->identificationDetails->id_card;
        }
        if($this->user->contactDetails){
            $this->phone = $this->user->contactDetails->phone;
            $this->address = $this->user->contactDetails->address;
            $this->state = $this->user->contactDetails->state;
            $this->country = $this->user->contactDetails->country;
        }
        if($this->user->bankDetails){
            $this->bank = $this->user->bankDetails->bank;
            $this->account_number = $this->user->bankDetails->account_number;
            $this->bvn = $this->user->bankDetails->bvn;
        }
    }

    public function render()
    {
        return view('livewire.account.user-profile');
    }

    public function storeFile($photo, $dir){
        $fileName = Str::random(40).'.'.$photo->getClientOriginalExtension();
        $filePath = $photo->storeAs(
            'user/'.$dir, $fileName, 'public'
        );         
        // Save image to DB
        return $filePath;
    }

    public function saveIdentityInformation(){
        $validatedData = $this->validate([
            'dob' => 'required|before:-18 years',
            'gender' => "in:M,F",
            'marital_status' => 'in:S,M,D',
            'nationality' => 'required|string',
            'state_of_origin' => 'required|string',
            'nin' => 'nullable|string',
            'qualification' => 'nullable|string',
            'passport_photo_temp' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'id_card' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);       

        $passport_photo_path = null;
        $id_card_path = null;
        $identityInformation = null;

        if($this->passport_photo_temp) {$passport_photo_path = $this->storeFile($this->passport_photo_temp, 'passport_photo');}
        if($this->id_card) {$id_card_path = $this->storeFile($this->id_card, 'id_card');}
        
        if($this->user->identificationDetails){
            $identityInformation = UserIdentityDetails::where('user_id', $this->user->id)->update([
                'dob' => $this->dob,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'nationality' => $this->nationality,
                'state_of_origin' => $this->state_of_origin,
                'NIN' => $this->nin,
                'qualification' => $this->qualification,
                'passport_photo' => $passport_photo_path,
                'id_card' => $id_card_path,
            ]);
        }else {
            $identityInformation = UserIdentityDetails::create([
                'user_id' => $this->user->id,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'nationality' => $this->nationality,
                'state_of_origin' => $this->state_of_origin,
                'NIN' => $this->nin,
                'qualification' => $this->qualification,
                'passport_photo' => $passport_photo_path,
                'id_card' => $id_card_path,
            ]);            
        }
        if($identityInformation){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Identity Data Saved.']);
            $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Identity Data Saved.']);
        $this->resetState();
        return;
    }
    
    public function saveContactInformation(){
        $validatedData = $this->validate([
            'phone' => 'required',
            'address' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
        ]);   
        
        if($this->user->contactDetails){
            $contactDetails = UserContactDetails::where('user_id', $this->user->id)->update([                
                'phone' => $this->phone,
                'address' => $this->address,
                'state' => $this->state,
                'country' => $this->country,
            ]);
        }else {
            $contactDetails = UserContactDetails::create([
                'user_id' => $this->user->id,
                'phone' => $this->phone,
                'address' => $this->address,
                'state' => $this->state,
                'country' => $this->country,
            ]);            
        }
        if($contactDetails){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Contact Data Saved.']);
            $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Contact Data Saved.']);
        $this->resetState();
        return;
    }
    
    public function saveBvnInformation(){
        $validatedData = $this->validate([
            'bank' => 'required|string',
            'account_number' => 'required|max:10',
            'bvn' => 'required|max:11',
        ]);

        if($this->user->bankDetails){
            $bankDetails = UserBankDetails::where('user_id', $this->user->id)->update([                
                'bank' => $this->bank,
                'account_number' => $this->account_number,
                'bvn' => $this->bvn,
            ]);
        }else {
            $bankDetails = UserBankDetails::create([
                'user_id' => $this->user->id,
                'bank' => $this->bank,
                'account_number' => $this->account_number,
                'bvn' => $this->bvn,
            ]);            
        }
        if($bankDetails){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Bank Data Saved.']);
            $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Bank Data Saved.']);
        $this->resetState();
        return;
    }

    public function updateBioProfileInformation(){

    }

    public function resetState(){
        $this->passport_photo_temp = null;
        if($this->user->identificationDetails){
            $this->dob = $this->user->identificationDetails->dob;
            $this->gender = $this->user->identificationDetails->gender;
            $this->marital_status = $this->user->identificationDetails->marital_status;
            $this->nationality = $this->user->identificationDetails->nationality;
            $this->state_of_origin = $this->user->identificationDetails->state_of_origin;
            $this->nin = $this->user->identificationDetails->NIN;
            $this->qualification = $this->user->identificationDetails->qualification;
            $this->passport_photo = $this->user->identificationDetails->passport_photo;
            $this->id_card = $this->user->identificationDetails->id_card;
        }
    }
}
