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
    Schema::create('customer_accounts', function ($table) {

        $table->id();

        $table->string('name');

        $table->string('email')->unique();

        $table->string('phone')->nullable();

        $table->text('address')->nullable();

        $table->string('profile_photo')->nullable();

        $table->enum(
            'status',
            [
                'Active',
                'Blocked'
            ]
        )->default(
            'Active'
        );

        $table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_accounts');
    }
};
