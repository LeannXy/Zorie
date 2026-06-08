<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel customer_accounts
            $table->foreignId('customer_id')
                  ->constrained('customer_accounts')
                  ->onDelete('cascade');
                  
            // Menghubungkan ke tabel products
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
                  
            $table->timestamps();

            // Mencegah duplikasi produk yang sama di wishlist pelanggan yang sama
            $table->unique(['customer_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};