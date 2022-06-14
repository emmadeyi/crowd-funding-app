<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Http\Livewire\Project\Register;
use Crypt;
use Auth;

class Edit extends Component
{
    use WithFileUploads;

    public $title;
    public $execution_cost = 0;
    public $duration = 0;
    public $description;
    public $projects;
    public $project;
    public $files = [];
    public $photos = [];
    public $project_id;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'execution_cost' => 'numeric',
        'duration' => 'numeric',
        'files.*' => 'file|max:1024', // 1MB Max
        'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    ];

    public function mount($project)
    {
        $this->project_id = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->execution_cost = $project->execution_cost;
        $this->duration = $project->duration;
    }

    public function render()
    {
        return view('livewire.project.edit');
    }

    public function submitData(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Edit Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $validatedData = $this->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'execution_cost' => 'numeric',
            'duration' => 'numeric',
            'files.*' => 'file|max:1024', // 1MB Max
            'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $project = new Register();
        $update = $project->updateProjectData($this->project_id, $validatedData, $this->photos, $this->files);
        if($update){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'project data saved successfully.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting project data']);
        }
        $this->resetState();
        return redirect()->route('projects.details', Crypt::encrypt($this->project_id));
    }

    public function resetState(){
        // $this->title = null;
        // $this->execution_cost = null;
        // $this->duration = null;
        // $this->description = null;
        $this->files = [];
        $this->photos = [];
        $this->projects = Project::all();
        // $this->project_id = null;
    }
}
