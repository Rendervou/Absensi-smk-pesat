<?php

namespace App\Http\Controllers;

use App\Models\UserSession;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MonitoringLoginController extends Controller
{
    /**
     * Tampilkan halaman monitoring
     */
    public function index()
    {
        return view('admin.monitoring-login');
    }

    /**
     * API: Get active users (untuk AJAX polling)
     */
    public function getActiveUsers(Request $request)
    {
        try {
            $activeSessions = UserSession::with('user')
                ->where('status', 'online')
                ->where('last_activity', '>=', now()->subMinutes(5))
                ->orderBy('last_activity', 'desc')
                ->get();

            $users = $activeSessions->map(function($session) {
                return [
                    'id' => $session->user_id,
                    'session_id' => $session->id,
                    'name' => $session->user->name,
                    'role' => $session->user->role,
                    'role_badge' => $session->user->role === 'admin' ? 'Admin' : 'Guru',
                    'role_color' => $session->user->role === 'admin' ? 'purple' : 'blue',
                    'ip_address' => $session->ip_address,
                    'current_page' => $session->current_page ?? 'Tidak diketahui',
                    'current_url' => $session->current_url ?? '-',
                    'login_at' => $session->login_at->format('H:i:s'),
                    'login_at_readable' => $session->login_at->diffForHumans(),
                    'last_activity' => $session->last_activity->format('H:i:s'),
                    'last_activity_readable' => $session->last_activity->diffForHumans(),
                    'duration' => $this->calculateDuration($session->login_at),
                    'browser' => $this->getBrowser($session->user_agent),
                    'device' => $this->getDevice($session->user_agent),
                ];
            });

            $stats = [
                'total_online' => $users->count(),
                'total_admin' => $users->where('role', 'admin')->count(),
                'total_guru' => $users->where('role', 'user')->count(),
                'total_users' => User::count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $users,
                'stats' => $stats,
                'timestamp' => now()->format('H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getActiveUsers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get user detail & activity history
     */
    public function getUserDetail(Request $request, $userId)
    {
        try {
            $user = User::with(['activeSession'])->findOrFail($userId);
            
            // Get current session info
            $currentSession = $user->activeSession;
            
            // Get all sessions history
            $sessionsHistory = UserSession::where('user_id', $userId)
                ->orderBy('login_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function($session) {
                    return [
                        'id' => $session->id,
                        'login_at' => $session->login_at->format('d/m/Y H:i:s'),
                        'logout_at' => $session->logout_at ? $session->logout_at->format('d/m/Y H:i:s') : 'Masih Online',
                        'duration' => $session->logout_at 
                            ? $this->calculateDuration($session->login_at, $session->logout_at)
                            : $this->calculateDuration($session->login_at),
                        'ip_address' => $session->ip_address,
                        'browser' => $this->getBrowser($session->user_agent),
                        'status' => $session->status,
                    ];
                });

            // Get activity logs (limit 50)
            $activities = UserActivityLog::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get()
                ->map(function($activity) {
                    return [
                        'id' => $activity->id,
                        'type' => $activity->activity_type,
                        'icon' => $activity->icon,
                        'color_class' => $activity->color_class,
                        'page_name' => $activity->page_name ?? '-',
                        'url' => $activity->url ?? '-',
                        'method' => $activity->method,
                        'description' => $activity->description ?? '-',
                        'time' => $activity->created_at->format('d/m/Y H:i:s'),
                        'time_readable' => $activity->created_at->diffForHumans(),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'role' => $user->role,
                        'role_badge' => $user->role === 'admin' ? 'Admin' : 'Guru',
                    ],
                    'current_session' => $currentSession ? [
                        'ip_address' => $currentSession->ip_address,
                        'browser' => $this->getBrowser($currentSession->user_agent),
                        'device' => $this->getDevice($currentSession->user_agent),
                        'current_page' => $currentSession->current_page ?? '-',
                        'login_at' => $currentSession->login_at->format('d/m/Y H:i:s'),
                        'last_activity' => $currentSession->last_activity->format('d/m/Y H:i:s'),
                        'duration' => $this->calculateDuration($currentSession->login_at),
                    ] : null,
                    'sessions_history' => $sessionsHistory,
                    'activities' => $activities,
                    'stats' => [
                        'total_sessions' => UserSession::where('user_id', $userId)->count(),
                        'total_activities' => UserActivityLog::where('user_id', $userId)->count(),
                        'total_page_visits' => UserActivityLog::where('user_id', $userId)->where('activity_type', 'page_visit')->count(),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getUserDetail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Force logout user
     */
    public function forceLogout(Request $request)
    {
        try {
            $request->validate([
                'session_id' => 'required|exists:user_sessions,id',
                'reason' => 'nullable|string|max:255'
            ]);

            $session = UserSession::findOrFail($request->session_id);
            
            // Tidak bisa logout diri sendiri
            if ($session->user_id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat logout paksa sesi Anda sendiri!'
                ], 400);
            }

            // Log aktivitas force logout
            UserActivityLog::create([
                'user_id' => $session->user_id,
                'session_id' => $session->id,
                'activity_type' => 'logout',
                'page_name' => 'Force Logout',
                'description' => 'Logout paksa oleh admin: ' . Auth::user()->name . ($request->reason ? ' - Alasan: ' . $request->reason : ''),
                'ip_address' => $session->ip_address,
                'user_agent' => $session->user_agent,
            ]);

            // Update session status
            $session->update([
                'status' => 'offline',
                'logout_at' => now()
            ]);

            // Invalidate Laravel session (jika masih ada)
            // Note: Ini akan menghapus session dari storage
            DB::table('sessions')->where('id', $session->session_id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil di-logout paksa!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in forceLogout: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout paksa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get login history
     */
    public function getLoginHistory(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $role = $request->get('role', 'all');
            
            $query = UserSession::with('user')
                ->orderBy('login_at', 'desc');

            if ($role !== 'all') {
                $query->whereHas('user', function($q) use ($role) {
                    $q->where('role', $role);
                });
            }

            $history = $query->paginate($perPage);

            $data = $history->map(function($session) {
                return [
                    'id' => $session->id,
                    'user_id' => $session->user_id,
                    'user_name' => $session->user->name ?? 'Unknown',
                    'role' => $session->user->role ?? 'unknown',
                    'role_badge' => $session->user && $session->user->role === 'admin' ? 'Admin' : 'Guru',
                    'ip_address' => $session->ip_address,
                    'login_at' => $session->login_at ? $session->login_at->format('d/m/Y H:i:s') : '-',
                    'logout_at' => $session->logout_at ? $session->logout_at->format('d/m/Y H:i:s') : '-',
                    'duration' => $session->logout_at 
                        ? $this->calculateDuration($session->login_at, $session->logout_at)
                        : 'Masih Online',
                    'status' => $session->status,
                    'status_badge' => $session->status === 'online' ? 'Online' : 'Offline',
                    'browser' => $this->getBrowser($session->user_agent),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data->values(),
                'pagination' => [
                    'current_page' => $history->currentPage(),
                    'last_page' => $history->lastPage(),
                    'per_page' => $history->perPage(),
                    'total' => $history->total(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getLoginHistory: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update last activity
     */
    public function updateActivity(Request $request)
    {
        try {
            $session = UserSession::where('user_id', auth()->id())
                ->where('session_id', session()->getId())
                ->where('status', 'online')
                ->first();

            if ($session) {
                $session->updateActivity();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Activity updated'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Session not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error in updateActivity: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper functions
     */
    private function calculateDuration($start, $end = null)
    {
        $end = $end ?? now();
        $diff = $start->diff($end);

        $parts = [];
        if ($diff->d > 0) $parts[] = $diff->d . ' hari';
        if ($diff->h > 0) $parts[] = $diff->h . ' jam';
        if ($diff->i > 0) $parts[] = $diff->i . ' menit';
        if (empty($parts) && $diff->s > 0) $parts[] = $diff->s . ' detik';

        return !empty($parts) ? implode(' ', $parts) : '0 detik';
    }

    private function getBrowser($userAgent)
    {
        if (preg_match('/MSIE/i', $userAgent)) return 'Internet Explorer';
        if (preg_match('/Firefox/i', $userAgent)) return 'Firefox';
        if (preg_match('/Chrome/i', $userAgent)) return 'Chrome';
        if (preg_match('/Safari/i', $userAgent)) return 'Safari';
        if (preg_match('/Opera/i', $userAgent)) return 'Opera';
        if (preg_match('/Edge/i', $userAgent)) return 'Edge';
        return 'Unknown';
    }

    private function getDevice($userAgent)
    {
        if (preg_match('/mobile/i', $userAgent)) return 'Mobile';
        if (preg_match('/tablet/i', $userAgent)) return 'Tablet';
        return 'Desktop';
    }
}