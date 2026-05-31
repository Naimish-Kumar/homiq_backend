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
    'status'
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
            'latitude' => 'double',
            'longitude' => 'double',
            'amenities' => 'array',
            'images' => 'array',
            'is_furnished' => 'boolean',
            'has_parking' => 'boolean',
            'is_pet_friendly' => 'boolean',
        ];
    }

    /**
     * Get the owner of the property.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
