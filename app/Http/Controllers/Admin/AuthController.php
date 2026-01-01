<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:1',
        ]);

        // Fix: Gunakan where dengan closure untuk proper grouping
        $admin = Administrator::where(function ($query) use ($request) {
            $query->where('username', $request->username)
                  ->orWhere('email', $request->username);
        })->first();

        if (!$admin) {
            return back()->withErrors(['username' => 'Username atau email tidak ditemukan'])->withInput();
        }

        // Check if account is locked
        if ($admin->locked_until && $admin->locked_until->isFuture()) {
            $remainingMinutes = now()->diffInMinutes($admin->locked_until);
            return back()->withErrors([
                'username' => "Akun terkunci. Coba lagi dalam {$remainingMinutes} menit."
            ])->withInput();
        }

        // Check status
        if ($admin->status !== 'active') {
            return back()->withErrors(['username' => 'Akun tidak aktif. Hubungi administrator.'])->withInput();
        }

        // Verify password
        if (!Hash::check($request->password, $admin->password_hash)) {
            // Increment failed attempts
            $admin->increment('failed_login_attempts');

            // Refresh untuk mendapatkan nilai terbaru
            $admin->refresh();

            // Lock after 5 failed attempts
            if ($admin->failed_login_attempts >= 5) {
                $admin->update([
                    'locked_until' => now()->addMinutes(30),
                    'failed_login_attempts' => 0, // Reset setelah lock
                ]);
                return back()->withErrors([
                    'username' => 'Terlalu banyak percobaan gagal. Akun dikunci selama 30 menit.'
                ])->withInput();
            }

            $attemptsLeft = 5 - $admin->failed_login_attempts;
            return back()->withErrors([
                'password' => "Password salah. Sisa percobaan: {$attemptsLeft}"
            ])->withInput();
        }

        // Login success - reset attempts and update last login
        $admin->update([
            'failed_login_attempts' => 0,
            'login_attempts' => 0,
            'locked_until' => null, // Clear lock jika ada
            'last_login' => now(),
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Login admin menggunakan guard admin DULU
        /** @var \App\Models\Administrator $admin */
        Auth::guard('admin')->login($admin, $request->boolean('remember'));

        // Regenerate session untuk keamanan (prevent session fixation) SETELAH login
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
