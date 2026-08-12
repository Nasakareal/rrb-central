<?php

namespace Tests\Feature;

use App\Models\AsistenciaJustificacion;
use App\Models\Empleado;
use App\Models\EmpleadoHorario;
use App\Models\Horario;
use App\Models\RelojMarca;
use App\Services\AsistenciaReglamentoService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AsistenciaReglamentoIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_salida_anticipada_justificada_deja_de_generar_descuento_sugerido()
    {
        $empleado = Empleado::create([
            'numero_reloj' => 'TEST-REG-' . uniqid(),
            'nombre' => 'Docente de prueba',
            'tipo_personal' => 'docente',
            'estatus' => 'activo',
        ]);
        $horario = Horario::create([
            'nombre' => 'Bloque de prueba',
            'hora_entrada' => '08:00:00',
            'hora_salida' => '10:00:00',
            'dias_semana' => '2',
            'activo' => true,
        ]);
        EmpleadoHorario::create([
            'empleado_id' => $empleado->id,
            'horario_id' => $horario->id,
            'fecha_inicio' => '2026-08-11',
            'activo' => true,
        ]);
        RelojMarca::create([
            'clave' => hash('sha256', uniqid('entrada', true)),
            'numero_reloj' => $empleado->numero_reloj,
            'fecha_hora' => '2026-08-11 08:00:00',
        ]);
        RelojMarca::create([
            'clave' => hash('sha256', uniqid('salida', true)),
            'numero_reloj' => $empleado->numero_reloj,
            'fecha_hora' => '2026-08-11 09:30:00',
        ]);

        $servicio = app(AsistenciaReglamentoService::class);
        $antes = $servicio->reporte('2026-08-11', '2026-08-11');
        $this->assertSame('SM', $antes['incidencias'][0]['codigo']);
        $this->assertSame(.25, $antes['resumen'][0]['dias_descuento_sugerido']);

        AsistenciaJustificacion::create([
            'empleado_id' => $empleado->id,
            'horario_id' => $horario->id,
            'fecha' => '2026-08-11',
            'codigo_incidencia' => 'SM',
            'tipo_justificacion' => 'pase_salida',
            'descripcion' => 'Pase autorizado por la jefatura inmediata.',
            'estado' => 'aprobada',
            'evita_descuento' => true,
            'origen' => 'prueba',
        ]);

        $despues = $servicio->reporte('2026-08-11', '2026-08-11');
        $this->assertTrue($despues['incidencias'][0]['justificada']);
        $this->assertSame(0.0, $despues['resumen'][0]['dias_descuento_sugerido']);
    }
}
