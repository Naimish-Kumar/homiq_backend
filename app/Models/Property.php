<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'owner_id',
    'title',
    'description',
    'price',
    'address',
    'latitude',
    'longitude',
    'amenities',
    'images',
    'category',
    'bedrooms',
    'bathrooms',
    'is_furnished',
    'has_parking',
    'is_pet_friendly',
    'currency',
    'billing_frequency',
    'country',
    'status',
    'is_featured',
    'listing_type',
    'property_age',
    'ownership_type',
    'built_up_area',
    'is_negotiable',
    'is_rera_approved',
    'price_unit',
    'plot_area',
    'boundary_wall',
    'preferred_tenant',
    'supports_group_renting',
    'group_max_size',
    'security_deposit',
    'lease_duration',
    'available_from',
    'floor_number',
    'total_floors',
    'facing_direction',
    'carpet_area'
])]
class Property extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'latitude' => 'double',
            'longitude' => 'double',
            'amenities' => 'array',
            'images' => 'array',
            'is_furnished' => 'boolean',
            'has_parking' => 'boolean',
            'is_pet_friendly' => 'boolean',
            'is_featured' => 'boolean',
            'is_negotiable' => 'boolean',
            'is_rera_approved' => 'boolean',
            'boundary_wall' => 'boolean',
            'plot_area' => 'double',
            'supports_group_renting' => 'boolean',
            'group_max_size' => 'integer',
            'available_from' => 'date',
            'floor_number' => 'integer',
            'total_floors' => 'integer',
            'carpet_area' => 'integer',
        ];
    }

    /**
     * Get the owner of the property.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the roommate groups for the property.
     */
    public function roommateGroups()
    {
        return $this->hasMany(RoommateGroup::class, 'property_id');
    }

    /**
     * Get the bookings for the property.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'property_id');
    }

    /**
     * Accessor for currency symbol.
     */
    public function getCurrencySymbolAttribute(): string
    {
        return match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => '₹',
        };
    }

    /**
     * Accessor for billing frequency suffix.
     */
    public function getBillingFrequencySuffixAttribute(): string
    {
        return match ($this->billing_frequency) {
            'per_day' => '/day',
            'hourly' => '/hr',
            default => '/mo',
        };
    }

    /**
     * Accessor for fully formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->listing_type === 'sale') {
            return $this->currency_symbol . number_format($this->price, 0);
        }
        return $this->currency_symbol . number_format($this->price, 0) . $this->billing_frequency_suffix;
    }

    /**
     * Accessor for human-readable billing frequency label.
     */
    public function getBillingFrequencyLabelAttribute(): string
    {
        return match ($this->billing_frequency) {
            'per_day' => 'Per Day',
            'hourly' => 'Per Hour',
            default => 'Per Month',
        };
    }
}

