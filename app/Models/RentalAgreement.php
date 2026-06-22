<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalAgreement extends Model
{
    protected $fillable = [
        'property_id',
        'owner_id',
        'tenant_id',
        'rent_amount',
        'deposit_amount',
        'start_date',
        'end_date',
        'owner_signature',
        'tenant_signature',
        'status',
    ];

    protected $casts = [
        'rent_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function getOwnerSignatureAttribute($value)
    {
        if ($value && str_starts_with($value, '/storage')) {
            return asset($value);
        }
        return $value;
    }

    public function getTenantSignatureAttribute($value)
    {
        if ($value && str_starts_with($value, '/storage')) {
            return asset($value);
        }
        return $value;
    }
}
