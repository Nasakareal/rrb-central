<?php

namespace App\Http\Controllers\Rifas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\RifaBoleto;

class RifaPublicController extends Controller
{
    public function index()
    {
        $rifas = Rifa::activas()->vigentes()
            ->orderByDesc('fyh_creacion')
            ->get();

        return view('rifas.index', compact('rifas'));
    }

    public function show(Rifa $rifa)
    {
        RifaBoleto::where('rifa_id', $rifa->rifa_id)
            ->where('estado', 'apartado')
            ->whereNotNull('reservado_hasta')
            ->where('reservado_hasta', '<', now())
            ->whereNull('orden_id')
            ->update([
                'estado' => 'disponible',
                'user_id' => null,
                'reservado_hasta' => null,
                'fyh_actualizacion' => now(),
            ]);

        $disponibles = RifaBoleto::where('rifa_id', $rifa->rifa_id)
            ->where('estado', 'disponible')
            ->pluck('numero')
            ->toArray();

        $vendidos = RifaBoleto::where('rifa_id', $rifa->rifa_id)
            ->where('estado', 'vendido')
            ->count();

        return view('rifas.show', [
            'rifa'        => $rifa,
            'disponibles' => $disponibles,
            'vendidos'    => $vendidos,
        ]);
    }

    public function misBoletos(Rifa $rifa, Request $request)
    {
        $user = $request->user();
        $boletos = RifaBoleto::where('rifa_id', $rifa->rifa_id)
            ->where('user_id', $user?->id)
            ->orderBy('numero')
            ->get();

        return view('rifas.mis-boletos', compact('rifa', 'boletos'));
    }
}
