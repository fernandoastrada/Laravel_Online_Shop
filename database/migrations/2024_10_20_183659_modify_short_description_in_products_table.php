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
        Schema::table('products', function (Blueprint $table) {
            //
            $table->text('short_description')->nullable()->change();
            $table->bigInteger('regular_price')->change();
            $table->bigInteger('sale_price')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->string('short_description', 255)->nullable()->change();
            $table->decimal('regular_price')->change();
            $table->decimal('sale_price')->change();
        });
    }
};
