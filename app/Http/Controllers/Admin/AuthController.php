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
    public function showLogin(): View
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Administrator::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$admin) {
            return back()->withErrors(['username' => 'Username tidak ditemukan'])->withInput();
        }

        // Check if account is locked
        if ($admin->locked_until && $admin->locked_until > now()) {
            return back()->withErrors(['username' => 'Akun terkunci. Coba lagi nanti.'])->withInput();
        }

        // Check status
        if ($admin->status !== 'active') {
            return back()->withErrors(['username' => 'Akun tidak aktif'])->withInput();
        }

        // Verify password
        if (!Hash::check($request->password, $admin->password_hash)) {
            // Increment failed attempts
            $admin->increment('failed_login_attempts');
            $admin->increment('login_attempts');

            // Lock after 5 failed attempts
            if ($admin->failed_login_attempts >= 5) {
                $admin->update(['locked_until' => now()->addMinutes(30)]);
                return back()->withErrors(['username' => 'Terlalu banyak percobaan. Akun dikunci 30 menit.'])->withInput();
            }

            return back()->withErrors(['password' => 'Password salah'])->withInput();
        }

        // Login success - reset attempts and update last login
        $admin->update([
            'failed_login_attempts' => 0,
            'login_attempts' => 0,
            'last_login' => now(),
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Login admin menggunakan guard admin
        Auth::guard('admin')->login($admin, $request->filled('remember'));

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
