<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confirmacion;

class InvitacionRealController extends Controller
{
    public function show()
    {
        return view('invitaciones.Camila.show');
    }

    public function confirmar(Request $request)
    {
        $validated = $request->validate([
            'nombre'     => 'required|string|max:255',
            'telefono'   => 'required|string|max:20',
            'email'      => 'required|email|max:255',
            'asistencia' => 'required|in:Sí,No',
            'boletos'    => 'nullable|in:Sí,No',
            'mensaje'    => 'nullable|string',
        ]);

        Confirmacion::create($validated);

        return redirect()->back()->with('success', '¡Gracias por confirmar tu asistencia!');
    }

    public function listaConfirmados()
    {
        $confirmaciones = Confirmacion::orderBy('created_at', 'desc')->get();

        return view('invitaciones.Camila.lista', compact('confirmaciones'));
    }
}
