<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    protected $fillable = [

        'name',
        'email',
        'phone',
        'address',
        'profile_photo',
        'status'

    ];

    public function orders()
    {
        return $this->hasMany(
            Order::class,
            'customer_id'
        );
        
    }
}
