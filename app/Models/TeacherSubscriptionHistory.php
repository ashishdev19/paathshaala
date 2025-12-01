<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherSubscriptionHistory extends Model
{
    use HasFactory;

    protected $table = 'teacher_subscription_history';

    protected $fillable = [
        'user_id',
        'from_plan_id',
        'to_plan_id',
        'action',
        'amount_paid',
        'notes',
        'action_date',
        'created_by',
    ];

    protected $casts = [
        'action_date' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'from_plan_id');
    }

    public function toPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'to_plan_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
