<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationBroadcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'target_audience',
        'target_user_id',
        'type',
        'action_url',
        'recipients_count',
        'fcm_sent_count',
        'sent_by_user_id',
        'status',
    ];

    /**
     * The admin user who initiated this broadcast.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by_user_id');
    }

    /**
     * Target user if audience was 'individual'.
     */
    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    /**
     * Get human-friendly label for target audience.
     */
    public function getAudienceLabelAttribute(): string
    {
        return match ($this->target_audience) {
            'all' => 'All Users',
            'hosts' => 'Hosts & Landlords',
            'tenants' => 'Tenants & Seekers',
            'pro' => 'Pro Subscribers',
            'business' => 'Business Subscribers',
            'individual' => $this->targetUser ? 'User: ' . $this->targetUser->name : 'Single User',
            default => ucfirst($this->target_audience),
        };
    }
}
