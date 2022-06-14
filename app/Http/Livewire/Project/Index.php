<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Livewire\WithPagination;
use Storage;

class Index extends Component
{
    use WithPagination;

    // public $projects = [];
    // public $project;
    public $updateProjectModal = false;
    public $deleteProjectModal = false;
    public $approveProjectModal = false;
    public $publishProjectModal = false;
    public $project_id;
    public $checkROIDetailsState = false;
    
    public function render()
    {
        return view('livewire.project.index', [
            'projects' => Project::orderBy('id', 'DESC')->paginate(2),
        ]);
    }
    
    public function confirmUpdateProject(Project $project){
        $this->project_id = $project->id;
        $this->updateProjectModal = true;
    }

    public function confirmDeleteProject(Project $project){
        $this->project_id = $project->id;
        $this->deleteProjectModal = true;
    }
    public function confirmPublishProject(Project $project){
        $this->project_id = $project->id;
        $this->publishProjectModal = true;
    }
    public function confirmApproveProject(Project $project){
        $this->project_id = $project->id;
        $this->approveProjectModal = true;
    }

    public function updateProjectRedirect(){
        return redirect()->route('projects.edit', $this->project_id);
    }

    public function deleteProject(Project $project){
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
                $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project deleted successfully.']);
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while deleting Project']);
        }
        $this->resetState();
    }

    public function publishProject(Project $project){ 
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
        $project = Project::find($this->project_id);
        if($project){
            // check if project is unpublished before unapproving
            if($project->published and $project->approved){
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
        $project = Project::find($this->project_id);
        if($project) if(($project->roi_percent && $project->roi_percent > 0) && ($project->min_investment && $project->min_investment > 0) && ($project->payment_cycle && $project->payment_cycle > 0) && ($project->payment_starts && $project->payment_starts > 0) && ($project->execution_start_date && $project->execution_start_date > 0)) return true;
        return false;
    }

    public function resetState(){
        // $this->projects = Project::paginate(2);
        $this->updateProjectModal = false;
        $this->deleteProjectModal = false;
        $this->approveProjectModal = false;
        $this->publishProjectModal = false;
        $this->project_id = null;
    }


}
