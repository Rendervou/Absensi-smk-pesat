<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'activity_type',
        'page_name',
        'url',
        'method',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // PENTING: Append attributes ke JSON
    protected $appends = ['icon', 'color_class'];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke UserSession
     */
    public function session()
    {
        return $this->belongsTo(UserSession::class, 'session_id');
    }

    /**
     * Scope untuk filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter by session
     */
    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope untuk filter by activity type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Get icon based on activity type
     */
    public function getIconAttribute()
    {
        return match($this->activity_type) {
            'login' => '🔐',
            'logout' => '🚪',
            'page_visit' => '📄',
            'action' => '⚡',
            default => '📝'
        };
    }

    /**
     * Get color based on activity type
     */
    public function getColorClassAttribute()
    {
        return match($this->activity_type) {
            'login' => 'text-green-600 bg-green-50',
            'logout' => 'text-red-600 bg-red-50',
            'page_visit' => 'text-blue-600 bg-blue-50',
            'action' => 'text-purple-600 bg-purple-50',
            default => 'text-gray-600 bg-gray-50'
        };
    }
}