<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirect www to non-www for SEO canonical URL consistency.
 * This prevents duplicate content issues in search engines.
 */
class RedirectWwwToNonWww
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // Only redirect in production and if www prefix is present
        if (app()->environment('production') && str_starts_with($host, 'www.')) {
            // Build new URL without www
            $newHost = substr($host, 4); // Remove 'www.'
            $newUrl = $request->getScheme() . '://' . $newHost . $request->getRequestUri();

            // 301 permanent redirect for SEO
            return redirect()->away($newUrl, 301);
        }

        return $next($request);
    }
}
