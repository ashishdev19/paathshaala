<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'code',
        'type',
        'value',
        'minimum_amount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'applicable_courses',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'applicable_courses' => 'array',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('valid_from', '<=', Carbon::now())
                    ->where('valid_until', '>=', Carbon::now());
    }

    public function scopeAvailable($query)
    {
        return $query->whereRaw('(usage_limit IS NULL OR used_count < usage_limit)');
    }

    // Methods
    public function isValidForCourse($courseId)
    {
        if (empty($this->applicable_courses)) {
            return true; // Applies to all courses
        }
        return in_array($courseId, $this->applicable_courses);
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return ($amount * $this->value) / 100;
        }
        return $this->value;
    }

    public function canBeUsed($amount = null)
    {
        if (!$this->is_active) return false;
        if (Carbon::now()->lt($this->valid_from) || Carbon::now()->gt($this->valid_until)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($amount && $this->minimum_amount && $amount < $this->minimum_amount) return false;
        
        return true;
    }
}
