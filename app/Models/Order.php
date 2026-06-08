<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',

        'address',
        'city',
        'postal_code',
        'shipping_cost',

        'total',
        'payment_method',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function items()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            CustomerAccount::class
        );
    }
}
