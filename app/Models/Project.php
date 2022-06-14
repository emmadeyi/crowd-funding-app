<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'execution_cost', 'duration', 'roi_percent', 'start_date', 'image', 'author', 'contribution_status'];

    public function photo(){
        return $this->hasMany(ProjectPhoto::class);
    }

    public function file(){
        return $this->hasMany(ProjectFile::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'author');
    }

    public function projectSubscription(){
        return $this->hasMany(ProjectSubcription::class);
    }
}
