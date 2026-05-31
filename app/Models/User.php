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

#[Fillable(['name', 'email', 'password', 'phone', 'dob', 'gender', 'profile_photo', 'is_admin', 'subscription_plan', 'fcm_token'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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
        ];
    }

    public function getProfilePhotoAttribute($value)
    {
        if ($value && str_starts_with($value, '/uploads')) {
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
