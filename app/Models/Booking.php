<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'property_id',
    'renter_id',
    'check_in',
    'check_out',
    'base_rent',
    'taxes',
    'platform_fee',
    'total_price',
    'status'
])]
class Booking extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'base_rent' => 'decimal:2',
            'taxes' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Get the property that is booked.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Get the renter (guest) who made the booking.
     */
    public function renter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'renter_id');
    }
}
