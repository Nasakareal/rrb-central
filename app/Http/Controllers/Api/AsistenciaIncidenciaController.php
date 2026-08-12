<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsistenciaJustificacion;
use App\Services\AsistenciaReglamentoService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsistenciaIncidenciaController extends Controller
{
    private $reglamento;

    public function __construct(AsistenciaReglamentoService $reglamento)
    {
        $this->reglamento = $reglamento;
    }

    public function index(Request $request)
    {
        $data = $request->validate([
            'desde' => ['required', 'date_format:Y-m-d'],
            'hasta' => ['required', 'date_format:Y-m-d', 'after_or_equal:desde'],
        ]);
        $reporte = $this->reglamento->reporte($data['desde'], $data['hasta']);

        return response()->json([
            'data' => $reporte['incidencias'],
            'resumen' => $reporte['resumen'],
            'advertencia' => $reporte['advertencia'],
        ]);
    }

    public function resumen(Request $request)
    {
        $data = $request->validate([
            'desde' => ['required', 'date_format:Y-m-d'],
            'hasta' => ['required', 'date_format:Y-m-d', 'after_or_equal:desde'],
        ]);
        $reporte = $this->reglamento->reporte($data['desde'], $data['hasta']);

        return response()->json([
            'data' => $reporte['resumen'],
            'advertencia' => $reporte['advertencia'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validarJustificacion($request);
        $data['origen'] = 'app';
        $justificacion = $this->guardar($data);

        return response()->json([
            'message' => 'Justificación guardada. La incidencia no se incluirá en el descuento sugerido.',
            'data' => $justificacion,
        ], $justificacion->wasRecentlyCreated ? 201 : 200);
    }

    public static function reglasJustificacion(): array
    {
        return [
            'empleado_id' => ['required', 'integer', 'exists:empleados,id'],
            'asistencia_id' => ['nullable', 'integer', 'exists:asistencias,id'],
            'horario_id' => ['required', 'integer', 'exists:horarios,id'],
            'fecha' => ['required', 'date_format:Y-m-d'],
            'codigo_incidencia' => ['required', Rule::in(['R1', 'R2', 'RM', 'S1', 'S2', 'SM', 'OES', 'FALTA'])],
            'tipo_justificacion' => ['required', Rule::in([
                'incapacidad_imss', 'atencion_medica_hijo', 'receta_imss', 'comision_oficial',
                'pase_salida', 'permiso_economico', 'defuncion', 'omision_reloj',
                'permiso_maternidad', 'otra_ley_laboral',
            ])],
            'descripcion' => ['required', 'string', 'max:2000'],
            'documento_referencia' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', Rule::in(['aprobada', 'rechazada'])],
            'evita_descuento' => ['nullable', 'boolean'],
        ];
    }

    public function validarJustificacion(Request $request): array
    {
        return $request->validate(self::reglasJustificacion());
    }

    public function guardar(array $data): AsistenciaJustificacion
    {
        return AsistenciaJustificacion::updateOrCreate(
            [
                'empleado_id' => $data['empleado_id'],
                'fecha' => $data['fecha'],
                'horario_id' => $data['horario_id'],
                'codigo_incidencia' => $data['codigo_incidencia'],
            ],
            [
                'asistencia_id' => $data['asistencia_id'] ?? null,
                'tipo_justificacion' => $data['tipo_justificacion'],
                'descripcion' => $data['descripcion'],
                'documento_referencia' => $data['documento_referencia'] ?? null,
                'estado' => $data['estado'] ?? 'aprobada',
                'evita_descuento' => $data['evita_descuento'] ?? true,
                'justificada_por' => $data['justificada_por'] ?? null,
                'origen' => $data['origen'] ?? 'web',
            ]
        );
    }
}
