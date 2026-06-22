<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shared_wishlists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('shared_wishlist_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shared_wishlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['shared_wishlist_id', 'user_id']);
        });

        Schema::create('shared_wishlist_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shared_wishlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['shared_wishlist_id', 'property_id']);
        });

        Schema::create('shared_wishlist_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shared_wishlist_property_id')->constrained('shared_wishlist_properties')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('vote_type'); // 1 for upvote, -1 for downvote
            $table->timestamps();

            $table->unique(['shared_wishlist_property_id', 'user_id'], 'sw_prop_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shared_wishlist_votes');
        Schema::dropIfExists('shared_wishlist_properties');
        Schema::dropIfExists('shared_wishlist_users');
        Schema::dropIfExists('shared_wishlists');
    }
};
