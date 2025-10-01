<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $fillable = [
        'name',
        'data_limit',
        'price',
        'currency',
        'duration',
        'description',
        'image'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
