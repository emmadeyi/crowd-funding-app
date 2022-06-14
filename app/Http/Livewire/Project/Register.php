<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Models\ProjectPhoto;
use App\Models\ProjectFile;
use Arr;
use Str;
use Auth;


class Register extends Component
{
    use WithFileUploads;

    public $project_id;
    public $title;
    public $execution_cost = 0;
    public $duration = 0;
    public $description;
    public $projects;
    public $project;
    public $files = [];
    public $photos = [];
    private $validatedData = null;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'execution_cost' => 'numeric',
        'duration' => 'numeric',
        'files.*' => 'file|max:1024', // 1MB Max
        'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    ];

    public function render()
    {
        return view('livewire.project.register');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function registerProject(){
        // check role and permission
        if(!Auth::user()->hasAnyPermission(['Create Project']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        if($this->project_id){
            // Update
            $project = Project::find($this->project_id);
            if($project->author > 0){
                $project->update(Arr::only($this->validatedData, ['title', 'description', 'execution_cost', 'duration']));
            }else{
                $project->update(['title' => $this->validatedData['title'], 'description' => $this->validatedData['description'], 'execution_cost' => $this->validatedData['execution_cost'], 'duration' => $this->validatedData['duration'], 'author' => Auth::user()->id]);
            }
        }else{
            $this->validatedData = $this->validate([
                'title' => 'required|min:3',
                'description' => 'required|min:10',
                'execution_cost' => 'numeric',
                'duration' => 'numeric',
                'files.*' => 'file|max:1024', // 1MB Max
                'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);
            // save
            $project = Project::create(['title' => $this->validatedData['title'], 'description' => $this->validatedData['description'], 'execution_cost' => $this->validatedData['execution_cost'], 'duration' => $this->validatedData['duration'], 'author' => Auth::user()->id]);
        }
        
        if($project){
            $this->projects = Project::all();  
            if(count($this->photos) > 0) {
                foreach ($this->photos as $photo) { 
                    $filePath = $this->storeFile($photo, 'photos');
                    if($filePath)ProjectPhoto::create(['url' => $filePath, 'project_id' => $project->id]);
                }
            }
            if(count($this->files) > 0) {
                foreach ($this->files as $file) { 
                    $filePath = $this->storeFile($file, 'files');
                    if($filePath)ProjectFile::create(['url' => $filePath, 'project_id' => $project->id]);
                }
            }
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'project data saved successfully.']);
            $value = true;
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting project data']);
            $value = false;
        }
        $this->resetState();
        return $value;
    }

    public function storeFile($photo, $dir){
        $fileName = Str::random(40).'.'.$photo->getClientOriginalExtension();
        $filePath = $photo->storeAs(
            'project/'.$dir, $fileName, 'public'
        );         
        // Save image to DB
        return $filePath;
    }

    public function updateProjectData($id, $data, $photos, $files){
        $this->project_id = $id;
        $this->files = $files;
        $this->photos = $photos;
        $this->validatedData = $data;
        return $this->registerProject();
    }

    public function resetState(){
        $this->title = null;
        $this->execution_cost = null;
        $this->duration = null;
        $this->description = null;
        $this->files = [];
        $this->photos = [];
        $this->projects = Project::all();
        $this->validatedData = null;
        $this->project_id = null;
    }
}
