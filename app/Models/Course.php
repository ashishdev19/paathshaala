<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'category',
        'language',
        'course_mode',
        'price',
        'is_free',
        'discount_price',
        'thumbnail',
        'promo_video_url',
        'demo_pdf',
        'demo_lecture',
        'banner',
        'syllabus',
        'teacher_id',
        'is_featured',
        'is_active',
        'duration_hours',
        'level',
        'status',
        'video_file',
        'video_url',
        'course_urls',
        'validity_days',
        'is_lifetime',
        'meta_title',
        'meta_description',
        'slug',
        'rejection_reason',
        'approved_by',
    ];

    protected $casts = [
        'syllabus' => 'array',
        'course_urls' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_lifetime' => 'boolean',
        'is_free' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'validity_days' => 'integer',
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function onlineClasses()
    {
        return $this->hasMany(OnlineClass::class)->orderBy('order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class)->orderBy('order');
    }

    public function lectures()
    {
        return $this->hasManyThrough(
            CourseLecture::class, 
            CourseSection::class,
            'course_id', // Foreign key on course_sections table
            'section_id', // Foreign key on course_lectures table
            'id', // Local key on courses table
            'id' // Local key on course_sections table
        );
    }

    public function offlineBatches()
    {
        return $this->hasMany(OfflineBatch::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Attributes
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('course_rating') ?? 0;
    }

    public function getEnrollmentCountAttribute()
    {
        return $this->enrollments()->count();
    }

    public function getFeaturedAttribute()
    {
        return $this->is_featured;
    }

    public function getStatusAttribute()
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    // Add compatibility with old field names
    public function getDurationAttribute()
    {
        return $this->duration_hours;
    }

    public function getActiveAttribute()
    {
        return $this->is_active;
    }

    // Validity helper methods
    public function getValidityPeriodAttribute()
    {
        if ($this->is_lifetime) {
            return 'Lifetime Access';
        }
        
        $days = $this->validity_days;
        if ($days >= 365) {
            $years = floor($days / 365);
            $remaining_days = $days % 365;
            if ($remaining_days > 0) {
                return $years . ' year' . ($years > 1 ? 's' : '') . ' and ' . $remaining_days . ' day' . ($remaining_days > 1 ? 's' : '');
            } else {
                return $years . ' year' . ($years > 1 ? 's' : '');
            }
        } elseif ($days >= 30) {
            $months = floor($days / 30);
            $remaining_days = $days % 30;
            if ($remaining_days > 0) {
                return $months . ' month' . ($months > 1 ? 's' : '') . ' and ' . $remaining_days . ' day' . ($remaining_days > 1 ? 's' : '');
            } else {
                return $months . ' month' . ($months > 1 ? 's' : '');
            }
        } else {
            return $days . ' day' . ($days > 1 ? 's' : '');
        }
    }

    public function calculateExpiryDate($enrollmentDate = null)
    {
        if ($this->is_lifetime) {
            return null; // Never expires
        }
        
        $startDate = $enrollmentDate ? $enrollmentDate : now();
        return $startDate->addDays($this->validity_days);
    }
}
