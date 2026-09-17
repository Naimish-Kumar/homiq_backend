<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'funnel_type',
        'funnel_step',
        'user_id',
        'session_id',
        'property_id',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeNamed($query, string $name)
    {
        return $query->where('event_name', $name);
    }

    public function scopeForFunnel($query, string $funnelType)
    {
        return $query->where('funnel_type', $funnelType);
    }

    public function scopeStep($query, string $step)
    {
        return $query->where('funnel_step', $step);
    }
}

