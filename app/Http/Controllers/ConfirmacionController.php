<?php

namespace App\Http\Controllers;

use App\Models\Confirmacion;
use Illuminate\Http\Request;

class ConfirmacionController extends Controller
{
    public function index()
    {
        $confirmaciones = Confirmacion::latest()->get();

        return view('confirmaciones.index', compact('confirmaciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'asistencia' => 'required|in:Sí,No',
            'boletos' => 'nullable|in:Sí,No',
            'mensaje' => 'nullable|string',
        ]);

        Confirmacion::create($validated);

        return redirect()->back()->with('success', '¡Gracias por confirmar tu asistencia!');
    }
}
