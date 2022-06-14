<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankDetails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'bank', 'account_number', 'bvn'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
