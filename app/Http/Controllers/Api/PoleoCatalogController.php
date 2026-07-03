<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Departamento;
use App\Models\Horario;
use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PoleoCatalogController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'campus' => Campus::orderBy('nombre')->get(),
                'departamentos' => Departamento::with('campus')->orderBy('nombre')->get(),
                'puestos' => Puesto::orderBy('nombre')->get(),
                'horarios' => Horario::orderBy('nombre')->get(),
            ],
        ]);
    }

    public function storeCampus(Request $request)
    {
        $campus = Campus::create($this->sinNulos($request->validate([
            'clave' => ['nullable', 'string', 'max:30', Rule::unique('campus', 'clave')],
            'nombre' => ['required', 'string', 'max:150'],
            'activo' => ['nullable', 'boolean'],
        ])));

        return response()->json([
            'message' => 'Campus registrado correctamente.',
            'data' => $campus,
        ], 201);
    }

    public function storeDepartamento(Request $request)
    {
        $departamento = Departamento::create($this->sinNulos($request->validate([
            'campus_id' => ['nullable', 'integer', 'exists:campus,id'],
            'nombre' => ['required', 'string', 'max:150'],
            'activo' => ['nullable', 'boolean'],
        ])));

        return response()->json([
            'message' => 'Departamento registrado correctamente.',
            'data' => $departamento->load('campus'),
        ], 201);
    }

    public function storePuesto(Request $request)
    {
        $puesto = Puesto::create($this->sinNulos($request->validate([
            'nombre' => ['required', 'string', 'max:150', Rule::unique('puestos', 'nombre')],
            'activo' => ['nullable', 'boolean'],
        ])));

        return response()->json([
            'message' => 'Puesto registrado correctamente.',
            'data' => $puesto,
        ], 201);
    }

    public function storeHorario(Request $request)
    {
        $horario = Horario::create($this->sinNulos($request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'hora_entrada' => ['required', 'date_format:H:i:s'],
            'hora_salida' => ['required', 'date_format:H:i:s'],
            'tolerancia_entrada_minutos' => ['nullable', 'integer', 'min:0', 'max:1440'],
            'tolerancia_salida_minutos' => ['nullable', 'integer', 'min:0', 'max:1440'],
            'activo' => ['nullable', 'boolean'],
        ])));

        return response()->json([
            'message' => 'Horario registrado correctamente.',
            'data' => $horario,
        ], 201);
    }

    private function sinNulos(array $data): array
    {
        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }
}
