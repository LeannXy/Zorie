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
        'status',
        'password',

        'otp_code',
        'otp_expires_at'

    ];
    protected $hidden = [
        'password'
    ];

    public function orders()
    {
        return $this->hasMany(
            Order::class,
            'customer_id'
        );
    }

    public function testimonials()
    {
        return $this->hasMany(
            Testimonial::class,
            'customer_id'
        );
    }
}
