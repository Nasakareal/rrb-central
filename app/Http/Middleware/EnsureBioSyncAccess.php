<?php

namespace App\Http\Middleware;

use Closure;

class EnsureBioSyncAccess
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        $roles = [
            'Administrador',
            'encargado',
            'BioSync Administrador',
            'BioSync Operador',
            'BioSync Consulta',
        ];

        if (!$user || (!$user->hasAnyRole($roles) && !$user->can('ver biosync') && !$user->can('gestionar biosync'))) {
            abort(403, 'No tienes acceso a BioSync.');
        }

        return $next($request);
    }
}
