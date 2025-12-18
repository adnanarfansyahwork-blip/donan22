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
            return redirect()->route('admin.login')->with('error', 'Please login to access admin area.');
        }

        $admin = Auth::guard('admin')->user();

        // Check if account is locked
        if ($admin->locked_until && $admin->locked_until > now()) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Your account is locked. Please try again later.');
        }

        // Check if account is active
        if ($admin->status !== 'active') {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Your account is not active.');
        }

        // Share admin data with all views
        view()->share('currentAdmin', $admin);

        return $next($request);
    }
}
