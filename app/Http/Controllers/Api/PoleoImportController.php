<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\PoleoImportado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoleoImportController extends Controller
{
    public function store(Request $request)
    {
        $this->normalizarPayload($request);

        $data = $request->validate([
            'archivo' => ['required', 'string', 'max:255'],
            'hash' => ['required', 'string', 'max:128'],
            'registros' => ['required', 'array', 'min:1'],
            'registros.*.numero_reloj' => ['required', 'string', 'max:50'],
            'registros.*.empleado' => ['nullable', 'string', 'max:50'],
            'registros.*.nombre' => ['nullable', 'string', 'max:150'],
            'registros.*.campus_id' => ['nullable', 'integer', 'min:1'],
            'registros.*.fecha' => ['required', 'date_format:Y-m-d'],
            'registros.*.entrada' => ['required', 'date_format:H:i:s'],
            'registros.*.salida' => ['nullable', 'date_format:H:i:s'],
            'registros.*.marcas' => ['required', 'integer', 'min:1'],
            'registros.*.observaciones' => ['nullable', 'string'],
        ]);

        $resultado = DB::transaction(function () use ($data) {
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
                        'nombre' => $registro['nombre'] ?? null,
                        'campus_id' => $registro['campus_id'] ?? null,
                    ]
                );

                if (!$empleado->wasRecentlyCreated) {
                    $updates = [];

                    if (empty($empleado->nombre) && !empty($registro['nombre'])) {
                        $updates['nombre'] = $registro['nombre'];
                    }

                    if (empty($empleado->campus_id) && !empty($registro['campus_id'])) {
                        $updates['campus_id'] = $registro['campus_id'];
                    }

                    if (!empty($updates)) {
                        $empleado->update($updates);
                    }
                }

                $asistencia = Asistencia::firstOrCreate(
                    [
                        'empleado_id' => $empleado->id,
                        'fecha' => $registro['fecha'],
                        'entrada' => $registro['entrada'],
                        'salida' => $registro['salida'] ?? null,
                    ],
                    [
                        'total_marcas' => $registro['marcas'],
                        'observaciones' => $registro['observaciones'] ?? null,
                        'archivo_origen' => $data['archivo'],
                    ]
                );

                $asistencia->wasRecentlyCreated ? $importadas++ : $duplicadas++;
            }

            return [
                'archivo_duplicado' => !$poleo->wasRecentlyCreated,
                'total_registros' => count($data['registros']),
                'importadas' => $importadas,
                'duplicadas' => $duplicadas,
            ];
        });

        return response()->json([
            'message' => 'Poleo importado correctamente.',
            'data' => $resultado,
        ], $resultado['importadas'] > 0 ? 201 : 200);
    }

    private function normalizarPayload(Request $request): void
    {
        $registros = $request->input('registros', []);

        if (is_array($registros)) {
            foreach ($registros as $indice => $registro) {
                if (!is_array($registro)) {
                    continue;
                }

                if (empty($registro['numero_reloj']) && !empty($registro['empleado'])) {
                    $registro['numero_reloj'] = $registro['empleado'];
                }

                if (isset($registro['numero_reloj'])) {
                    $registro['numero_reloj'] = trim((string) $registro['numero_reloj']);
                }

                if (isset($registro['empleado'])) {
                    $registro['empleado'] = trim((string) $registro['empleado']);
                }

                if (isset($registro['fecha'])) {
                    $registro['fecha'] = $this->normalizarFecha($registro['fecha']);
                }

                if (isset($registro['entrada'])) {
                    $registro['entrada'] = trim((string) $registro['entrada']);
                }

                if (array_key_exists('salida', $registro)) {
                    $registro['salida'] = trim((string) $registro['salida']);
                    $registro['salida'] = $registro['salida'] === '' ? null : $registro['salida'];
                }

                if (array_key_exists('observaciones', $registro)) {
                    $registro['observaciones'] = trim((string) $registro['observaciones']);
                    $registro['observaciones'] = $registro['observaciones'] === '' ? null : $registro['observaciones'];
                }

                $registros[$indice] = $registro;
            }
        }

        $payload = ['registros' => $registros];

        if (!$request->filled('hash')) {
            $payload['hash'] = sha1(json_encode([
                'archivo' => $request->input('archivo'),
                'registros' => $registros,
            ]));
        }

        $request->merge($payload);
    }

    private function normalizarFecha($fecha)
    {
        if (!is_string($fecha)) {
            return $fecha;
        }

        $fecha = trim($fecha);

        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $fecha) !== 1) {
            return $fecha;
        }

        $date = \DateTime::createFromFormat('d/m/Y', $fecha);
        $errors = \DateTime::getLastErrors();

        if (!$date || ($errors && ((int) $errors['warning_count'] > 0 || (int) $errors['error_count'] > 0))) {
            return $fecha;
        }

        return $date->format('Y-m-d');
    }
}
