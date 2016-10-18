<?php

namespace Flavorgod\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Contracts\Guard;

class MakeNonCachable
{
    /**
     * Middleware handler
     *
     * Checks domain
     * Authenticates credentials using WebGuard
     *
     * @param \Illuminate\Http\Request   $request    Request instance
     * @param \Closure                   $next       Reference to next middleware/route
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 0);

        return $response;
    }
}
