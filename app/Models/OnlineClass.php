<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'video_url',
        'video_qualities',
        'available_speeds',
        'allow_offline_download',
        'meeting_link',
        'meeting_id',
        'meeting_password',
        'scheduled_at',
        'duration_minutes',
        'is_active',
        'order',
        'total_views',
        'total_watch_time',
        'completion_rate',
        'enable_chat',
        'enable_polls',
        'enable_screen_share',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_active' => 'boolean',
        'video_qualities' => 'array',
        'available_speeds' => 'array',
        'allow_offline_download' => 'boolean',
        'enable_chat' => 'boolean',
        'enable_polls' => 'boolean',
        'enable_screen_share' => 'boolean',
        'completion_rate' => 'float',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLive($query)
    {
        return $query->where('type', 'live');
    }

    public function scopeRecorded($query)
    {
        return $query->where('type', 'recorded');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Attributes
    public function getMeetingUrlAttribute()
    {
        return $this->meeting_link;
    }

    public function getRecordingUrlAttribute()
    {
        return $this->video_url;
    }

    public function getDurationAttribute()
    {
        return $this->duration_minutes;
    }

    public function getDefaultVideoQualitiesAttribute()
    {
        return $this->video_qualities ?? ['720p' => $this->video_url];
    }

    public function getDefaultPlaybackSpeedsAttribute()
    {
        return $this->available_speeds ?? [0.5, 0.75, 1.0, 1.25, 1.5, 2.0];
    }

    public function getAverageWatchTimeAttribute()
    {
        return $this->total_views > 0 ? $this->total_watch_time / $this->total_views : 0;
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        
        return "{$minutes}m";
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('total_views');
    }

    public function addWatchTime($seconds)
    {
        $this->increment('total_watch_time', $seconds);
        $this->updateCompletionRate();
    }

    public function updateCompletionRate()
    {
        if ($this->total_views > 0) {
            // Assuming 80% of duration watched = completed
            $avgWatchTime = $this->total_watch_time / $this->total_views;
            $completionThreshold = $this->duration_minutes * 60 * 0.8; // 80% of total duration
            
            $rate = min(100.0, ($avgWatchTime / $completionThreshold) * 100);
            $this->completion_rate = $rate;
            $this->save();
        }
    }

    public function isLiveNow()
    {
        if ($this->type !== 'live') {
            return false;
        }

        $now = now();
        $startTime = $this->scheduled_at;
        $endTime = $startTime->copy()->addMinutes($this->duration_minutes);

        return $now->between($startTime, $endTime);
    }

    public function canJoinNow()
    {
        if ($this->type !== 'live') {
            return false;
        }

        $now = now();
        $startTime = $this->scheduled_at;
        $endTime = $startTime->copy()->addMinutes($this->duration_minutes);
        $earlyJoinTime = $startTime->copy()->subMinutes(15); // Allow joining 15 mins early

        return $now->between($earlyJoinTime, $endTime);
    }
}
