<?php

namespace App\Http\Livewire\Career;

use Livewire\Component;
use App\Models\Career;
use Auth;

class Show extends Component
{
    public $career;
    public $career_id;
    public $deleteCareerPostModal = false;
    public $updateCareerPostStatusModal = false;

    public function mount($career){
        $this->career = $career;
    }

    public function render()
    {
        return view('livewire.career.show');
    }

    public function deleteCareerPost(Career $career){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Delete Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);

        $career = Career::find($career->id);
        if($career->delete()){
            if(Storage::disk('public')->exists($career->image)){
                Storage::disk('public')->delete($career->image);
            }
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Career Post deleted successfully.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while deleting Career Post']);
        }
        $this->resetState();
    }

    public function confirmDeleteCareerPost(Career $career){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Delete Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);

        $this->career_id = $career->id;
        $this->deleteCareerPostModal = true;
    }

    public function confirmUpdateCareerPostStatus(Career $career){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Manage Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);

        $this->career_id = $career->id;
        $this->updateCareerPostStatusModal = true;
    }
    
    public function updateCareerPostStatus(Career $career){ 
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Manage Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);
         
        $career = Career::find($this->career_id);
        if($career){
            $career->publish = !$career->publish;
            $career->update();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Career Post status updated successfully.']);
            $this->resetState();
        } else $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred updating Career Post Status']);     
    }

    public function resetState(){
        $this->deleteCareerPostModal = false;
        $this->updateCareerPostStatusModal = false;
        $this->career = Career::find($this->career_id);
    }
}
