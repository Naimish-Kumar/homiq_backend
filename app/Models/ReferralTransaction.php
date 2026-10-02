<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'source_user_id',
        'property_id',
        'withdrawal_request_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function withdrawalRequest()
    {
        return $this->belongsTo(WithdrawalRequest::class);
    }
}
