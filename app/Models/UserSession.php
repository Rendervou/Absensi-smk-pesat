<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'current_page',
        'current_url', 
        'login_at',
        'logout_at',
        'last_activity',
        'status',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
        'last_activity' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk user yang sedang online
     */
    public function scopeOnline($query)
    {
        return $query->where('status', 'online')
                    ->where('last_activity', '>=', now()->subMinutes(5));
    }

    /**
     * Scope untuk user dengan role tertentu
     */
    public function scopeByRole($query, $role)
    {
        return $query->whereHas('user', function($q) use ($role) {
            $q->where('role', $role);
        });
    }

    /**
     * Cek apakah user masih aktif (last activity < 5 menit)
     */
    public function isActive()
    {
        if (!$this->last_activity) {
            return false;
        }
        
        return $this->last_activity->diffInMinutes(now()) < 5;
    }

    /**
     * Update last activity
     */
    public function updateActivity()
    {
        $this->update([
            'last_activity' => now(),
            'status' => 'online'
        ]);
    }
}