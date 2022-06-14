<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayout extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'subscription_id', 'user_id', 'admin_id', 'amount', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }    

    public function projectSubscription(){
        return $this->belongsTo(ProjectSubcription::class, 'subscripton_id');
    }
}
