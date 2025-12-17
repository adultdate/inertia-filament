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

        if (! $request->secure() && app()->environment('production') && $shouldUseHttps) {
            // Build redirect URL using APP_URL domain
            $appHost = parse_url($appUrl, PHP_URL_HOST);
            $scheme = parse_url($appUrl, PHP_URL_SCHEME) ?: 'https';
            $port = parse_url($appUrl, PHP_URL_PORT);

            $redirectUrl = $scheme.'://'.$appHost;
            if ($port) {
                $redirectUrl .= ':'.$port;
            }
            $redirectUrl .= $request->getRequestUri();

            return redirect($redirectUrl, 301);
        }

        return $next($request);
    }
}
