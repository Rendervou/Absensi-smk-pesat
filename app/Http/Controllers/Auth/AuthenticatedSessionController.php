<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\UserSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Sudah login di sini
        $request->authenticate();

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // TRACKING LOGIN - Simpan data login ke tabel user_sessions
        $this->trackLogin($request);

        // Cek role user yang sudah login
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    /**
     * Track user login
     */
    private function trackLogin(Request $request)
    {
        try {
            // Set semua session user ini yang masih online menjadi offline
            UserSession::where('user_id', Auth::id())
                      ->where('status', 'online')
                      ->update([
                          'status' => 'offline',
                          'logout_at' => now()
                      ]);

            // Buat record login baru
            UserSession::create([
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_at' => now(),
                'last_activity' => now(),
                'status' => 'online',
            ]);
        } catch (\Exception $e) {
            // Log error tapi jangan ganggu proses login
            \Log::error('Error tracking login: ' . $e->getMessage());
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // TRACKING LOGOUT - Update status menjadi offline
        $this->trackLogout();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Track user logout
     */
    private function trackLogout()
    {
        try {
            UserSession::where('user_id', Auth::id())
                      ->where('session_id', session()->getId())
                      ->where('status', 'online')
                      ->update([
                          'status' => 'offline',
                          'logout_at' => now()
                      ]);
        } catch (\Exception $e) {
            \Log::error('Error tracking logout: ' . $e->getMessage());
        }
    }
}