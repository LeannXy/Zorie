<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;

class OrderItem extends Model
{
    protected $fillable = [

        'order_id',
        'product_id',
        'quantity',
        'price',
        'size',

    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function items()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }
    public function testimonial() {
    return $this->hasOne(Testimonial::class, 'product_id', 'product_id')
                ->where('testimonials.order_id', $this->order_id);
}

}
