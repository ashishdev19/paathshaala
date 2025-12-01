<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'features',
        'max_students',
        'max_courses',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function enquiries()
    {
        return $this->hasMany(TeacherEnquiry::class, 'plan_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(TeacherSubscription::class, 'plan_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('priority', 'asc');
    }

    // Methods
    public function getFeaturesListAttribute()
    {
        return is_array($this->features) ? $this->features : json_decode($this->features ?? '[]', true);
    }
}
