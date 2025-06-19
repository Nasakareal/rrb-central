<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Invitacion;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class InvitacionRealController extends Controller
{
    public function show()
    {
        $evento = Evento::where('codigo_unico', 'camila')->firstOrFail();
        $invitacion = null;

        if (Session::has('invitacion_id')) {
            $invitacion = Invitacion::with('user')->find(Session::get('invitacion_id'));
        }

        return view('invitaciones.Camila.show', compact('evento', 'invitacion'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'credencial' => 'required|string|max:255',
        ]);

        $valor = $request->credencial;

        $invitacion = Invitacion::whereHas('user', function ($q) use ($valor) {
            $q->where('email', $valor)
              ->orWhere('name', 'LIKE', "%$valor%");
        })->first();

        if (!$invitacion) {
            return redirect()->back()->withErrors(['credencial' => 'Invitado no encontrado.']);
        }

        session(['invitacion_id' => $invitacion->id]);

        return redirect()->route('camila.invitacion');
    }

    public function confirmar(Request $request, $id)
    {
        $request->validate([
            'telefono'   => 'required|string|max:20',
            'email'      => 'required|email|max:255',
            'asistencia' => 'required|in:Sí,No',
            'boletos'    => 'nullable|in:Sí,No',
            'mensaje'    => 'nullable|string',
        ]);

        $invitacion = Invitacion::findOrFail($id);
        $invitacion->asistencia_confirmada = true;

        if (!$invitacion->qr_token) {
            $invitacion->qr_token = Str::uuid();
        }

        $invitacion->save();

        // Insertar también en la tabla confirmaciones
        \App\Models\Confirmacion::create([
            'evento_id' => $invitacion->evento_id,
            'nombre'    => $invitacion->user->name,
            'telefono'  => $request->telefono,
            'email'     => $request->email,
            'asistencia'=> $request->asistencia,
            'boletos'   => $request->boletos,
            'mensaje'   => $request->mensaje,
        ]);

        return redirect()->route('camila.invitacion')->with('success', '¡Asistencia confirmada!');
    }


    public function logout()
    {
        session()->forget('invitacion_id');
        return redirect()->route('camila.invitacion');
    }
}
