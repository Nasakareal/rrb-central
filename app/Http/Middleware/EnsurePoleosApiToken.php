<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePoleosApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $configuredToken = config('services.poleos.token');

        if (empty($configuredToken)) {
            return response()->json([
                'message' => 'API de poleos no configurada.',
            ], 503);
        }

        $requestToken = $request->bearerToken() ?: $request->header('X-Poleos-Token');

        if (!$requestToken || !hash_equals($configuredToken, $requestToken)) {
            return response()->json([
                'message' => 'No autorizado.',
            ], 401);
        }

        return $next($request);
    }
}
