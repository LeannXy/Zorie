<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryBanner;
use App\Models\Product;

class Category extends Model
{
    protected $fillable=[

        'name',
        'slug',
        'description',
        'status',
        'featured',
        'image'

    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class
        );
    }
    public function banners()
{
    return $this->hasMany(
        CategoryBanner::class
    );
}
}