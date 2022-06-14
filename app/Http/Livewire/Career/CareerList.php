<?php

namespace App\Http\Livewire\Career;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Career;
use Auth;
use Arr;

class CareerList extends Component
{
    use WithPagination;

    public $career_id = null;
    public $position;
    public $body;
    public $deleteCareerModal = false;
    public $updateCareerStatusModal = false;

    public function render()
    {
        return view('livewire.career.career-list', [            
            'careers' => Career::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function deleteCareer(Career $career){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Delete Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);

        $career = Career::find($this->career_id);
        if($career->delete()){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Career Post deleted successfully.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while deleting Career Post']);
        }
        $this->resetState();
    }

    public function confirmDeleteCareer(Career $career){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Delete Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);

        $this->career_id = $career->id;
        $this->deleteCareerModal = true;
    }

    public function confirmUpdateCareerStatus(Career $career){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Manage Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Unauthorized Action!!!']);

        $this->career_id = $career->id;
        $this->updateCareerStatusModal = true;
    }
    
    public function updateCareerStatus(Career $career){  
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
        $this->deleteCareerModal = false;
        $this->updateCareerStatusModal = false;
        $this->career = Career::find($this->career_id);
    }
}
