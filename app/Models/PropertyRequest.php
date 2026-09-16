<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

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

    public function getFormattedBudgetAttribute(): string
    {
        if ($this->min_budget && $this->min_budget > 0) {
            return '₹' . number_format($this->min_budget) . ' - ₹' . number_format($this->max_budget);
        }
        return 'Up to ₹' . number_format($this->max_budget);
    }
}

