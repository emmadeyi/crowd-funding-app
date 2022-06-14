<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIdentityDetails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dob', 'gender', 'marital_status', 'nationality', 'state_of_origin', 'NIN', 'qualification', 'passport_photo', 'id_card'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
