<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * WalletTransaction Model
 * 
 * Transaction ledger for all wallet activities.
 * Types: credit, debit, hold, release, payout, refund, commission
 */
class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'meta',
        'created_by',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'meta' => 'array',
    ];

    /**
     * Transaction types
     */
    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';
    const TYPE_HOLD = 'hold';
    const TYPE_RELEASE = 'release';
    const TYPE_PAYOUT = 'payout';
    const TYPE_REFUND = 'refund';
    const TYPE_COMMISSION = 'commission';

    /**
     * Get the wallet that owns the transaction
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the user who created this transaction
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get related payment if exists
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'wallet_transaction_id');
    }

    /**
     * Scope for credit transactions
     */
    public function scopeCredits($query)
    {
        return $query->whereIn('type', [self::TYPE_CREDIT, self::TYPE_REFUND, self::TYPE_RELEASE]);
    }

    /**
     * Scope for debit transactions
     */
    public function scopeDebits($query)
    {
        return $query->whereIn('type', [self::TYPE_DEBIT, self::TYPE_PAYOUT, self::TYPE_HOLD, self::TYPE_COMMISSION]);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get formatted description
     */
    public function getFormattedDescriptionAttribute()
    {
        if ($this->description) {
            return $this->description;
        }

        return match($this->type) {
            self::TYPE_CREDIT => 'Wallet credited',
            self::TYPE_DEBIT => 'Wallet debited',
            self::TYPE_HOLD => 'Amount held',
            self::TYPE_RELEASE => 'Amount released',
            self::TYPE_PAYOUT => 'Withdrawal payout',
            self::TYPE_REFUND => 'Refund credited',
            self::TYPE_COMMISSION => 'Platform commission',
            default => 'Transaction',
        };
    }
}
