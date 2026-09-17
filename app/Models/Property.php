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
    'original_price',
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
    'carpet_area',
    'listed_by',
    'distance_from_metro',
    'verified_at',
    'expires_at',
    'last_renewed_at',
    'is_identity_verified',
    'is_location_verified',
    'is_photos_verified',
    'is_ownership_verified',
    'verifier_notes',
    'views_count',
    'impressions_count',
    'inquiries_count',
    'whatsapp_clicks',
    'saves_count'
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
            'original_price' => 'decimal:2',
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
            'verified_at' => 'datetime',
            'expires_at' => 'datetime',
            'last_renewed_at' => 'datetime',
            'is_identity_verified' => 'boolean',
            'is_location_verified' => 'boolean',
            'is_photos_verified' => 'boolean',
            'is_ownership_verified' => 'boolean',
            'views_count' => 'integer',
            'impressions_count' => 'integer',
            'inquiries_count' => 'integer',
            'whatsapp_clicks' => 'integer',
            'saves_count' => 'integer',
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
     * Get the safety & trust reports for the property.
     */
    public function reports()
    {
        return $this->hasMany(PropertyReport::class, 'property_id');
    }

    /**
     * Accessor for clean human-readable address.
     * Automatically handles both plain text and JSON-encoded addresses.
     */
    public function getAddressAttribute($value): string
    {
        if (empty($value)) {
            return '';
        }

        if (is_string($value) && (str_starts_with(trim($value), '{') || str_starts_with(trim($value), '['))) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $parts = [];
                if (!empty($decoded['street'])) $parts[] = trim($decoded['street']);
                if (!empty($decoded['city'])) $parts[] = trim($decoded['city']);
                if (!empty($decoded['state'])) $parts[] = trim($decoded['state']);
                if (!empty($decoded['pincode'])) $parts[] = trim($decoded['pincode']);
                if (!empty($decoded['country'])) $parts[] = trim($decoded['country']);
                
                if (!empty($parts)) {
                    return implode(', ', $parts);
                }
            }
        }

        return (string) $value;
    }

    /**
     * Accessor for formatted address.
     */
    public function getFormattedAddressAttribute(): string
    {
        return $this->address;
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
            if ($this->price >= 10000000) {
                return $this->currency_symbol . number_format($this->price / 10000000, 2) . ' Cr';
            } elseif ($this->price >= 100000) {
                return $this->currency_symbol . number_format($this->price / 100000, 2) . ' Lakh';
            }
            return $this->currency_symbol . number_format($this->price, 0);
        }
        return $this->currency_symbol . number_format($this->price, 0) . $this->billing_frequency_suffix;
    }

    /**
     * Check if listing has a price drop / reduction.
     */
    public function getHasPriceDropAttribute(): bool
    {
        return !empty($this->original_price) && ((float) $this->original_price > (float) $this->price);
    }

    /**
     * Price drop amount.
     */
    public function getPriceDropAmountAttribute(): float
    {
        if (!$this->has_price_drop) {
            return 0.0;
        }
        return max(0.0, (float) $this->original_price - (float) $this->price);
    }

    /**
     * Formatted original price before drop.
     */
    public function getFormattedOriginalPriceAttribute(): string
    {
        if (!$this->original_price) {
            return '';
        }
        if ($this->listing_type === 'sale') {
            if ($this->original_price >= 10000000) {
                return $this->currency_symbol . number_format($this->original_price / 10000000, 2) . ' Cr';
            } elseif ($this->original_price >= 100000) {
                return $this->currency_symbol . number_format($this->original_price / 100000, 2) . ' Lakh';
            }
            return $this->currency_symbol . number_format($this->original_price, 0);
        }
        return $this->currency_symbol . number_format($this->original_price, 0) . $this->billing_frequency_suffix;
    }

    /**
     * Formatted price drop badge string (e.g., "Price reduced by ₹2,000").
     */
    public function getFormattedPriceDropBadgeAttribute(): ?string
    {
        if (!$this->has_price_drop) {
            return null;
        }
        return 'Price reduced by ' . $this->currency_symbol . number_format($this->price_drop_amount, 0);
    }

    /**
     * Percentage of price drop.
     */
    public function getPriceDropPercentAttribute(): int
    {
        if (!$this->has_price_drop || (float) $this->original_price <= 0) {
            return 0;
        }
        return (int) round((((float) $this->original_price - (float) $this->price) / (float) $this->original_price) * 100);
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

    /**
     * Freshness badge (e.g., "Updated 2h ago", "Posted today", "Posted 3 days ago").
     */
    public function getFreshnessBadgeAttribute(): string
    {
        $timestamp = $this->updated_at ?? $this->created_at ?? now();
        $diffMinutes = (int) $timestamp->diffInMinutes(now());
        
        if ($diffMinutes < 60) {
            return 'Updated ' . max(1, $diffMinutes) . 'm ago';
        }
        $diffHours = (int) $timestamp->diffInHours(now());
        if ($diffHours < 24) {
            return 'Updated ' . $diffHours . 'h ago';
        }
        $diffDays = (int) $timestamp->diffInDays(now());
        if ($diffDays === 1) {
            return 'Posted yesterday';
        }
        if ($diffDays < 7) {
            return 'Posted ' . $diffDays . 'd ago';
        }
        return 'Updated ' . $timestamp->format('d M');
    }

    /**
     * Availability badge (e.g., "Available Immediately" or "Available from 1 Oct").
     */
    public function getAvailabilityBadgeAttribute(): string
    {
        if (empty($this->available_from) || $this->available_from <= now()) {
            return 'Available Immediately';
        }
        return 'Available from ' . $this->available_from->format('d M');
    }

    /**
     * Formatted security deposit string.
     */
    public function getFormattedDepositAttribute(): ?string
    {
        if ($this->listing_type === 'sale') {
            return null;
        }
        if (!empty($this->security_deposit) && $this->security_deposit > 0) {
            return $this->currency_symbol . number_format($this->security_deposit, 0) . ' Deposit';
        }
        return 'No Deposit Required';
    }

    /**
     * Formatted Listed by tag label (Owner vs Agent).
     */
    public function getListedByLabelAttribute(): string
    {
        return ($this->listed_by === 'agent') ? 'Verified Agent' : 'Property Owner';
    }

    /**
     * Generate pre-filled WhatsApp click-to-chat inquiry URL.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $ownerPhone = $this->owner?->phone ?? '9876543210';
        $cleanPhone = preg_replace('/[^0-9]/', '', $ownerPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }
        
        $priceStr = $this->formatted_price;
        $titleStr = $this->title;
        $urlStr = url('/properties/' . $this->id);
        
        $msg = "Hello! I saw your property \"{$titleStr}\" ({$priceStr}) on HomiQ: {$urlStr}\nIs it still available for visit/rent?";
        return 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($msg);
    }

    /**
     * Check if property is expired / unconfirmed past its 30-day window.
     */
    public function getIsExpiredAttribute(): bool
    {
        return !empty($this->expires_at) && $this->expires_at->isPast();
    }

    /**
     * Number of remaining days until expiry.
     */
    public function getDaysUntilExpiryAttribute(): int
    {
        if (empty($this->expires_at)) {
            return 30;
        }
        if ($this->expires_at->isPast()) {
            return 0;
        }
        return (int) now()->diffInDays($this->expires_at);
    }

    /**
     * Formatted last physical verification date.
     */
    public function getFormattedVerifiedDateAttribute(): string
    {
        $date = $this->verified_at ?? $this->created_at ?? now();
        return $date->format('d M Y');
    }

    /**
     * Verification checklist summary array for UI render.
     */
    public function getVerificationChecklistAttribute(): array
    {
        return [
            [
                'key' => 'identity',
                'title' => 'Owner Identity Verified',
                'description' => 'Government ID / Aadhaar & contact number validated',
                'verified' => (bool) ($this->is_identity_verified ?? true),
                'icon' => 'badge',
            ],
            [
                'key' => 'location',
                'title' => 'Property Location Verified',
                'description' => 'Geotagged GPS coordinates and physical street cross-checked',
                'verified' => (bool) ($this->is_location_verified ?? true),
                'icon' => 'pin_drop',
            ],
            [
                'key' => 'photos',
                'title' => 'Property Photos Verified',
                'description' => '100% authentic on-site visual audit matching actual condition',
                'verified' => (bool) ($this->is_photos_verified ?? true),
                'icon' => 'photo_camera',
            ],
            [
                'key' => 'ownership',
                'title' => 'Ownership / Authorization Checked',
                'description' => 'Registry title deed, electricity bill, or host agreement reviewed',
                'verified' => (bool) ($this->is_ownership_verified ?? true),
                'icon' => 'policy',
            ],
        ];
    }

    /**
     * 1-Click Availability Re-Verification by Owner (extends expiry by 30 days).
     */
    public function renewListing(int $days = 30): bool
    {
        return $this->update([
            'status' => 'approved',
            'last_renewed_at' => now(),
            'expires_at' => now()->addDays($days),
        ]);
    }

    // Scopes
    public function scopeRecentlyAdded($query)
    {
        return $query->latest();
    }

    public function scopeApprovedAndActive($query)
    {
        return $query->where('status', 'approved')
                     ->where(function ($q) {
                         $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                     });
    }

    public function scopeAvailableImmediately($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('available_from')->orWhere('available_from', '<=', now());
        });
    }

    public function scopeNearMetro($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('distance_from_metro')
              ->orWhere('amenities', 'like', '%metro%')
              ->orWhere('description', 'like', '%metro%')
              ->orWhere('address', 'like', '%metro%');
        });
    }

    public function scopeByListedBy($query, string $type)
    {
        return $query->where('listed_by', $type);
    }

    /**
     * SEO slug for property.
     */
    public function getSlugAttribute(): string
    {
        $base = \Illuminate\Support\Str::slug($this->title);
        if (empty($base)) {
            $base = 'property';
        }
        return $base . '-' . $this->id;
    }

    /**
     * Canonical SEO URL for property.
     */
    public function getSeoUrlAttribute(): string
    {
        return url('/property/' . $this->slug);
    }
}

