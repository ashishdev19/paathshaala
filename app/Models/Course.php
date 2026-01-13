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
        'category_id',
        'duration',
        'class_start_time',
        'class_end_time',
        'mode',
        'batch_start_date',
        'batch_end_date',
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
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

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

    /**
     * Get the thumbnail URL for the course.
     * Handles multiple formats: file paths, base64, URLs, with proper fallback.
     *
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        $thumbnail = $this->thumbnail;
        
        // Default placeholder image path
        $defaultImage = asset('img/default-course-thumbnail.png');
        
        // Return default if empty or null
        if (empty($thumbnail)) {
            return $defaultImage;
        }
        
        $thumbnail = trim($thumbnail);
        
        // 1. Handle base64 encoded images (legacy data)
        if (strpos($thumbnail, 'data:image/') === 0) {
            return $thumbnail;
        }
        
        // Also check for corrupted base64 that might have been prefixed
        if (strpos($thumbnail, ';base64,') !== false) {
            $startPos = strpos($thumbnail, 'data:image/');
            if ($startPos !== false) {
                return substr($thumbnail, $startPos);
            }
        }
        
        // 2. Handle full URLs (external images)
        if (filter_var($thumbnail, FILTER_VALIDATE_URL)) {
            return $thumbnail;
        }
        
        // 3. Handle file paths - normalize the path
        $path = $thumbnail;
        
        // Remove 'storage/' prefix if present
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, 8);
        }
        
        // Remove leading slashes
        $path = ltrim($path, '/');
        
        // Check if file exists in storage
        $storagePath = storage_path('app/public/' . $path);
        $publicPath = public_path('storage/' . $path);
        
        if (file_exists($publicPath)) {
            return asset('storage/' . $path);
        }
        
        if (file_exists($storagePath)) {
            return asset('storage/' . $path);
        }
        
        // 4. Return default image as fallback
        return $defaultImage;
    }
}
