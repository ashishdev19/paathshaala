<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Wallet Model
 * 
 * Manages user wallet balances for students and teachers.
 * Students can top-up and pay for courses.
 * Teachers receive earnings from course sales and can withdraw.
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'reserved_amount',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'reserved_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the wallet
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all transactions for this wallet
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get available balance (balance - reserved_amount)
     * 
     * @return float
     */
    public function getAvailableBalanceAttribute()
    {
        return $this->balance - $this->reserved_amount;
    }

    /**
     * Check if wallet has sufficient available balance
     * 
     * @param float $amount
     * @return bool
     */
    public function hasSufficientBalance($amount)
    {
        return $this->available_balance >= $amount;
    }

    /**
     * Get recent transactions
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recentTransactions($limit = 10)
    {
        return $this->transactions()->limit($limit)->get();
    }

    /**
     * Get transactions by type
     * 
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function transactionsByType($type)
    {
        return $this->transactions()->where('type', $type);
    }
}
