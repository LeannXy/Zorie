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
    Schema::table('category_banners', function (Blueprint $table) {

        $table->enum(
            'banner_type',
            [
                'main',
                'secondary'
            ]
        )
        ->default('secondary')
        ->after('button_text');

    });
}

public function down(): void
{
    Schema::table('category_banners', function (Blueprint $table) {

        $table->dropColumn(
            'banner_type'
        );

    });
}
};
