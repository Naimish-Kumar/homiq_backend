<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;

#[Fillable([
    'user_id',
    'seeker_name',
    'seeker_phone',
    'seeker_email',
    'city',
    'locality',
    'property_type',
    'bedrooms',
    'min_budget',
    'max_budget',
    'purpose',
    'move_in_date',
    'tenant_type',
    'furnishing_preference',
    'description',
    'status',
    'responses_count',
])]
class PropertyRequest extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'min_budget' => 'decimal:2',
            'max_budget' => 'decimal:2',
            'responses_count' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active requests.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to find active requests matching a given property.
     */
    public function scopeMatchingProperty(Builder $query, Property $property): Builder
    {
        $city = $property->city ?? '';
        $address = $property->address ?? '';
        $propPrice = (float) $property->price;
        $propBedrooms = (int) $property->bedrooms;
        $propCategory = strtolower($property->category ?? '');
        $listingType = $property->listing_type ?? 'rent';

        return $query->where('status', 'active')
            ->where('purpose', $listingType)
            ->where(function ($q) use ($city, $address) {
                if (!empty($city)) {
                    $q->where('city', 'like', "%{$city}%");
                }
                if (!empty($address)) {
                    $q->orWhere('city', 'like', "%{$address}%")
                      ->orWhere('locality', 'like', "%{$address}%");
                }
            })
            ->where('max_budget', '>=', $propPrice * 0.85); // Reasonable budget bracket
    }

    /**
     * Check if this request matches a given property.
     */
    public function matchesProperty(Property $property): bool
    {
        // 1. Purpose match
        if (strtolower($this->purpose ?? 'rent') !== strtolower($property->listing_type ?? 'rent')) {
            return false;
        }

        // 2. Budget match (property price must be within seeker's ceiling or +10% flexibility)
        if ($property->price > ($this->max_budget * 1.10)) {
            return false;
        }

        // 3. Location match (city or locality contained in property address)
        $propAddress = strtolower($property->address ?? '');
        $reqCity = strtolower($this->city ?? '');
        $reqLocality = strtolower($this->locality ?? '');

        $cityMatch = !empty($reqCity) && str_contains($propAddress, $reqCity);
        $localityMatch = !empty($reqLocality) && str_contains($propAddress, $reqLocality);

        if (!$cityMatch && !$localityMatch) {
            return false;
        }

        // 4. Bedroom match (if specified and not 'Any')
        if ($this->bedrooms && !in_array(strtolower($this->bedrooms), ['any', 'all', ''])) {
            if (preg_match('/(\d+)/', $this->bedrooms, $matches)) {
                $reqBhk = (int) $matches[1];
                if ($property->bedrooms && $property->bedrooms != $reqBhk) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getFormattedBudgetAttribute(): string
    {
        if ($this->min_budget && $this->min_budget > 0) {
            return '₹' . number_format($this->min_budget) . ' - ₹' . number_format($this->max_budget);
        }
        if ($this->max_budget) {
            return 'Up to ₹' . number_format($this->max_budget);
        }
        return 'Budget on Request';
    }

    public function getBudgetFormattedAttribute(): string
    {
        if ($this->max_budget && $this->max_budget >= 100000) {
            return '₹' . number_format($this->max_budget / 100000, 2) . ' L';
        }
        if ($this->max_budget) {
            return '₹' . number_format($this->max_budget, 0) . ($this->purpose === 'buy' ? '' : '/mo');
        }
        return 'Budget on Request';
    }

    public function getNameAttribute(): ?string
    {
        return $this->seeker_name;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->seeker_phone;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->seeker_email;
    }

    public function getNotesAttribute(): ?string
    {
        return $this->description;
    }

    public function getBhkAttribute(): ?string
    {
        return $this->bedrooms ?? $this->property_type;
    }

    public function getLocationAttribute(): string
    {
        if ($this->locality && $this->city) {
            return $this->locality . ', ' . $this->city;
        }
        return $this->locality ?: ($this->city ?: 'All Locations');
    }

    public function getMoveInTimelineAttribute(): string
    {
        return $this->move_in_date ?: 'Immediate';
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at ? $this->created_at->diffForHumans() : 'Just now';
    }

    public function getTenantBadgeAttribute(): string
    {
        return match($this->tenant_type) {
            'working_professional' => 'Working Pro',
            'family' => 'Family',
            'student' => 'Student',
            'corporate' => 'Corporate',
            default => 'Verified Seeker',
        };
    }
}
