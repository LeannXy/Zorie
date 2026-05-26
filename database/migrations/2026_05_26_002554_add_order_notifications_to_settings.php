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
       Schema::table(
    'settings',
    function($table){

        $table->boolean(
            'new_order_notification'
        )->default(true);

        $table->boolean(
            'order_status_notification'
        )->default(true);

        $table->boolean(
            'payment_notification'
        )->default(true);

    }
);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
