<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'thumbnail',
        'banner',
        'syllabus',
        'teacher_id',
        'is_featured',
        'is_active',
        'duration_hours',
        'level',
    ];

    protected $casts = [
        'syllabus' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
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
}
