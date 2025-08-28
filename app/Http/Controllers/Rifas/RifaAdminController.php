<?php

namespace App\Http\Controllers\Rifas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rifa;
use App\Models\RifaBoleto;

class RifaAdminController extends Controller
{
    // GET admin/rifas
    public function index()
    {
        $rifas = Rifa::orderByDesc('fyh_creacion')->get();
        return view('admin.rifas.index', compact('rifas'));
    }

    // GET admin/rifas/create
    public function create()
    {
        return view('admin.rifas.create');
    }

    // POST admin/rifas
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'causa' => 'nullable|string|max:200',
            'precio_boleto' => 'required|numeric|min:1',
            'total_boletos' => 'required|integer|min:1',
            'numeracion_desde' => 'required|integer|min:0',
            'numeracion_hasta' => 'required|integer|gte:numeracion_desde',
            'max_boletos_por_usuario' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:borrador,activa,pausada,cerrada,sorteada',
        ]);

        $rifa = Rifa::create(array_merge($data, [
            'fyh_creacion' => now(),
            'fyh_actualizacion' => now(),
        ]));

        return redirect()->route('admin.rifas.edit', $rifa)->with('success', 'Rifa creada.');
    }

    // GET admin/rifas/{rifa}/edit
    public function edit(Rifa $rifa)
    {
        return view('admin.rifas.edit', compact('rifa'));
    }

    // PUT admin/rifas/{rifa}
    public function update(Request $request, Rifa $rifa)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'causa' => 'nullable|string|max:200',
            'precio_boleto' => 'required|numeric|min:1',
            'total_boletos' => 'required|integer|min:1',
            'numeracion_desde' => 'required|integer|min:0',
            'numeracion_hasta' => 'required|integer|gte:numeracion_desde',
            'max_boletos_por_usuario' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:borrador,activa,pausada,cerrada,sorteada',
        ]);

        $rifa->update(array_merge($data, ['fyh_actualizacion' => now()]));

        return back()->with('success', 'Rifa actualizada.');
    }

    // DELETE admin/rifas/{rifa}
    public function destroy(Rifa $rifa)
    {
        $rifa->delete();
        return redirect()->route('admin.rifas.index')->with('success', 'Rifa eliminada.');
    }

    // POST admin/rifas/{rifa}/generar-boletos
    public function generarBoletos(Rifa $rifa)
    {
        $desde = (int)$rifa->numeracion_desde;
        $hasta = (int)$rifa->numeracion_hasta;

        DB::transaction(function () use ($rifa, $desde, $hasta) {
            $existen = RifaBoleto::where('rifa_id', $rifa->rifa_id)->count();
            if ($existen > 0) return;

            $lote = [];
            $ahora = now();

            for ($n = $desde; $n <= $hasta; $n++) {
                $lote[] = [
                    'rifa_id' => $rifa->rifa_id,
                    'numero'  => $n,
                    'estado'  => 'disponible',
                    'fyh_creacion' => $ahora,
                    'fyh_actualizacion' => $ahora,
                ];
                if (count($lote) === 1000) {
                    DB::table('rifa_boletos')->insert($lote);
                    $lote = [];
                }
            }
            if ($lote) DB::table('rifa_boletos')->insert($lote);
        });

        return back()->with('success', 'Boletos generados.');
    }

    // POST admin/rifas/{rifa}/pausar
    public function pausar(Rifa $rifa)
    {
        $rifa->update(['estado' => 'pausada', 'fyh_actualizacion' => now()]);
        return back()->with('success', 'Rifa pausada.');
    }

    // POST admin/rifas/{rifa}/cerrar
    public function cerrar(Rifa $rifa)
    {
        $rifa->update(['estado' => 'cerrada', 'fyh_actualizacion' => now()]);
        return back()->with('success', 'Rifa cerrada. Ahora puedes sortear.');
    }

    // POST admin/rifas/{rifa}/sortear
    public function sortear(Rifa $rifa)
    {
        if ($rifa->estado !== 'cerrada') {
            return back()->with('error', 'Para sortear, la rifa debe estar CERRADA.');
        }

        $ganador = RifaBoleto::where('rifa_id', $rifa->rifa_id)
            ->where('estado', 'vendido')
            ->inRandomOrder()
            ->first();

        if (!$ganador) {
            return back()->with('error', 'No hay boletos vendidos para sortear.');
        }

        $rifa->update([
            'ganador_boleto_id' => $ganador->rifa_boleto_id,
            'ganador_user_id'   => $ganador->user_id,
            'estado'            => 'sorteada',
            'fyh_actualizacion' => now(),
        ]);

        return back()->with('success', 'Sorteo realizado. Boleto ganador: #' . $ganador->numero);
    }
}
