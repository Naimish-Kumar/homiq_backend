<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['shared_wishlist_id', 'property_id', 'notes'])]
class SharedWishlistProperty extends Model
{
    public function sharedWishlist(): BelongsTo
    {
        return $this->belongsTo(SharedWishlist::class, 'shared_wishlist_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(SharedWishlistVote::class, 'shared_wishlist_property_id');
    }
}
