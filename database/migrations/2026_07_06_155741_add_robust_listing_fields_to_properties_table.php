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
            $table->decimal('security_deposit', 12, 2)->nullable()->after('price');
            $table->string('lease_duration')->nullable()->after('billing_frequency');
            $table->date('available_from')->nullable()->after('status');
            $table->integer('floor_number')->nullable()->after('built_up_area');
            $table->integer('total_floors')->nullable()->after('floor_number');
            $table->string('facing_direction')->nullable()->after('total_floors');
            $table->integer('carpet_area')->nullable()->after('built_up_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'security_deposit',
                'lease_duration',
                'available_from',
                'floor_number',
                'total_floors',
                'facing_direction',
                'carpet_area',
            ]);
        });
    }
};
