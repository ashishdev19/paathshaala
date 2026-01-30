<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code',
        'referrer_credit',
        'referred_discount',
        'credit_applied',
        'discount_applied',
        'credit_applied_at',
        'discount_applied_at',
        'enrollment_id',
    ];

    protected $casts = [
        'referrer_credit' => 'decimal:2',
        'referred_discount' => 'decimal:2',
        'credit_applied' => 'boolean',
        'discount_applied' => 'boolean',
        'credit_applied_at' => 'datetime',
        'discount_applied_at' => 'datetime',
    ];

    /**
     * Get the referrer (User A who shared the code).
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the referred user (User B who joined).
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Get the enrollment if discount was applied to a course.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Scope for pending credits (User A hasn't received credit yet).
     */
    public function scopePendingCredit($query)
    {
        return $query->where('credit_applied', false);
    }

    /**
     * Scope for pending discounts (User B hasn't used discount yet).
     */
    public function scopePendingDiscount($query)
    {
        return $query->where('discount_applied', false);
    }

    /**
     * Scope for completed referrals (both credit and discount applied).
     */
    public function scopeCompleted($query)
    {
        return $query->where('credit_applied', true)
                    ->where('discount_applied', true);
    }

    /**
     * Mark credit as applied to referrer.
     */
    public function markCreditApplied(): void
    {
        $this->update([
            'credit_applied' => true,
            'credit_applied_at' => now(),
        ]);
    }

    /**
     * Mark discount as applied by referred user.
     */
    public function markDiscountApplied(?int $enrollmentId = null): void
    {
        $this->update([
            'discount_applied' => true,
            'discount_applied_at' => now(),
            'enrollment_id' => $enrollmentId,
        ]);
    }
}
