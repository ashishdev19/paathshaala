<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'teacher_id',
        'course_rating',
        'teacher_rating',
        'course_review',
        'teacher_review',
        'rating',
        'review_text',
        'pros',
        'cons',
        'is_verified',
        'is_featured',
        'is_approved',
        'approved_at',
        'helpful_count',
        'tags',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'approved_at' => 'datetime',
        'pros' => 'array',
        'cons' => 'array',
        'tags' => 'array',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeHighRated($query, $minRating = 4)
    {
        return $query->where(function($q) use ($minRating) {
            $q->where('course_rating', '>=', $minRating)
              ->orWhere('rating', '>=', $minRating);
        });
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Methods
    public function approve()
    {
        $this->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }

    public function reject()
    {
        $this->update([
            'is_approved' => false,
            'approved_at' => null,
        ]);
    }

    public function markAsFeatured()
    {
        $this->update(['is_featured' => true]);
    }

    public function markAsVerified()
    {
        $this->update(['is_verified' => true]);
    }

    public function incrementHelpful()
    {
        $this->increment('helpful_count');
    }

    // Accessors
    public function getOverallRatingAttribute()
    {
        if ($this->rating) {
            return $this->rating;
        }
        
        // Fallback to course_rating if available
        return $this->course_rating ?? 0;
    }

    public function getReviewContentAttribute()
    {
        return $this->review_text ?? $this->course_review ?? '';
    }

    public function getStarRatingAttribute()
    {
        $rating = $this->overall_rating;
        $stars = '';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }
        
        return $stars;
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStudentInitialsAttribute()
    {
        $name = $this->student->name ?? 'Anonymous';
        $words = explode(' ', $name);
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        
        return strtoupper(substr($name, 0, 2));
    }
}
