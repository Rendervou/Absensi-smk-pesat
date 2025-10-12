<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserSession;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $session = UserSession::where('user_id', Auth::id())
                ->where('session_id', session()->getId())
                ->where('status', 'online')
                ->first();

            if ($session) {
                // Cek diffInMinutes SEBELUM update
                $minutesInactive = now()->diffInMinutes($session->last_activity);
                
                // Auto logout jika tidak aktif > 10 menit
                if ($minutesInactive > 10) {
                    // Log aktivitas logout otomatis
                    $this->logActivity($session, 'logout', null, 'Auto logout karena tidak aktif 10 menit');
                    
                    // Update session ke offline
                    $session->update([
                        'status' => 'offline',
                        'logout_at' => now()
                    ]);
                    
                    // Logout user
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return redirect()->route('login')->with('status', 'Sesi Anda telah berakhir karena tidak aktif selama 10 menit. Silakan login kembali untuk melanjutkan.');
                }

                // Update last activity
                $currentPage = $this->getCurrentPageName($request);
                $currentUrl = $request->fullUrl();
                
                $session->update([
                    'last_activity' => now(),
                    'current_page' => $currentPage,
                    'current_url' => $currentUrl,
                ]);

                // Log page visit (hanya untuk non-AJAX request dan bukan API monitoring)
                if (!$request->ajax() && !str_contains($request->path(), 'api/') && !str_contains($request->path(), 'monitoring/api')) {
                    $this->logActivity($session, 'page_visit', $currentPage, $currentUrl);
                }
            }
        }

        return $next($request);
    }

    /**
     * Get nama halaman yang user-friendly
     */
    private function getCurrentPageName($request)
    {
        $path = $request->path();
        
        $pageNames = [
            'admin/dashboard' => 'Dashboard Admin',
            'user/dashboard' => 'Dashboard Guru',
            'admin/monitoring/login' => 'Monitoring Login',
            'admin/presensi' => 'Halaman Presensi',
            'user/presensi' => 'Input Presensi',
            'admin/siswa' => 'Data Siswa',
            'admin/kelas' => 'Data Kelas',
            'admin/guru' => 'Data Guru',
            'admin/jurusan' => 'Data Jurusan',
            'admin/rombel' => 'Data Rombel',
            'admin/perkelas' => 'Laporan Per Kelas',
            'admin/perbulan' => 'Laporan Per Bulan',
            'user/perkelas' => 'Laporan Per Kelas',
            'user/perbulan' => 'Laporan Per Bulan',
            'admin/naik-kelas' => 'Naik Kelas',
            'admin/kelulusan' => 'Kelulusan',
            'admin/alumni' => 'Data Alumni',
            'profile' => 'Profil',
        ];

        foreach ($pageNames as $key => $name) {
            if (str_contains($path, $key)) {
                return $name;
            }
        }

        return ucwords(str_replace(['/', '-', '_'], ' ', $path));
    }

    /**
     * Log user activity
     */
    private function logActivity($session, $type, $pageName, $description = null)
    {
        try {
            UserActivityLog::create([
                'user_id' => $session->user_id,
                'session_id' => $session->id,
                'activity_type' => $type,
                'page_name' => $pageName,
                'url' => $description, // Untuk page_visit, description berisi URL
                'method' => request()->method(),
                'description' => $description,
                'ip_address' => $session->ip_address,
                'user_agent' => $session->user_agent,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}