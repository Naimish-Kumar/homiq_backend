<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'property_id',
    'user_id',
    'reporter_name',
    'reporter_contact',
    'reason',
    'details',
    'ip_address',
    'status'
])]
class PropertyReport extends Model
{
    /**
     * Standard human-readable reason labels.
     */
    public const REASONS = [
        'fake_property' => 'Fake property / Scam listing',
        'incorrect_price' => 'Incorrect or misleading price',
        'wrong_location' => 'Wrong location or inaccurate address',
        'duplicate_listing' => 'Duplicate / Reposted listing',
        'misleading_photos' => 'Misleading or stolen photos',
        'owner_not_responding' => 'Owner or agent not responding',
        'already_rented_sold' => 'Property already rented or sold',
        'suspicious_activity' => 'Suspicious activity or harassment',
    ];

    /**
     * Get the property that was reported.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user who submitted the report (if authenticated).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor for human-readable reason label.
     */
    public function getReasonLabelAttribute(): string
    {
        return self::REASONS[$this->reason] ?? ucfirst(str_replace('_', ' ', $this->reason));
    }
}

