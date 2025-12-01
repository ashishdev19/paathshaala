<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class TeacherSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'teacher_enquiry_id',
        'started_at',
        'expires_at',
        'status',
        'paid_amount',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'paid_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function enquiry()
    {
        return $this->belongsTo(TeacherEnquiry::class, 'teacher_enquiry_id');
    }

    public function history()
    {
        return $this->user->subscriptionHistory()
                   ->where('to_plan_id', $this->plan_id)
                   ->orderBy('action_date', 'desc');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now())
                    ->orWhere('status', 'expired');
    }

    public function scopeCurrent($query)
    {
        return $query->where('user_id', auth()->id())
                    ->where('status', 'active')
                    ->where('expires_at', '>', now());
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    public function isExpired()
    {
        return $this->expires_at <= now() || $this->status === 'expired';
    }

    public function daysRemaining()
    {
        if ($this->isExpired()) {
            return 0;
        }
        return now()->diffInDays($this->expires_at, false);
    }

    public function canUpgradeTo(SubscriptionPlan $newPlan)
    {
        if (!$this->isActive()) {
            return false;
        }
        return $newPlan->price > $this->plan->price;
    }

    public function getUpgradeCost(SubscriptionPlan $newPlan)
    {
        if (!$this->canUpgradeTo($newPlan)) {
            return 0;
        }

        // Calculate pro-rated upgrade cost
        $daysRemaining = $this->daysRemaining();
        $daysInYear = 365;
        $totalCostDifference = $newPlan->price - $this->plan->price;
        
        // Pro-rated cost for remaining days
        return ($totalCostDifference / $daysInYear) * $daysRemaining;
    }

    public function upgradeTo(SubscriptionPlan $newPlan, $paidAmount = null)
    {
        $oldPlan = $this->plan;
        $upgradeCost = $this->getUpgradeCost($newPlan);
        $amount = $paidAmount ?? $upgradeCost;

        // Update current subscription
        $this->plan_id = $newPlan->id;
        $this->paid_amount = $amount;
        $this->save();

        // Log history
        TeacherSubscriptionHistory::create([
            'user_id' => $this->user_id,
            'from_plan_id' => $oldPlan->id,
            'to_plan_id' => $newPlan->id,
            'action' => 'upgraded',
            'amount_paid' => $amount,
            'created_by' => auth()->id() ?? null,
        ]);

        return $this;
    }

    public function renew($paidAmount = null)
    {
        $amount = $paidAmount ?? $this->plan->price;
        
        $this->started_at = now();
        $this->expires_at = now()->addYear();
        $this->status = 'active';
        $this->cancelled_at = null;
        $this->cancellation_reason = null;
        $this->paid_amount = $amount;
        $this->save();

        // Log history
        TeacherSubscriptionHistory::create([
            'user_id' => $this->user_id,
            'from_plan_id' => null,
            'to_plan_id' => $this->plan_id,
            'action' => 'renewed',
            'amount_paid' => $amount,
            'created_by' => auth()->id() ?? null,
        ]);

        return $this;
    }

    public function cancel($reason = null)
    {
        $this->status = 'cancelled';
        $this->cancelled_at = now();
        $this->cancellation_reason = $reason;
        $this->save();

        return $this;
    }
}
