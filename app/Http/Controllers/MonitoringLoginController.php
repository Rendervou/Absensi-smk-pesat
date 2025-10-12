<?php

namespace App\Http\Controllers;

use App\Models\UserSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            // Ambil semua session yang online dan masih aktif (< 5 menit)
            $activeSessions = UserSession::with('user')
                ->where('status', 'online')
                ->where('last_activity', '>=', now()->subMinutes(5))
                ->orderBy('last_activity', 'desc')
                ->get();

            $users = $activeSessions->map(function($session) {
                return [
                    'id' => $session->user_id,
                    'name' => $session->user->name,
                    'role' => $session->user->role,
                    'role_badge' => $session->user->role === 'admin' ? 'Admin' : 'Guru',
                    'role_color' => $session->user->role === 'admin' ? 'purple' : 'blue',
                    'ip_address' => $session->ip_address,
                    'current_page' => $session->current_page ?? 'Tidak diketahui',    // TAMBAHKAN INI
                    'current_url' => $session->current_url ?? '-',                     // TAMBAHKAN INI
                    'login_at' => $session->login_at->format('H:i:s'),
                    'login_at_readable' => $session->login_at->diffForHumans(),
                    'last_activity' => $session->last_activity->format('H:i:s'),
                    'last_activity_readable' => $session->last_activity->diffForHumans(),
                    'duration' => $this->calculateDuration($session->login_at),
                    'browser' => $this->getBrowser($session->user_agent),
                    'device' => $this->getDevice($session->user_agent),
                ];
            });

            // Statistik
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
     * API: Get login history
     */
    public function getLoginHistory(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $role = $request->get('role', 'all');
            
            Log::info('Login History Request:', [
                'per_page' => $perPage,
                'role' => $role,
                'page' => $request->get('page', 1)
            ]);

            // Query dasar
            $query = UserSession::with('user')
                ->orderBy('login_at', 'desc');

            // Filter by role jika bukan 'all'
            if ($role !== 'all') {
                $query->whereHas('user', function($q) use ($role) {
                    $q->where('role', $role);
                });
            }

            // Get paginated results
            $history = $query->paginate($perPage);

            Log::info('Query Result:', [
                'total' => $history->total(),
                'count' => $history->count()
            ]);

            // Transform data
            $data = $history->map(function($session) {
                return [
                    'id' => $session->id,
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

            $response = [
                'success' => true,
                'data' => $data->values(), // Re-index array
                'pagination' => [
                    'current_page' => $history->currentPage(),
                    'last_page' => $history->lastPage(),
                    'per_page' => $history->perPage(),
                    'total' => $history->total(),
                ]
            ];

            Log::info('Response data count:', ['count' => $data->count()]);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error in getLoginHistory: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Update last activity (dipanggil dari client untuk keep-alive)
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
     * Helper: Calculate duration
     */
    private function calculateDuration($start, $end = null)
    {
        $end = $end ?? now();
        $diff = $start->diff($end);

        $parts = [];
        
        if ($diff->d > 0) {
            $parts[] = $diff->d . ' hari';
        }
        if ($diff->h > 0) {
            $parts[] = $diff->h . ' jam';
        }
        if ($diff->i > 0) {
            $parts[] = $diff->i . ' menit';
        }
        if (empty($parts) && $diff->s > 0) {
            $parts[] = $diff->s . ' detik';
        }

        return !empty($parts) ? implode(' ', $parts) : '0 detik';
    }

    /**
     * Helper: Get browser name from user agent
     */
    private function getBrowser($userAgent)
    {
        if (preg_match('/MSIE/i', $userAgent)) {
            return 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            return 'Opera';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            return 'Edge';
        }
        
        return 'Unknown';
    }

    /**
     * Helper: Get device type from user agent
     */
    private function getDevice($userAgent)
    {
        if (preg_match('/mobile/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'Tablet';
        }
        
        return 'Desktop';
    }
}