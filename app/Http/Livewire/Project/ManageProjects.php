<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectSubcription;
use Livewire\WithPagination;

class ManageProjects extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.project.manage-projects', [
            'projects' => Project::whereHas('creator')->orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
