<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Testimonial;
use App\Models\Cart;
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
        'otp_expires_at',
        
        'gender',
        'date_of_birth',
        'email_verified',
        'phone_verified',
        'provider',

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

    public function carts()
    {
        return $this->hasMany(
            Cart::class,
            'customer_id'
        );
    }

    public function addresses()
{
    return $this->hasMany(
        Address::class,
        'customer_id'
    );
}
}
