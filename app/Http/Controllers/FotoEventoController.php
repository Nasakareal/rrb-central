<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FotoEvento;
use Illuminate\Support\Facades\Storage;

class FotoEventoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'nombre_invitado' => 'nullable|string|max:255',
            'comentario' => 'nullable|string|max:500',
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $evento_id = $request->evento_id;
        $ip = $request->ip();

        // 1. 🔒 Limitar por IP (máx 5 fotos por evento)
        $fotosPorIp = FotoEvento::where('evento_id', $evento_id)
            ->where('created_at', '>=', now()->subDay())
            ->where('ip', $ip)
            ->count();

        if ($fotosPorIp >= 10) {
            return redirect()->back()->with('error', 'Has alcanzado el límite de 10 fotos para este evento desde esta IP.');
        }

        // 2. 🔁 Evitar duplicados (mismo nombre + comentario en el mismo evento)
        $yaExiste = FotoEvento::where('evento_id', $evento_id)
            ->where('nombre_invitado', $request->nombre_invitado)
            ->where('comentario', $request->comentario)
            ->exists();

        if ($yaExiste) {
            return redirect()->back()->with('error', 'Ya enviaste una foto con el mismo nombre y comentario.');
        }

        // 3. ☁️ Guardar imagen
        $path = $request->file('imagen')->store('fotos_evento', 'public');

        FotoEvento::create([
            'evento_id' => $evento_id,
            'nombre_invitado' => $request->nombre_invitado,
            'comentario' => $request->comentario,
            'imagen_path' => $path,
            'ip' => $ip,
        ]);

        return redirect()->back()->with('success', '¡Foto subida correctamente!');
    }
}
