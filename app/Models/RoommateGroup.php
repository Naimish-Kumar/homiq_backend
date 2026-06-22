<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'property_id',
    'creator_id',
    'status',
    'max_roommates'
])]
class RoommateGroup extends Model
{
    /**
     * Get the property this group is formed for.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Get the creator of the group.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get all members in the roommate group.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'roommate_group_members', 'roommate_group_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get the bookings associated with this group.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'roommate_group_id');
    }
}
