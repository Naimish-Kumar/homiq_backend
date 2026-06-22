<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['shared_wishlist_property_id', 'user_id', 'vote_type'])]
class SharedWishlistVote extends Model
{
    public function sharedWishlistProperty(): BelongsTo
    {
        return $this->belongsTo(SharedWishlistProperty::class, 'shared_wishlist_property_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
