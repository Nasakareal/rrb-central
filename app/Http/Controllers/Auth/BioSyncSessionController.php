<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BioSyncSessionController extends Controller
{
    public function create()
    {
        return view('biosync.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        $roles = [
            'Administrador',
            'encargado',
            'BioSync Administrador',
            'BioSync Operador',
            'BioSync Consulta',
        ];

        if (!$user->hasAnyRole($roles) && !$user->can('ver biosync') && !$user->can('gestionar biosync')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Tu cuenta no tiene acceso a BioSync.',
            ]);
        }

        return redirect()->route('biosync.index');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('biosync.login');
    }
}
