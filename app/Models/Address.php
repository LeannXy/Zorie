<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [

        'customer_id',

        'recipient_name',

        'phone',

        'province',

        'city',

        'district',

        'postal_code',

        'address',

        'google_maps_url',

        'is_default'

    ];

    public function customer()
    {
        return $this->belongsTo(
            CustomerAccount::class,
            'customer_id'
        );
    }
}