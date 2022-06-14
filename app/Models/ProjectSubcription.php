<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSubcription extends Model
{
    use HasFactory;
    protected $fillable = ['reference', 'transaction_id', 'project_id', 'user_id', 'amount_paid', 'status', 'confirmation'];

    public function subscriber(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function subscriptionPayout(){
        return $this->hasMany(SubscriptionPayout::class, 'subscription_id');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
