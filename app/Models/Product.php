<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Cart;
use App\Models\ProductSize;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'discount',
        'description',
        'weight',
    ];

    
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function categories()
    {
        return $this->belongsToMany(
            Category::class
        );
    }

    public function carts()
    {
        return $this->hasMany(
            Cart::class,
            'product_id'
        );
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function reviews()
    {
        return $this->hasMany(Testimonial::class)
            ->where('status', 'Approved')
            ->latest();
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }
}
