<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [

        'customer_id',
        'product_id',
        'size',
        'qty'

    ];

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            CustomerAccount::class,
            'customer_id'
        );
    }

    public function carts()
    {
        return $this->hasMany(
            Cart::class,
            'product_id'
        );
    }
}
