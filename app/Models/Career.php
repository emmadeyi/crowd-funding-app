<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = ['position', 'description', 'author', 'close_date', 'salary_range', 'publish', 'location'];

    public function creator(){
        return $this->belongsTo(User::class, 'author');
    }
}
