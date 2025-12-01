<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'payment_status',
        'enrolled_at',
        'completed_at',
        'progress_percentage',
        'last_watched_at',
        'current_time',
        'expires_at',
        'is_expired',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_watched_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_expired' => 'boolean',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Alias for student relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeNotExpired($query)
    {
        return $query->where('is_expired', false)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeExpired($query)
    {
        return $query->where('is_expired', true)
                    ->orWhere('expires_at', '<=', now());
    }

    // Helper methods
    public function isExpired()
    {
        if ($this->is_expired) {
            return true;
        }
        
        if ($this->expires_at && $this->expires_at->isPast()) {
            // Auto-mark as expired
            $this->update(['is_expired' => true]);
            return true;
        }
        
        return false;
    }

    public function hasAccess()
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    public function getDaysRemaining()
    {
        if (!$this->expires_at || $this->course->is_lifetime) {
            return null; // Lifetime access
        }
        
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->expires_at, false);
    }

    public function getTimeRemainingAttribute()
    {
        $days = $this->getDaysRemaining();
        
        if ($days === null) {
            return 'Lifetime';
        }
        
        if ($days <= 0) {
            return 'Expired';
        }
        
        if ($days >= 365) {
            $years = floor($days / 365);
            $remaining_days = $days % 365;
            if ($remaining_days > 0) {
                return $years . ' year' . ($years > 1 ? 's' : '') . ' and ' . $remaining_days . ' day' . ($remaining_days > 1 ? 's' : '') . ' remaining';
            } else {
                return $years . ' year' . ($years > 1 ? 's' : '') . ' remaining';
            }
        } elseif ($days >= 30) {
            $months = floor($days / 30);
            $remaining_days = $days % 30;
            if ($remaining_days > 0) {
                return $months . ' month' . ($months > 1 ? 's' : '') . ' and ' . $remaining_days . ' day' . ($remaining_days > 1 ? 's' : '') . ' remaining';
            } else {
                return $months . ' month' . ($months > 1 ? 's' : '') . ' remaining';
            }
        } else {
            return $days . ' day' . ($days > 1 ? 's' : '') . ' remaining';
        }
    }
}
