<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\PoleoImportado;
use App\Models\Puesto;
use App\Services\BioSyncImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BioSyncWebController extends Controller
{
    private $importador;

    public function __construct(BioSyncImportService $importador)
    {
        $this->importador = $importador;
    }

    public function index()
    {
        return view('biosync.index', [
            'biosyncConfig' => [
                'resumen' => route('biosync.resumen'),
                'asistencias' => route('biosync.asistencias'),
                'importaciones' => route('biosync.importaciones'),
                'importar' => route('biosync.importar'),
                'empleados' => route('biosync.empleados'),
                'reportes' => route('biosync.reportes'),
                'catalogos' => route('biosync.catalogos'),
                'usuarios' => route('biosync.usuarios'),
            ],
        ]);
    }

    public function resumen()
    {
        return response()->json([
            'data' => [
                'conexion' => 'Conectado',
                'asistencias' => Asistencia::count(),
                'empleados' => Empleado::count(),
                'ultima_importacion' => optional(PoleoImportado::latest()->first())->created_at,
                'recientes' => $this->consultaAsistencias()->limit(20)->get(),
            ],
        ]);
    }

    public function asistencias(Request $request)
    {
        $perPage = max(1, min((int) $request->input('per_page', 100), 100));
        $query = $this->consultaAsistencias();
        $this->aplicarRangoFechas($query, $request);

        return response()->json(['data' => $query->paginate($perPage)]);
    }

    public function importaciones(Request $request)
    {
        $perPage = max(1, min((int) $request->input('per_page', 100), 100));

        return response()->json([
            'data' => PoleoImportado::latest()->paginate($perPage),
        ]);
    }

    public function importar(Request $request)
    {
        $data = $request->validate($this->reglasImportacion());
        $resultado = $this->importador->importar($data);

        return response()->json([
            'message' => $resultado['importadas'] > 0
                ? 'Poleo importado correctamente.'
                : 'El archivo ya estaba importado; no se duplicaron registros.',
            'data' => $resultado,
        ], $resultado['importadas'] > 0 ? 201 : 200);
    }

    public function empleados(Request $request)
    {
        $perPage = max(1, min((int) $request->input('per_page', 100), 100));
        $query = Empleado::with(['campus', 'departamento', 'puesto'])
            ->orderBy('nombre')
            ->orderBy('numero_reloj');

        if ($request->filled('buscar')) {
            $buscar = '%' . trim($request->input('buscar')) . '%';
            $query->where(function ($q) use ($buscar) {
                $q->where('numero_reloj', 'like', $buscar)
                    ->orWhere('numero_empleado', 'like', $buscar)
                    ->orWhere('nombre', 'like', $buscar)
                    ->orWhere('correo', 'like', $buscar)
                    ->orWhereHas('departamento', function ($departamento) use ($buscar) {
                        $departamento->where('nombre', 'like', $buscar);
                    })
                    ->orWhereHas('puesto', function ($puesto) use ($buscar) {
                        $puesto->where('nombre', 'like', $buscar);
                    });
            });
        }

        return response()->json(['data' => $query->paginate($perPage)]);
    }

    public function guardarEmpleado(Request $request, Empleado $empleado = null)
    {
        $empleadoId = $empleado ? $empleado->id : null;
        $data = $request->validate([
            'numero_reloj' => ['required', 'string', 'max:50', Rule::unique('empleados', 'numero_reloj')->ignore($empleadoId)],
            'nombre' => ['nullable', 'string', 'max:150'],
            'departamento' => ['nullable', 'string', 'max:150'],
            'puesto' => ['nullable', 'string', 'max:150'],
            'correo' => ['nullable', 'email', 'max:190'],
            'estatus' => ['required', Rule::in(['activo', 'inactivo'])],
        ]);

        $departamentoId = null;
        if (!empty($data['departamento'])) {
            $departamentoId = Departamento::firstOrCreate(
                ['nombre' => trim($data['departamento'])],
                ['activo' => true]
            )->id;
        }

        $puestoId = null;
        if (!empty($data['puesto'])) {
            $puestoId = Puesto::firstOrCreate(
                ['nombre' => trim($data['puesto'])],
                ['activo' => true]
            )->id;
        }

        $atributos = [
            'numero_reloj' => trim($data['numero_reloj']),
            'nombre' => isset($data['nombre']) ? $data['nombre'] : null,
            'departamento_id' => $departamentoId,
            'puesto_id' => $puestoId,
            'correo' => isset($data['correo']) ? $data['correo'] : null,
            'estatus' => $data['estatus'],
        ];

        if ($empleado) {
            $empleado->update($atributos);
            $status = 200;
            $message = 'Empleado actualizado correctamente.';
        } else {
            $empleado = Empleado::create($atributos);
            $status = 201;
            $message = 'Empleado registrado correctamente.';
        }

        return response()->json([
            'message' => $message,
            'data' => $empleado->load(['campus', 'departamento', 'puesto']),
        ], $status);
    }

    public function reportes(Request $request)
    {
        $request->validate([
            'desde' => ['required', 'date_format:Y-m-d'],
            'hasta' => ['required', 'date_format:Y-m-d', 'after_or_equal:desde'],
        ]);

        $resumen = Asistencia::query()
            ->whereDate('fecha', '>=', $request->input('desde'))
            ->whereDate('fecha', '<=', $request->input('hasta'))
            ->selectRaw('fecha')
            ->selectRaw('COUNT(*) as registros')
            ->selectRaw('COUNT(DISTINCT empleado_id) as empleados')
            ->selectRaw('SUM(CASE WHEN salida IS NULL THEN 1 ELSE 0 END) as incompletos')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return response()->json(['data' => $resumen]);
    }

    public function catalogos()
    {
        return response()->json([
            'data' => [
                'departamentos' => Departamento::where('activo', true)->orderBy('nombre')->pluck('nombre'),
                'puestos' => Puesto::where('activo', true)->orderBy('nombre')->pluck('nombre'),
            ],
        ]);
    }

    private function consultaAsistencias()
    {
        return Asistencia::with(['empleado.departamento', 'empleado.puesto'])
            ->orderByDesc('fecha')
            ->orderBy('entrada');
    }

    private function aplicarRangoFechas($query, Request $request): void
    {
        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->input('desde'));
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->input('hasta'));
        }
    }

    private function reglasImportacion(): array
    {
        return [
            'archivo' => ['required', 'string', 'max:255'],
            'hash' => ['required', 'string', 'max:128'],
            'registros' => ['required', 'array', 'min:1', 'max:20000'],
            'registros.*.numero_reloj' => ['required', 'string', 'max:50'],
            'registros.*.fecha' => ['required', 'date_format:Y-m-d'],
            'registros.*.entrada' => ['required', 'date_format:H:i:s'],
            'registros.*.salida' => ['nullable', 'date_format:H:i:s'],
            'registros.*.marcas' => ['required', 'integer', 'min:1'],
            'registros.*.observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
