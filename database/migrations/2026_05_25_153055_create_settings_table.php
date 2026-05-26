<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create(
        'settings',
        function($table){

            $table->id();

            $table->string(
                'store_name'
            )->nullable();

            $table->string(
                'store_email'
            )->nullable();

            $table->string(
                'store_phone'
            )->nullable();

            $table->string(
                'currency'
            )->default('IDR');

            $table->string(
                'timezone'
            )->default(
                'Asia/Jakarta'
            );

            $table->boolean(
                'maintenance_mode'
            )->default(false);

            $table->boolean(
                'auto_backup'
            )->default(false);

            $table->timestamps();

        }
    );
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
