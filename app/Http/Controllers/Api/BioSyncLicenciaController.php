<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BioSyncLicencia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BioSyncLicenciaController extends Controller
{
    public function verificar(Request $request)
    {
        $data = $request->validate([
            'clave' => ['required', 'string', 'max:120'],
            'equipo_id' => ['nullable', 'string', 'max:120'],
            'version' => ['nullable', 'string', 'max:40'],
        ]);

        $licencia = BioSyncLicencia::where('clave', $data['clave'])->first();

        if (!$licencia) {
            return response()->json([
                'activa' => false,
                'mensaje' => 'Licencia no encontrada.',
            ], 404);
        }

        if (!$licencia->activa) {
            return response()->json([
                'activa' => false,
                'mensaje' => 'Licencia cancelada.',
            ]);
        }

        if ($licencia->fecha_vencimiento && Carbon::today()->gt($licencia->fecha_vencimiento)) {
            return response()->json([
                'activa' => false,
                'mensaje' => 'Licencia vencida.',
                'fecha_vencimiento' => optional($licencia->fecha_vencimiento)->toDateString(),
            ]);
        }

        $licencia->forceFill([
            'equipo_id' => $data['equipo_id'] ?? $licencia->equipo_id,
            'ultima_version' => $data['version'] ?? $licencia->ultima_version,
            'ultima_validacion' => now(),
        ])->save();

        return response()->json([
            'activa' => true,
            'mensaje' => 'Licencia valida.',
            'cliente' => $licencia->cliente,
            'fecha_vencimiento' => optional($licencia->fecha_vencimiento)->toDateString(),
            'ultima_validacion' => optional($licencia->ultima_validacion)->toDateTimeString(),
        ]);
    }
}