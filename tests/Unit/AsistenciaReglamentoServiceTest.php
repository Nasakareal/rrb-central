<?php

namespace Tests\Unit;

use App\Services\AsistenciaReglamentoService;
use PHPUnit\Framework\TestCase;

class AsistenciaReglamentoServiceTest extends TestCase
{
    /** @dataProvider incidenciasDeEntrada */
    public function test_clasifica_retardos_segun_reglamento($entrada, $codigo)
    {
        $resultado = (new AsistenciaReglamentoService())->clasificarBloque('08:00:00', '16:00:00', $entrada, '16:00:00');

        $this->assertSame($codigo, $resultado[0]['codigo'] ?? null);
    }

    public function incidenciasDeEntrada()
    {
        return [
            'tolerancia' => ['08:10:00', null],
            'R1' => ['08:11:00', 'R1'],
            'R2' => ['08:21:00', 'R2'],
            'RM' => ['08:31:00', 'RM'],
            'falta' => ['09:31:00', 'FALTA'],
        ];
    }

    /** @dataProvider incidenciasDeSalida */
    public function test_clasifica_salidas_anticipadas_segun_reglamento($salida, $codigo)
    {
        $resultado = (new AsistenciaReglamentoService())->clasificarBloque('08:00:00', '16:00:00', '08:00:00', $salida);

        $this->assertSame($codigo, $resultado[0]['codigo'] ?? null);
    }

    public function incidenciasDeSalida()
    {
        return [
            'puntual' => ['16:00:00', null],
            'S1' => ['15:59:00', 'S1'],
            'S2' => ['15:49:00', 'S2'],
            'SM' => ['15:39:00', 'SM'],
        ];
    }

    public function test_una_marca_es_omision_y_ninguna_es_falta()
    {
        $servicio = new AsistenciaReglamentoService();

        $this->assertSame('OES', $servicio->clasificarBloque('08:00:00', '16:00:00', '08:00:00', null)[0]['codigo']);
        $this->assertSame('FALTA', $servicio->clasificarBloque('08:00:00', '16:00:00', null, null)[0]['codigo']);
    }
}
