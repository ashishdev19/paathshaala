<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'course_id',
        'topic',
        'description',
        'mode',
        'room_name',
        'meeting_link',
        'start_datetime',
        'duration',
        'allow_chat',
        'allow_mic',
        'allow_video',
        'status',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'allow_chat' => 'boolean',
        'allow_mic' => 'boolean',
        'allow_video' => 'boolean',
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Helpers
    public function isLive()
    {
        return $this->status === 'live';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    public function hasStarted()
    {
        return now()->greaterThan($this->start_datetime);
    }

    public function getFormattedDateAttribute()
    {
        return $this->start_datetime->format('M d, Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->start_datetime->format('h:i A');
    }
}
