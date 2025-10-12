<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $session = UserSession::where('user_id', Auth::id())
                ->where('session_id', session()->getId())
                ->where('status', 'online')
                ->first();

            if ($session) {
                // PENTING: Cek diffInMinutes SEBELUM update!
                $minutesInactive = now()->diffInMinutes($session->last_activity);
                
                // Auto logout jika tidak aktif > 10 menit
                if ($minutesInactive > 10) {
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

                // Update last activity (setelah cek!)
                $session->update([
                    'last_activity' => now(),
                    'current_page' => $this->getCurrentPageName($request),  // TAMBAHKAN INI
                    'current_url' => $request->fullUrl(),   // TAMBAHKAN INI
                ]);
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
        
        // Mapping path ke nama yang lebih friendly
        $pageNames = [
            'admin/dashboard' => 'Dashboard Admin',
            'user/dashboard' => 'Dashboard Guru',
            'admin/monitoring-login' => 'Monitoring Login',
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
            'profile' => 'Profil',
        ];

        // Cek apakah path ada di mapping
        foreach ($pageNames as $key => $name) {
            if (str_contains($path, $key)) {
                return $name;
            }
        }

        // Default: capitalize path
        return ucwords(str_replace(['/', '-', '_'], ' ', $path));
    }
}