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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('price_unit')->nullable();
            $table->decimal('plot_area', 10, 2)->nullable();
            $table->boolean('boundary_wall')->default(false);
            $table->string('preferred_tenant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'price_unit',
                'plot_area',
                'boundary_wall',
                'preferred_tenant'
            ]);
        });
    }
};
