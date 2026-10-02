<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'payout_method',
        'upi_id',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'bank_name',
        'status',
        'transaction_reference',
        'admin_notes',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(ReferralTransaction::class, 'withdrawal_request_id');
    }
}
