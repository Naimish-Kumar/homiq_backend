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
        Schema::table('property_requests', function (Blueprint $table) {
            $table->string('tenant_type')->nullable()->after('move_in_date'); // Working Professional, Family, Student, Bachelor, Company
            $table->string('furnishing_preference')->nullable()->after('tenant_type'); // Furnished, Semi-Furnished, Unfurnished, Any
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_requests', function (Blueprint $table) {
            $table->dropColumn(['tenant_type', 'furnishing_preference']);
        });
    }
};

