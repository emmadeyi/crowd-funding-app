<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Crypt;
use Auth;

class Detail extends Component
{
    public $project;    
    public $project_id;
    public $updateProjectModal = false;
    public $subcribeProjectModal = false;
    public $deleteProjectModal = false;
    public $approveProjectModal = false;
    public $publishProjectModal = false;
    public $checkROIDetailsState = false;
    public $roiDetailsModal = false;
    // public $roi_percentage;
    public $min_investment;
    public $payment_cycle;
    public $payment_start;
    public $execution_start_date;
    
    public function mount($project)
    {
        $this->project = $project;
        $this->project_id = $project->id;
        if($this->checkROIDetails()) $this->checkROIDetailsState = true;
    }

    public function render()
    {
        return view('livewire.project.detail');
    }

    public function confirmUpdateProject(Project $project){
        
        // check role and permission
        if(Auth::user()->id !== $project->id && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->project_id = $project->id;
        $this->updateProjectModal = true;
    }

    public function updateProjectRedirect(){        
        // check role and permission
        if(Auth::user()->id !== $this->project->id && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }

        return redirect()->route('projects.edit', Crypt::encrypt($this->project_id));
    }
    
    public function confirmSubscribeProject(Project $project){        
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }

        if(!$this->project->approved || !$this->project->published)
        {
            $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project is not yet approved or published. Only approved and published project are subscribable']);
            return false;
        }
        $this->project_id = $project->id;
        $this->subcribeProjectModal = true;
    }

    public function subscribeProjectRedirect(){        
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Subscription']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }

        return redirect()->route('projects.subscribe',  Crypt::encrypt($this->project_id));
    }

    public function confirmDeleteProject(Project $project){        
        // check role and permission
        if(Auth::user()->id !== $project->id && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }

        $this->project_id = $project->id;
        $this->deleteProjectModal = true;
    }
    public function confirmPublishProject(Project $project){        
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->project_id = $project->id;
        $this->publishProjectModal = true;
    }
    public function confirmApproveProject(Project $project){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->project_id = $project->id;
        $this->approveProjectModal = true;
    }

    public function deleteProject(Project $project){
        // check role and permission
        if(Auth::user()->id !== $project->id && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $project = Project::find($this->project_id);
        if($project){
            if($project->published or $project->approved){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project not Deleted. Cannot delete a published or approved project']);                
                $this->resetState();
                return;
            }
            if(count($project->projectSubscription->where('status', true)) > 0){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project not Deleted. Cannot delete a project with an active subscription']);                
                $this->resetState();
                return;
            }
            if($project->delete()) {
                // delete project photos
                if(count($project->photo) > 0){
                    foreach ($project->photo as $photo) {
                        // Clear from project photos on DB
                        $photo->delete();
                        $photo_path = $photo->url;
                        if(Storage::disk('public')->exists($photo_path)){
                            Storage::disk('public')->delete($photo_path);
                        }
                    }
                }
                // delete project files
                if(count($project->file) > 0){
                    foreach ($project->file as $file) {
                        // Clear from project files on DB
                        $file->delete();
                        $file_path = $file->url;
                        if(Storage::disk('public')->exists($file_path)){
                            Storage::disk('public')->delete($file_path);
                        }
                    }
                }
                return redirect()->route('projects.manage');
                // $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project deleted successfully.']);
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while deleting Project']);
        }
        $this->resetState();
    }

    public function publishProject(Project $project){ 
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $project = Project::find($this->project_id);
        if($project){
            // Check if approve
            if(!$project->approved){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project not Approved. Only Approved projects can be Published']);                
                $this->resetState();
                return;
            }
            $project->published = !$project->published;
            $project->update();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project status updated successfully.']);
            $this->resetState();
        } else $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred updating Project Status']);     
    }

    public function approveProject(Project $project){ 
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        } 
        $project = Project::find($this->project_id);
        if($project){
            // check if project is unpublished before unapproving
            if($project->published && $project->approved){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project is published. Only unpublished projects can be unapproved']);                
                $this->resetState();
                return;
            }

            if(!$project->execution_cost || $project->execution_cost <= 0 || !$project->duration || $project->duration <= 0){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project duration/ cycle or execution cost not set. Only project with complete details can be approved']);                
                $this->resetState();
                return;
            }
            
            if(!$this->checkROIDetails()) {
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project ROI details not set. Add ROI details before approval.']);                
                $this->resetState();
                return;
            };

            $project->approved = !$project->approved;
            $project->update();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project status updated successfully.']);
            $this->resetState();
        } else $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred updating Project Status']);     
    }

    private function checkROIDetails(){
        if($this->project){
            $this->execution_start_date = $this->project->execution_start_date;
            // $this->roi_percentage = $this->project->roi_percent;
            $this->payment_cycle = $this->project->payment_cycle;
            $this->payment_start = $this->project->payment_starts;
            $this->min_investment = $this->project->min_investment;
        }

        if(($this->project->min_investment && $this->project->min_investment > 0) && ($this->project->payment_cycle && $this->project->payment_cycle > 0) && ($this->project->payment_starts && $this->project->payment_starts > 0) && ($this->project->execution_start_date && $this->project->execution_start_date > 0)) return true;
        // if(($this->project->roi_percent && $this->project->roi_percent > 0) && ($this->project->min_investment && $this->project->min_investment > 0) && ($this->project->payment_cycle && $this->project->payment_cycle > 0) && ($this->project->payment_starts && $this->project->payment_starts > 0) && ($this->project->execution_start_date && $this->project->execution_start_date > 0)) return true;
        return false;
    }

    public function showROIDetailsModal(Project $project){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->roiDetailsModal = true;
    }

    public function saveROIDetails(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        // check for payouts 
        if(count($this->project->projectSubscription) > 0){
            $this->emit('alert', ['type' => 'info', 'title' => 'ROI Error', 'message' => 'ROI details not updated. Cannot update project ROI details with an existing subscription']);
            $this->resetState();
            return;
        }

        $validatedData = $this->validate([
            // 'roi_percentage' => 'required|numeric',
            'min_investment' => 'required|numeric',
            'payment_cycle' => 'required|numeric',
            'payment_start' => 'required|numeric',
            'execution_start_date' => 'required|date',
        ]);

        $project = Project::find($this->project->id);
        $project->duration = (ceil($this->project->duration / $this->payment_cycle)) * $this->payment_cycle;
        // $project->roi_percent = $this->roi_percentage;
        $project->min_investment = $this->min_investment;
        $project->payment_cycle = $this->payment_cycle;
        $project->payment_starts = $this->payment_start;
        $project->execution_start_date = $this->execution_start_date;
        
        if($project->update()){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project ROI Details saved']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting Project ROI Details']);
        }
        $this->resetState();
    }

    public function resetState(){
        // $this->projects = Project::paginate(2);
        $this->updateProjectModal = false;
        $this->deleteProjectModal = false;
        $this->approveProjectModal = false;
        $this->publishProjectModal = false;
        $this->project = Project::find($this->project_id);
        if($this->checkROIDetails()) $this->checkROIDetailsState = true;
        else $this->checkROIDetailsState = false;
        $this->roiDetailsModal = false;
    }
}
