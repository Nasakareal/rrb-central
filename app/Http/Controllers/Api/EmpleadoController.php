<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\EmpleadoHorario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(1, min((int) $request->input('per_page', 50), 100));

        $query = Empleado::with(['campus', 'departamento', 'puesto'])
            ->orderBy('nombre')
            ->orderBy('numero_reloj');

        if ($request->filled('buscar')) {
            $buscar = '%' . $request->input('buscar') . '%';

            $query->where(function ($q) use ($buscar) {
                $q->where('numero_reloj', 'like', $buscar)
                    ->orWhere('numero_empleado', 'like', $buscar)
                    ->orWhere('nombre', 'like', $buscar)
                    ->orWhere('apellido_paterno', 'like', $buscar)
                    ->orWhere('apellido_materno', 'like', $buscar);
            });
        }

        return response()->json([
            'data' => $query->paginate($perPage),
        ]);
    }

    public function store(Request $request)
    {
        $empleado = Empleado::where('numero_reloj', $request->input('numero_reloj'))->first();
        $data = $this->validatedData($request, $empleado);

        if ($empleado) {
            $empleado->update($data);

            return response()->json([
                'message' => 'Empleado actualizado correctamente.',
                'data' => $empleado->load(['campus', 'departamento', 'puesto']),
            ]);
        }

        $empleado = Empleado::create($data);

        return response()->json([
            'message' => 'Empleado registrado correctamente.',
            'data' => $empleado->load(['campus', 'departamento', 'puesto']),
        ], 201);
    }

    public function show(Empleado $empleado)
    {
        return response()->json([
            'data' => $empleado->load(['campus', 'departamento', 'puesto', 'horarios']),
        ]);
    }

    public function update(Request $request, Empleado $empleado)
    {
        $empleado->update($this->validatedData($request, $empleado));

        return response()->json([
            'message' => 'Empleado actualizado correctamente.',
            'data' => $empleado->load(['campus', 'departamento', 'puesto']),
        ]);
    }

    public function asignarHorario(Request $request, Empleado $empleado)
    {
        $data = $request->validate([
            'horario_id' => ['required', 'integer', 'exists:horarios,id'],
            'fecha_inicio' => ['required', 'date_format:Y-m-d'],
            'fecha_fin' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:fecha_inicio'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $empleadoHorario = EmpleadoHorario::updateOrCreate(
            [
                'empleado_id' => $empleado->id,
                'horario_id' => $data['horario_id'],
                'fecha_inicio' => $data['fecha_inicio'],
            ],
            [
                'fecha_fin' => $data['fecha_fin'] ?? null,
                'activo' => $data['activo'] ?? true,
            ]
        );

        return response()->json([
            'message' => 'Horario asignado correctamente.',
            'data' => $empleadoHorario->load(['empleado', 'horario']),
        ], $empleadoHorario->wasRecentlyCreated ? 201 : 200);
    }

    private function validatedData(Request $request, Empleado $empleado = null): array
    {
        $empleadoId = $empleado ? $empleado->id : null;

        $data = $request->validate([
            'numero_reloj' => [
                'required',
                'string',
                'max:50',
                Rule::unique('empleados', 'numero_reloj')->ignore($empleadoId),
            ],
            'numero_empleado' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('empleados', 'numero_empleado')->ignore($empleadoId),
            ],
            'nombre' => ['nullable', 'string', 'max:150'],
            'apellido_paterno' => ['nullable', 'string', 'max:100'],
            'apellido_materno' => ['nullable', 'string', 'max:100'],
            'campus_id' => ['nullable', 'integer', 'exists:campus,id'],
            'departamento_id' => ['nullable', 'integer', 'exists:departamentos,id'],
            'puesto_id' => ['nullable', 'integer', 'exists:puestos,id'],
            'estatus' => ['nullable', Rule::in(['activo', 'inactivo', 'baja'])],
            'fecha_ingreso' => ['nullable', 'date_format:Y-m-d'],
        ]);

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }
}
