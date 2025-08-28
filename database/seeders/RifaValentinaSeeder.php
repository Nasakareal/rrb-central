<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RifaValentinaSeeder extends Seeder
{
    public function run(): void
    {
        // ====== Ajusta estos parámetros si lo necesitas ======
        $TITULO      = 'Rifa con causa — Valentina';
        $DESCRIPCION = "Rifa con causa, para apoyar a Valentina, quien tiene 4 meses y la operarán de un tumor en un ojito.";
        $CAUSA       = 'Apoyo a Valentina (4 meses) — cirugía de tumor ocular';
        $PRECIO      = 50.00;
        $TOTAL       = 1000;          // ← cambia si quieres más/menos boletos
        $DESDE       = 1;
        $HASTA       = $DESDE + $TOTAL - 1;
        $MAX_USER    = 20;            // null = sin límite
        $FIN_DIAS    = 30;            // vigencia: hoy + 30 días
        // Guarda tu foto de premio/portada en: storage/app/public/rifas/portadas/
        $IMAGEN      = 'storage/rifas/portadas/valentina-nice-bella.jpg';
        // ======================================================

        // 1) Crear/obtener rifa (no duplica)
        $rifa = DB::table('rifas')->where('titulo', $TITULO)->first();
        if (!$rifa) {
            $rifaId = DB::table('rifas')->insertGetId([
                'titulo'                   => $TITULO,
                'descripcion'              => $DESCRIPCION,
                'causa'                    => $CAUSA,
                'imagen'                   => $IMAGEN,
                'precio_boleto'            => $PRECIO,
                'total_boletos'            => $TOTAL,
                'numeracion_desde'         => $DESDE,
                'numeracion_hasta'         => $HASTA,
                'max_boletos_por_usuario'  => $MAX_USER,
                'fecha_inicio'             => now(),
                'fecha_fin'                => now()->copy()->addDays($FIN_DIAS),
                'estado'                   => 'activa',
                'fyh_creacion'             => now(),
                'fyh_actualizacion'        => now(),
            ]);
        } else {
            $rifaId = $rifa->rifa_id;
        }

        // 2) Generar boletos si aún no existen
        $existen = DB::table('rifa_boletos')->where('rifa_id', $rifaId)->count();
        if ($existen == 0) {
            $batch = [];
            for ($n = $DESDE; $n <= $HASTA; $n++) {
                $batch[] = [
                    'rifa_id'           => $rifaId,
                    'numero'            => $n,
                    'estado'            => 'disponible',
                    'fyh_creacion'      => now(),
                    'fyh_actualizacion' => now(),
                ];
                if (count($batch) === 1000) {
                    DB::table('rifa_boletos')->insert($batch);
                    $batch = [];
                }
            }
            if ($batch) {
                DB::table('rifa_boletos')->insert($batch);
            }
        }
    }
}
