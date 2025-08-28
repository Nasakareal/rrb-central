<?php

namespace App\Http\Controllers\Rifas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Rifa;
use App\Models\RifaBoleto;
use App\Models\RifaOrden;

class RifaOperacionController extends Controller
{
    public function reservar(Rifa $rifa, Request $request)
    {
        $data = $request->validate([
            'numeros' => ['required','array','min:1'],
            'numeros.*' => ['integer'],
            'minutos' => ['nullable','integer','min:5','max:60'],
            'nombre' => ['nullable','string','max:120'],
            'telefono' => ['nullable','string','max:30'],
            'email' => ['nullable','string','max:120'],
        ]);

        $minutosReserva = $data['minutos'] ?? 15;
        $user = $request->user();
        $numeros = array_unique($data['numeros']);

        if ($rifa->max_boletos_por_usuario) {
            $yaApartadosOVendidos = RifaBoleto::where('rifa_id', $rifa->rifa_id)
                ->where('user_id', $user?->id)
                ->whereIn('estado', ['apartado','vendido'])
                ->count();

            if ($yaApartadosOVendidos + count($numeros) > $rifa->max_boletos_por_usuario) {
                throw ValidationException::withMessages([
                    'numeros' => "Límite excedido. Máximo por usuario: {$rifa->max_boletos_por_usuario}",
                ]);
            }
        }

        $noDisponibles = [];

        DB::transaction(function () use ($rifa, $numeros, $user, $minutosReserva, &$noDisponibles) {
            $boletos = RifaBoleto::where('rifa_id', $rifa->rifa_id)
                ->whereIn('numero', $numeros)
                ->lockForUpdate()
                ->get()
                ->keyBy('numero');

            $vencidosLiberados = now();

            foreach ($numeros as $n) {
                $b = $boletos->get($n);
                if (!$b) { $noDisponibles[] = $n; continue; }

                $esVencido = $b->estado === 'apartado'
                          && $b->reservado_hasta
                          && $b->reservado_hasta->lt(now())
                          && $b->orden_id === null;

                if ($b->estado === 'disponible' || $esVencido) {
                    $b->estado = 'apartado';
                    $b->user_id = $user?->id;
                    $b->reservado_hasta = now()->addMinutes($minutosReserva);
                    $b->fyh_actualizacion = $vencidosLiberados;
                    $b->save();
                } else {
                    $noDisponibles[] = $n;
                }
            }
        });

        if ($noDisponibles) {
            return back()->with('error', 'Algunos números ya no están disponibles: ' . implode(', ', $noDisponibles));
        }

        return back()->with('success', 'Boletos reservados por ' . $minutosReserva . ' minutos. Completa el pago para confirmar.');
    }

    public function cancelarReserva(Rifa $rifa, Request $request)
    {
        $data = $request->validate([
            'numeros' => ['required','array','min:1'],
            'numeros.*' => ['integer'],
        ]);
        $user = $request->user();

        DB::transaction(function () use ($rifa, $data, $user) {
            $boletos = RifaBoleto::where('rifa_id', $rifa->rifa_id)
                ->whereIn('numero', $data['numeros'])
                ->lockForUpdate()
                ->get();

            foreach ($boletos as $b) {
                if ($b->estado === 'apartado' && $b->orden_id === null) {
                    if (!$user || $b->user_id === $user->id) {
                        $b->estado = 'disponible';
                        $b->user_id = null;
                        $b->reservado_hasta = null;
                        $b->fyh_actualizacion = now();
                        $b->save();
                    }
                }
            }
        });

        return back()->with('success', 'Reserva cancelada y boletos liberados.');
    }

    public function pagar(Rifa $rifa, Request $request)
    {
        $data = $request->validate([
            'numeros' => ['required','array','min:1'],
            'numeros.*' => ['integer'],
            'metodo_pago' => ['required','string','max:40'],
            'referencia_pago' => ['nullable','string','max:120'],
            'comprobante_url' => ['nullable','string','max:255'],
            'comprador_nombre' => ['nullable','string','max:120'],
            'comprador_telefono' => ['nullable','string','max:30'],
            'comprador_email' => ['nullable','string','max:120'],
        ]);

        $user = $request->user();
        $numeros = array_unique($data['numeros']);

        $ordenId = null;
        $noPagables = [];

        DB::transaction(function () use ($rifa, $numeros, $user, $data, &$ordenId, &$noPagables) {

            $boletos = RifaBoleto::where('rifa_id', $rifa->rifa_id)
                ->whereIn('numero', $numeros)
                ->lockForUpdate()
                ->get();

            $pagables = [];
            foreach ($boletos as $b) {
                $esVencido = $b->estado === 'apartado'
                          && $b->reservado_hasta
                          && $b->reservado_hasta->lt(now())
                          && $b->orden_id === null;

                if ($b->estado === 'disponible' || $esVencido || ($b->estado === 'apartado' && $b->orden_id === null)) {
                    $pagables[] = $b;
                } else {
                    $noPagables[] = $b->numero;
                }
            }
            if (count($pagables) !== count($numeros)) {
                return;
            }

            $montoTotal = count($pagables) * (float)$rifa->precio_boleto;

            $orden = RifaOrden::create([
                'rifa_id'          => $rifa->rifa_id,
                'user_id'          => $user?->id,
                'comprador_nombre' => $data['comprador_nombre'] ?? null,
                'comprador_telefono'=> $data['comprador_telefono'] ?? null,
                'comprador_email'  => $data['comprador_email'] ?? null,
                'total_boletos'    => count($pagables),
                'monto_total'      => $montoTotal,
                'metodo_pago'      => $data['metodo_pago'],
                'referencia_pago'  => $data['referencia_pago'] ?? null,
                'comprobante_url'  => $data['comprobante_url'] ?? null,
                'estatus'          => 'pagado',
                'fyh_pago'         => now(),
                'fyh_creacion'     => now(),
                'fyh_actualizacion'=> now(),
            ]);

            $ordenId = $orden->orden_id;

            foreach ($pagables as $b) {
                $b->estado = 'vendido';
                $b->orden_id = $ordenId;
                if ($user) $b->user_id = $user->id;
                $b->reservado_hasta = null;
                $b->fyh_actualizacion = now();
                $b->save();
            }
        });

        if ($noPagables) {
            return back()->with('error', 'No se pudieron pagar estos números: ' . implode(', ', $noPagables));
        }

        return redirect()->route('rifas.show', $rifa)->with('success', "Pago registrado. Orden #{$ordenId} confirmada.");
    }
}
