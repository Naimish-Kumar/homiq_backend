<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'phone', 'dob', 'gender', 'profile_photo', 'is_admin', 'is_host', 'subscription_plan', 'fcm_token', 'last_seen_at', 'is_verified', 'kyc_document', 'kyc_status', 'referral_code', 'referred_by_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = self::generateUniqueReferralCode();
            }
        });
    }

    private static function generateUniqueReferralCode(): string
    {
        do {
            $code = 'HQ-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    protected $appends = ['referrals_count', 'properties_count'];

    public function getPropertiesCountAttribute(): int
    {
        return $this->properties()->count();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_verified' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    public function getReferralsCountAttribute(): int
    {
        return self::where('referred_by_id', $this->id)->count();
    }

    public function getProfilePhotoAttribute($value)
    {
        if ($value && str_starts_with($value, '/uploads')) {
            return asset($value);
        }
        return $value;
    }

    public function getKycDocumentAttribute($value)
    {
        if ($value && (str_starts_with($value, '/uploads') || str_starts_with($value, '/storage'))) {
            return asset($value);
        }
        return $value;
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'renter_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function wishlistProperties()
    {
        return $this->belongsToMany(Property::class, 'wishlists');
    }
}
