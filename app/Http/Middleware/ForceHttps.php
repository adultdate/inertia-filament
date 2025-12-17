<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

final class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip redirect for local/internal IPs
        $host = $request->getHost();
        $isLocal = in_array($host, ['127.0.0.1', 'localhost', '::1']) ||
                   str_starts_with($host, '192.168.') ||
                   str_starts_with($host, '10.') ||
                   str_starts_with($host, '172.');

        if ($isLocal) {
            return $next($request);
        }

        // Only redirect HTTP to HTTPS in production, and only if APP_URL uses HTTPS
        $appUrl = config('app.url');
        $shouldUseHttps = str_starts_with($appUrl, 'https://');

        // Check if request is secure (handles proxies correctly)
        $isSecure = $request->secure() ||
                   $request->header('X-Forwarded-Proto') === 'https' ||
                   $request->header('X-Forwarded-Ssl') === 'on';

        if (! $isSecure && app()->environment('production') && $shouldUseHttps) {
            // Build redirect URL using the current request's host (not APP_URL host)
            // This prevents redirect loops when APP_URL doesn't match the actual domain
            $scheme = 'https';
            $currentHost = $request->getHost();
            $port = $request->getPort();

            // Only include port if it's not the default HTTPS port (443)
            $redirectUrl = $scheme.'://'.$currentHost;
            if ($port && $port !== 443 && $port !== 80) {
                $redirectUrl .= ':'.$port;
            }
            $redirectUrl .= $request->getRequestUri();

            return redirect($redirectUrl, 301);
        }

        return $next($request);
    }
}
