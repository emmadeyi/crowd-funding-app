<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutineMaintenanceFee extends Model
{
    use HasFactory;
    protected $fillable = ['reference', 'transaction_id', 'user_id', 'amount_paid', 'status', 'confirmation', 'renewal_date'];

    public function subscriber(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
