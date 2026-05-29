<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [

        'customer_id',

        'product_id',

        'rating',

        'comment',

        'status'

    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }
    public function customer()
    {
        return $this->belongsTo(
            CustomerAccount::class,
            'customer_id'
        );
    }
}
