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
       Schema::table('orders', function (Blueprint $table) {

    $table->text('address')->nullable();

    $table->string('city')->nullable();

    $table->string('postal_code')->nullable();

    $table->integer('shipping_cost')->default(0);

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['address', 'city', 'postal_code', 'shipping_cost']);
        });
    }
};
