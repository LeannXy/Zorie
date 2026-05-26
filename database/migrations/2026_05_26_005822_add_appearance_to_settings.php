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
    Schema::table(
        'settings',
        function($table){

            $table->boolean(
                'compact_sidebar'
            )->default(false);

            $table->boolean(
                'fixed_header'
            )->default(true);

            $table->boolean(
                'show_animations'
            )->default(true);

            $table->boolean(
                'show_statistics'
            )->default(true);

            $table->boolean(
                'show_product_chart'
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
