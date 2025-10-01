<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'payment_gateway',
        'amount',
        'currency',
        'status',
        'transaction_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }
}
