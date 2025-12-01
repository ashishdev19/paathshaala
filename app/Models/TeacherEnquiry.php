<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone_number',
        'qualification',
        'experience',
        'bio',
        'subject_expertise',
        'plan_id',
        'status',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function subscription()
    {
        return $this->hasOne(TeacherSubscription::class, 'teacher_enquiry_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Methods
    public function approve($reviewedBy = null)
    {
        $this->status = 'approved';
        $this->reviewed_by = $reviewedBy ?? auth()->id();
        $this->reviewed_at = now();
        return $this->save();
    }

    public function reject($reason, $reviewedBy = null)
    {
        $this->status = 'rejected';
        $this->rejection_reason = $reason;
        $this->reviewed_by = $reviewedBy ?? auth()->id();
        $this->reviewed_at = now();
        return $this->save();
    }
}
