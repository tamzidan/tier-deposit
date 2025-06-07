<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'amount',
        'tier',
        'cashback_percentage',
        'cashback_amount',
        'total_received',
        'status',
        'payment_method',
        'duitku_reference',
        'expired_at',
        'paid_at',
        'payment_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'cashback_percentage' => 'decimal:2',
        'cashback_amount' => 'decimal:2',
        'total_received' => 'decimal:2',
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getTierInfo($amount)
    {
        if ($amount >= 15000000) {
            return [
                'tier' => 'TIER-3',
                'cashback_percentage' => 20,
                'minimum' => 15000000
            ];
        } elseif ($amount >= 10000000) {
            return [
                'tier' => 'TIER-2',
                'cashback_percentage' => 12,
                'minimum' => 10000000
            ];
        } elseif ($amount >= 5000000) {
            return [
                'tier' => 'TIER-1',
                'cashback_percentage' => 5,
                'minimum' => 5000000
            ];
        }
        
        return null;
    }

    public function calculateCashback()
    {
        $this->cashback_amount = ($this->amount * $this->cashback_percentage) / 100;
        $this->total_received = $this->amount + $this->cashback_amount;
        return $this;
    }
}
