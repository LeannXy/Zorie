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
    Schema::table('customer_accounts', function ($table) {

        $table->enum(
            'gender',
            ['Male', 'Female']
        )->nullable();

        $table->date(
            'date_of_birth'
        )->nullable();

        $table->boolean(
            'email_verified'
        )->default(false);

        $table->boolean(
            'phone_verified'
        )->default(false);

    });
}

public function down(): void
{
    Schema::table('customer_accounts', function ($table) {

        $table->dropColumn([
            'gender',
            'date_of_birth',
            'email_verified',
            'phone_verified'
        ]);

    });
}

    /**
     * Reverse the migrations.
     */
   
};
