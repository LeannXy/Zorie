<?php

namespace App\Models;
use App\Models\Category;
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
];

public function images(){
    return $this->hasMany(ProductImage::class);
}
public function categories()
{
    return $this->belongsToMany(
        Category::class
    );
}
}