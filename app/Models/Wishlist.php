<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
    ];

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relasi ke Akun Pelanggan
    public function customer()
    {
        return $this->belongsTo(CustomerAccount::class, 'customer_id');
    }
}