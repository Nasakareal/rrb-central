<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\RelojMarca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelojMarcaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'dispositivo' => ['nullable', 'array'],
            'dispositivo.id' => ['nullable', 'string', 'max:120'],
            'dispositivo.serial' => ['nullable', 'string', 'max:120'],
            'dispositivo.ip' => ['nullable', 'ip'],
            'dispositivo.numero_maquina' => ['nullable', 'integer', 'min:1'],
            'marcas' => ['required', 'array', 'min:1', 'max:500'],
            'marcas.*.clave' => ['required', 'string', 'size:64'],
            'marcas.*.numero_reloj' => ['required', 'string', 'max:50'],
            'marcas.*.fecha_hora' => ['required', 'date_format:Y-m-d H:i:s'],
            'marcas.*.modo_verificacion' => ['nullable', 'integer'],
            'marcas.*.modo_entrada_salida' => ['nullable', 'integer'],
            'marcas.*.codigo_trabajo' => ['nullable', 'integer'],
        ]);

        $result = DB::transaction(function () use ($data) {
            $inserted = 0;
            $duplicates = 0;
            $days = [];
            $device = $data['dispositivo'] ?? [];

            foreach ($data['marcas'] as $mark) {
                $number = trim((string) $mark['numero_reloj']);
                $timestamp = Carbon::createFromFormat('Y-m-d H:i:s', $mark['fecha_hora']);
                $row = RelojMarca::firstOrCreate(
                    ['clave' => strtolower($mark['clave'])],
                    [
                        'dispositivo_id' => $device['id'] ?? null,
                        'dispositivo_serial' => $device['serial'] ?? null,
                        'dispositivo_ip' => $device['ip'] ?? null,
                        'numero_reloj' => $number,
                        'fecha_hora' => $timestamp,
                        'modo_verificacion' => $mark['modo_verificacion'] ?? null,
                        'modo_entrada_salida' => $mark['modo_entrada_salida'] ?? null,
                        'codigo_trabajo' => $mark['codigo_trabajo'] ?? null,
                    ]
                );

                $row->wasRecentlyCreated ? $inserted++ : $duplicates++;
                $days[$number . '|' . $timestamp->toDateString()] = [$number, $timestamp->toDateString()];
            }

            foreach ($days as [$number, $date]) {
                $this->rebuildAttendance($number, $date);
            }

            return [
                'recibidas' => count($data['marcas']),
                'insertadas' => $inserted,
                'duplicadas' => $duplicates,
                'asistencias_actualizadas' => count($days),
            ];
        });

        return response()->json([
            'message' => 'Poleadas del reloj procesadas correctamente.',
            'data' => $result,
        ], $result['insertadas'] > 0 ? 201 : 200);
    }

    private function rebuildAttendance(string $number, string $date): void
    {
        $employee = Empleado::firstOrCreate(['numero_reloj' => $number]);
        $query = RelojMarca::query()
            ->where('numero_reloj', $number)
            ->whereDate('fecha_hora', $date);
        $count = (clone $query)->count();
        $first = (clone $query)->min('fecha_hora');
        $last = (clone $query)->max('fecha_hora');

        if (!$first || !$last || $count === 0) {
            return;
        }

        $entry = Carbon::parse($first)->format('H:i:s');
        $exit = $count > 1 ? Carbon::parse($last)->format('H:i:s') : null;
        $recordKey = sha1('reloj|' . $employee->id . '|' . $date);

        Asistencia::updateOrCreate(
            ['llave_registro' => $recordKey],
            [
                'empleado_id' => $employee->id,
                'fecha' => $date,
                'entrada' => $entry,
                'salida' => $exit,
                'total_marcas' => $count,
                'observaciones' => $count === 1 ? 'Registro incompleto' : null,
                'archivo_origen' => 'reloj:auto',
            ]
        );
    }
}