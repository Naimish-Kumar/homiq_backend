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
            $table->timestamp('verified_at')->nullable()->after('status');
            $table->timestamp('expires_at')->nullable()->index()->after('verified_at');
            $table->timestamp('last_renewed_at')->nullable()->after('expires_at');
            $table->boolean('is_identity_verified')->default(true)->after('last_renewed_at');
            $table->boolean('is_location_verified')->default(true)->after('is_identity_verified');
            $table->boolean('is_photos_verified')->default(true)->after('is_location_verified');
            $table->boolean('is_ownership_verified')->default(true)->after('is_photos_verified');
            $table->string('verifier_notes')->nullable()->after('is_ownership_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'verified_at',
                'expires_at',
                'last_renewed_at',
                'is_identity_verified',
                'is_location_verified',
                'is_photos_verified',
                'is_ownership_verified',
                'verifier_notes',
            ]);
        });
    }
};

