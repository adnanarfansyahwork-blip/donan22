<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     * Check if admin is logged in using the admin guard
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin is authenticated via admin guard
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login untuk mengakses area admin.');
        }

        $admin = Auth::guard('admin')->user();

        // Check if account is locked (menggunakan isFuture untuk null-safe)
        if ($admin->locked_until && $admin->locked_until->isFuture()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'Akun Anda terkunci. Silakan coba lagi nanti.');
        }

        // Check if account is active
        if ($admin->status !== 'active') {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Share admin data with all views
        view()->share('currentAdmin', $admin);

        return $next($request);
    }
}
