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
    $ultimaConfirmacion = null;

    if (Session::has('invitacion_id')) {
        $invitacion = Invitacion::with('user')->find(Session::get('invitacion_id'));

        // Buscar última confirmación por nombre y evento
        $ultimaConfirmacion = \App\Models\Confirmacion::where('nombre', $invitacion->user->name)
            ->where('evento_id', $invitacion->evento_id)
            ->orderByDesc('created_at')
            ->first();
    }

    return view('invitaciones.Camila.show', compact('evento', 'invitacion', 'ultimaConfirmacion'));
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
        $invitacion = Invitacion::findOrFail($id);

        $request->validate([
            'telefono'   => 'required|string|max:20',
            'email'      => 'required|email|max:255',
            'asistencia' => 'required|in:Sí,No',
            'boletos'    => 'required|integer|min:0|max:' . $invitacion->num_pases_confirmados,
            'mensaje'    => 'nullable|string',
        ]);

        $invitacion->asistencia_confirmada = true;

        if (!$invitacion->qr_token) {
            $invitacion->qr_token = \Illuminate\Support\Str::uuid();
        }

        $invitacion->save();

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
