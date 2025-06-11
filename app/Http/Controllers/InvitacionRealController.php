<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confirmacion;

class InvitacionRealController extends Controller
{
    public function show()
    {
        $evento = \App\Models\Evento::where('codigo_unico', 'camila')->firstOrFail();
        return view('invitaciones.Camila.show', compact('evento'));
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

        // Obtenemos el evento por su código único
        $evento = \App\Models\Evento::where('codigo_unico', 'camila')->firstOrFail();

        // Guardamos la confirmación vinculada al evento
        Confirmacion::create(array_merge($validated, [
            'evento_id' => $evento->id
        ]));

        return redirect()->back()->with('success', '¡Gracias por confirmar tu asistencia!');
    }

    public function listaConfirmados()
    {
        $confirmaciones = Confirmacion::orderBy('created_at', 'desc')->get();

        return view('invitaciones.Camila.lista', compact('confirmaciones'));
    }
}
