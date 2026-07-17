<?php

namespace App\Services;

use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\PoleoImportado;
use Illuminate\Support\Facades\DB;

class BioSyncImportService
{
    public function importar(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $poleo = PoleoImportado::firstOrCreate(
                ['hash_archivo' => $data['hash']],
                [
                    'nombre_archivo' => $data['archivo'],
                    'total_registros' => count($data['registros']),
                ]
            );

            $importadas = 0;
            $duplicadas = 0;

            foreach ($data['registros'] as $registro) {
                $empleado = Empleado::firstOrCreate(
                    ['numero_reloj' => $registro['numero_reloj']],
                    [
                        'numero_empleado' => isset($registro['numero_empleado']) ? $registro['numero_empleado'] : null,
                        'nombre' => isset($registro['nombre']) ? $registro['nombre'] : null,
                        'apellido_paterno' => isset($registro['apellido_paterno']) ? $registro['apellido_paterno'] : null,
                        'apellido_materno' => isset($registro['apellido_materno']) ? $registro['apellido_materno'] : null,
                        'campus_id' => isset($registro['campus_id']) ? $registro['campus_id'] : null,
                        'departamento_id' => isset($registro['departamento_id']) ? $registro['departamento_id'] : null,
                        'puesto_id' => isset($registro['puesto_id']) ? $registro['puesto_id'] : null,
                    ]
                );

                if (!$empleado->wasRecentlyCreated) {
                    $this->completarDatosEmpleado($empleado, $registro);
                }

                $salida = isset($registro['salida']) && $registro['salida'] !== ''
                    ? $registro['salida']
                    : null;
                $llaveRegistro = sha1(implode('|', [
                    $empleado->id,
                    $registro['fecha'],
                    $registro['entrada'],
                    $salida ?: '',
                ]));

                $asistencia = Asistencia::firstOrCreate(
                    ['llave_registro' => $llaveRegistro],
                    [
                        'empleado_id' => $empleado->id,
                        'fecha' => $registro['fecha'],
                        'entrada' => $registro['entrada'],
                        'salida' => $salida,
                        'total_marcas' => $registro['marcas'],
                        'observaciones' => isset($registro['observaciones']) ? $registro['observaciones'] : null,
                        'archivo_origen' => $data['archivo'],
                    ]
                );

                if ($asistencia->wasRecentlyCreated) {
                    $importadas++;
                } else {
                    $duplicadas++;
                }
            }

            return [
                'archivo_duplicado' => !$poleo->wasRecentlyCreated,
                'total_registros' => count($data['registros']),
                'importadas' => $importadas,
                'duplicadas' => $duplicadas,
            ];
        });
    }

    private function completarDatosEmpleado(Empleado $empleado, array $registro): void
    {
        $campos = [
            'numero_empleado',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'campus_id',
            'departamento_id',
            'puesto_id',
        ];
        $updates = [];

        foreach ($campos as $campo) {
            if (empty($empleado->{$campo}) && !empty($registro[$campo])) {
                $updates[$campo] = $registro[$campo];
            }
        }

        if (!empty($updates)) {
            $empleado->update($updates);
        }
    }
}
