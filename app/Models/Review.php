<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'booking_id',
    'cleanliness',
    'location',
    'value',
    'owner_behavior',
    'comment'
])]
class Review extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cleanliness' => 'integer',
            'location' => 'integer',
            'value' => 'integer',
            'owner_behavior' => 'integer',
        ];
    }

    /**
     * Get the booking associated with the review.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
