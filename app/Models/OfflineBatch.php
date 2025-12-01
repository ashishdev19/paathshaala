<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfflineBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'batch_name',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'enrolled_count',
        'schedule',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'schedule' => 'array',
        'capacity' => 'integer',
        'enrolled_count' => 'integer',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())->where('status', 'active');
    }

    public function scopeOngoing($query)
    {
        return $query->whereBetween('start_date', [now()->subDay(), now()])
                     ->where('status', 'active');
    }

    // Helpers
    public function isAvailable()
    {
        return $this->enrolled_count < $this->capacity && $this->status === 'active';
    }

    public function getAvailableSeatsAttribute()
    {
        return $this->capacity - $this->enrolled_count;
    }
}
