<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');
        // Ensure Laravel treats it as expecting JSON
        if (method_exists($request, 'setJson')) {
            // No-op in modern Laravel; keeping for forward-compat.
        }

        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
