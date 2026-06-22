<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['title', 'owner_id'])]
class SharedWishlist extends Model
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_wishlist_users', 'shared_wishlist_id', 'user_id')
            ->withTimestamps();
    }

    public function properties(): HasMany
    {
        return $this->hasMany(SharedWishlistProperty::class, 'shared_wishlist_id');
    }
}
