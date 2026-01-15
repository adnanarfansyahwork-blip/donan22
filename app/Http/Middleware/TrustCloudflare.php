<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trust Cloudflare Proxy Middleware
 * 
 * This middleware ensures Laravel correctly handles requests
 * proxied through Cloudflare by:
 * 1. Trusting Cloudflare's IP ranges
 * 2. Using CF-Connecting-IP header for real visitor IP
 * 3. Detecting HTTPS via CF-Visitor header
 */
class TrustCloudflare
{
    /**
     * Cloudflare IPv4 ranges (updated regularly)
     * Source: https://www.cloudflare.com/ips-v4
     */
    protected array $cloudflareIps = [
        '173.245.48.0/20',
        '103.21.244.0/22',
        '103.22.200.0/22',
        '103.31.4.0/22',
        '141.101.64.0/18',
        '108.162.192.0/18',
        '190.93.240.0/20',
        '188.114.96.0/20',
        '197.234.240.0/22',
        '198.41.128.0/17',
        '162.158.0.0/15',
        '104.16.0.0/13',
        '104.24.0.0/14',
        '172.64.0.0/13',
        '131.0.72.0/22',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set trusted proxies to Cloudflare IPs
        $request->setTrustedProxies(
            $this->cloudflareIps,
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );

        // Use CF-Connecting-IP as the real client IP
        if ($request->hasHeader('CF-Connecting-IP')) {
            $request->server->set('REMOTE_ADDR', $request->header('CF-Connecting-IP'));
        }

        // Detect HTTPS from Cloudflare's CF-Visitor header
        if ($request->hasHeader('CF-Visitor')) {
            $cfVisitor = json_decode($request->header('CF-Visitor'), true);
            if (isset($cfVisitor['scheme']) && $cfVisitor['scheme'] === 'https') {
                $request->server->set('HTTPS', 'on');
            }
        }

        // Also check X-Forwarded-Proto
        if ($request->header('X-Forwarded-Proto') === 'https') {
            $request->server->set('HTTPS', 'on');
        }

        return $next($request);
    }
}
