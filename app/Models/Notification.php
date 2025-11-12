<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
        'action_url',
        'icon',
        'priority',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    // Accessors
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIconClassAttribute()
    {
        $icons = [
            'enrollment' => 'fas fa-graduation-cap text-blue-500',
            'payment' => 'fas fa-credit-card text-green-500',
            'class_reminder' => 'fas fa-clock text-yellow-500',
            'certificate' => 'fas fa-certificate text-purple-500',
            'course_update' => 'fas fa-book text-indigo-500',
            'system' => 'fas fa-cog text-gray-500',
            'default' => 'fas fa-bell text-blue-500',
        ];

        return $icons[$this->type] ?? $icons['default'];
    }

    public function getPriorityColorAttribute()
    {
        $colors = [
            'low' => 'text-gray-500',
            'normal' => 'text-blue-500',
            'high' => 'text-orange-500',
            'urgent' => 'text-red-500',
        ];

        return $colors[$this->priority] ?? $colors['normal'];
    }
}
