<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'type',
        'file_path',
        'video_url',
        'duration',
        'is_preview',
        'description',
        'order',
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'duration' => 'integer',
        'order' => 'integer',
    ];

    // Relationships
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    public function course()
    {
        return $this->section->course();
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopePreviewable($query)
    {
        return $query->where('is_preview', true);
    }

    // Helpers
    public function getDurationFormattedAttribute()
    {
        if (!$this->duration) {
            return 'N/A';
        }

        $hours = intdiv($this->duration, 3600);
        $minutes = intdiv(($this->duration % 3600), 60);
        $seconds = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%dh %dm %ds', $hours, $minutes, $seconds);
        } elseif ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $seconds);
        } else {
            return sprintf('%ds', $seconds);
        }
    }
}
