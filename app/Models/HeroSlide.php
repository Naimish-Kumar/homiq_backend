<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'badge_icon',
        'title',
        'subtitle',
        'highlights',
        'primary_cta_text',
        'primary_cta_link',
        'secondary_cta_text',
        'secondary_cta_link',
        'secondary_cta_action',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get accessible public URL for the slide image.
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/hero/hero_jewar_airport_plots.jpg');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'images/') || str_starts_with($this->image, 'uploads/')) {
            return asset($this->image);
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }
}
