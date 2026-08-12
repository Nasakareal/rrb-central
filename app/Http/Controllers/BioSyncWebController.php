<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\PoleoImportado;
use App\Models\Puesto;
use App\Models\Horario;
use App\Models\EmpleadoHorario;
use App\Services\BioSyncImportService;
use App\Services\AsistenciaReglamentoService;
use App\Http\Controllers\Api\AsistenciaIncidenciaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BioSyncWebController extends Controller
{
    private $importador;
    private $reglamento;

    public function __construct(BioSyncImportService $importador, AsistenciaReglamentoService $reglamento)
    {
        $this->importador = $importador;
        $this->reglamento = $reglamento;
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
                'justificaciones' => route('biosync.justificaciones.store'),
                'horarios' => route('biosync.horarios.store'),
                'asignarHorarioBase' => url('/biosync-utm/empleados'),
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
        $query = Empleado::with(['campus', 'departamento', 'puesto', 'horarios'])
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
            'tipo_personal' => ['required', Rule::in(['administrativo', 'docente', 'confianza', 'otro'])],
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
            'tipo_personal' => $data['tipo_personal'],
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

        $reporte = $this->reglamento->reporte($request->input('desde'), $request->input('hasta'));

        return response()->json([
            'data' => $reporte['incidencias'],
            'resumen' => $reporte['resumen'],
            'advertencia' => $reporte['advertencia'],
        ]);
    }

    public function guardarJustificacion(Request $request)
    {
        $gestor = app(AsistenciaIncidenciaController::class);
        $data = $gestor->validarJustificacion($request);
        $data['justificada_por'] = $request->user()->id;
        $data['origen'] = 'web';
        $justificacion = $gestor->guardar($data);

        return response()->json([
            'message' => 'Justificación aprobada. La incidencia dejó de contar para el descuento sugerido.',
            'data' => $justificacion,
        ], $justificacion->wasRecentlyCreated ? 201 : 200);
    }

    public function guardarHorario(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'hora_entrada' => ['required', 'date_format:H:i'],
            'hora_salida' => ['required', 'date_format:H:i', 'after:hora_entrada'],
            'dias_semana' => ['required', 'regex:/^[1-7](,[1-7])*$/'],
        ]);
        $data['hora_entrada'] .= ':00';
        $data['hora_salida'] .= ':00';
        $data['activo'] = true;
        $horario = Horario::create($data);

        return response()->json(['message' => 'Bloque horario creado.', 'data' => $horario], 201);
    }

    public function asignarHorario(Request $request, Empleado $empleado)
    {
        $data = $request->validate([
            'horario_id' => ['required', 'integer', 'exists:horarios,id'],
            'fecha_inicio' => ['required', 'date_format:Y-m-d'],
            'fecha_fin' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:fecha_inicio'],
        ]);
        $asignacion = EmpleadoHorario::updateOrCreate(
            [
                'empleado_id' => $empleado->id,
                'horario_id' => $data['horario_id'],
                'fecha_inicio' => $data['fecha_inicio'],
            ],
            ['fecha_fin' => $data['fecha_fin'] ?? null, 'activo' => true]
        );

        return response()->json(['message' => 'Bloque asignado al empleado.', 'data' => $asignacion], $asignacion->wasRecentlyCreated ? 201 : 200);
    }

    public function catalogos()
    {
        return response()->json([
            'data' => [
                'departamentos' => Departamento::where('activo', true)->orderBy('nombre')->pluck('nombre'),
                'puestos' => Puesto::where('activo', true)->orderBy('nombre')->pluck('nombre'),
                'horarios' => Horario::where('activo', true)->orderBy('nombre')->get(),
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
            'marcas_detalle' => ['nullable', 'array', 'max:100000'],
            'marcas_detalle.*.numero_reloj' => ['required', 'string', 'max:50'],
            'marcas_detalle.*.fecha_hora' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
