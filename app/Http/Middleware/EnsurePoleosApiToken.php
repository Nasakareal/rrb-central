<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePoleosApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $configuredToken = trim((string) config('services.poleos.token'));

        if (empty($configuredToken)) {
            return response()->json([
                'message' => 'API de poleos no configurada.',
            ], 503);
        }

        $requestToken = $this->tokenFromRequest($request);

        if (!$requestToken || !hash_equals($configuredToken, $requestToken)) {
            return response()->json([
                'message' => 'No autorizado.',
            ], 401);
        }

        return $next($request);
    }

    private function tokenFromRequest(Request $request): ?string
    {
        $token = $request->bearerToken() ?: $request->header('X-Poleos-Token');

        if (!$token) {
            foreach (['HTTP_AUTHORIZATION', 'REDIRECT_HTTP_AUTHORIZATION', 'Authorization'] as $serverKey) {
                $header = $request->server($serverKey);

                if (!empty($header)) {
                    $token = $this->extractBearerToken($header);
                    break;
                }
            }
        }

        return $token ? trim((string) $token) : null;
    }

    private function extractBearerToken($header): string
    {
        $header = trim((string) $header);

        if (stripos($header, 'Bearer ') === 0) {
            return trim(substr($header, 7));
        }

        return $header;
    }
}
