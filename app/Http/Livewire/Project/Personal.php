<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Livewire\WithPagination;
use Auth;

class Personal extends Component
{
    use WithPagination;

    // public $projects = [];
    public $updateProjectModal = false;
    public $deleteProjectModal = false;
    public $approveProjectModal = false;
    public $publishProjectModal = false;
    public $project_id;
    
    public function render()
    {
        return view('livewire.project.personal', [
            'projects' => Project::where('author', Auth::user()->id)->orderBy('id', 'DESC')->paginate(2),
        ]);
    }
    
    public function confirmUpdateProject(Project $project){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Manage Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->project_id = $project->id;
        $this->updateProjectModal = true;
    }

    public function confirmDeleteProject(Project $project){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Delete Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
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

    public function updateProjectRedirect(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Edit Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        return redirect()->route('projects.edit', $this->project_id);
    }

    public function deleteProject(Project $project){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Delete Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
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
            if($project->delete()) $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project deleted successfully.']);
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
            if($project->published and $project->approved){
                $this->emit('alert', ['type' => 'info', 'title' => 'Error', 'message' => 'Project is published. Only unpublished projects can be unapproved']);                
                $this->resetState();
                return;
            }
            $project->approved = !$project->approved;
            $project->update();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Project status updated successfully.']);
            $this->resetState();
        } else $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred updating Project Status']);     
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
