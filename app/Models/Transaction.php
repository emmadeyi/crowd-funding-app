<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'user_id', 'admin_id', 'amount', 'status'];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function administrator(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function subscriptionPayout(){
        return $this->hasMany(SubscriptionPayout::class);
    }

    public function projectSubscription(){
        return $this->hasMany(ProjectSubcription::class);
    }

    public function routineMaintenanceFee(){
        return $this->hasMany(RoutineMaintenanceFee::class);
    }
}
