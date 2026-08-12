<?php

namespace App\Services;

use App\Models\Asistencia;
use App\Models\AsistenciaJustificacion;
use App\Models\EmpleadoHorario;
use App\Models\RelojMarca;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class AsistenciaReglamentoService
{
    public function reporte(string $desde, string $hasta): array
    {
        $asignaciones = EmpleadoHorario::with(['empleado.departamento', 'empleado.puesto', 'horario'])
            ->where('activo', true)
            ->whereDate('fecha_inicio', '<=', $hasta)
            ->where(function ($query) use ($desde) {
                $query->whereNull('fecha_fin')->orWhereDate('fecha_fin', '>=', $desde);
            })
            ->get()
            ->filter(function ($asignacion) {
                return $asignacion->empleado && $asignacion->horario
                    && $asignacion->empleado->estatus === 'activo'
                    && $asignacion->horario->activo;
            });

        $empleados = $asignaciones->pluck('empleado')->unique('id')->values();
        $numerosReloj = $empleados->pluck('numero_reloj')->filter()->values();
        $empleadoIds = $empleados->pluck('id')->values();

        $asistencias = Asistencia::whereIn('empleado_id', $empleadoIds)
            ->whereBetween('fecha', [$desde, $hasta])
            ->get()
            ->keyBy(function ($item) {
                return $item->empleado_id . '|' . $item->fecha->format('Y-m-d');
            });

        $marcas = RelojMarca::whereIn('numero_reloj', $numerosReloj)
            ->whereBetween('fecha_hora', [$desde . ' 00:00:00', $hasta . ' 23:59:59'])
            ->orderBy('fecha_hora')
            ->get()
            ->groupBy(function ($item) {
                return $item->numero_reloj . '|' . $item->fecha_hora->format('Y-m-d');
            });

        $justificaciones = AsistenciaJustificacion::with('usuario')
            ->whereIn('empleado_id', $empleadoIds)
            ->whereBetween('fecha', [$desde, $hasta])
            ->latest('id')
            ->get();

        $incidencias = collect();
        foreach ($empleados as $empleado) {
            foreach (CarbonPeriod::create($desde, $hasta) as $fecha) {
                $fechaTexto = $fecha->format('Y-m-d');
                $bloques = $asignaciones
                    ->where('empleado_id', $empleado->id)
                    ->filter(function ($asignacion) use ($fecha, $fechaTexto) {
                        $dias = array_map('intval', explode(',', $asignacion->horario->dias_semana ?: '1,2,3,4,5'));
                        return $asignacion->fecha_inicio->format('Y-m-d') <= $fechaTexto
                            && (!$asignacion->fecha_fin || $asignacion->fecha_fin->format('Y-m-d') >= $fechaTexto)
                            && in_array($fecha->dayOfWeekIso, $dias, true);
                    })
                    ->sortBy(function ($asignacion) {
                        return $asignacion->horario->hora_entrada;
                    })
                    ->values();

                if ($bloques->isEmpty()) {
                    continue;
                }

                $marcasDia = $marcas->get($empleado->numero_reloj . '|' . $fechaTexto, collect());
                $usadas = [];
                $asistencia = $asistencias->get($empleado->id . '|' . $fechaTexto);

                foreach ($bloques as $indice => $asignacion) {
                    $reales = $this->marcasParaBloque($marcasDia, $usadas, $fechaTexto, $asignacion->horario);

                    if (!$marcasDia->count() && $indice === 0 && $asistencia) {
                        $reales = [
                            'entrada' => $asistencia->entrada,
                            'salida' => $asistencia->salida,
                        ];
                    }

                    foreach ($this->clasificarBloque(
                        $asignacion->horario->hora_entrada,
                        $asignacion->horario->hora_salida,
                        $reales['entrada'],
                        $reales['salida']
                    ) as $clasificacion) {
                        $justificacion = $this->buscarJustificacion(
                            $justificaciones,
                            $empleado->id,
                            $fechaTexto,
                            $asignacion->horario_id,
                            $clasificacion['codigo']
                        );

                        $incidencias->push($this->filaIncidencia(
                            $empleado,
                            $asistencia,
                            $asignacion,
                            $fechaTexto,
                            $reales,
                            $clasificacion,
                            $justificacion
                        ));
                    }
                }
            }
        }

        $incidencias = $incidencias->sortBy(function ($fila) {
            return $fila['fecha'] . '|' . $fila['numero_reloj'] . '|' . $fila['hora_entrada_programada'];
        })->values();

        return [
            'incidencias' => $incidencias->all(),
            'resumen' => $this->resumir($incidencias),
            'advertencia' => 'Cálculo sugerido con base en el Reglamento UTM 2018; Recursos Humanos debe validar la procedencia del descuento.',
        ];
    }

    public function clasificarBloque(string $entradaProgramada, string $salidaProgramada, $entradaReal, $salidaReal): array
    {
        if (!$entradaReal && !$salidaReal) {
            return [$this->clasificacion('FALTA', 'Sin marcas de entrada ni salida', 100, null)];
        }

        if (!$entradaReal || !$salidaReal) {
            return [$this->clasificacion('OES', 'Omisión de entrada o salida', 100, null)];
        }

        $resultado = [];
        $minutosEntrada = $this->diferenciaMinutos($entradaProgramada, $entradaReal);
        if ($minutosEntrada > 90) {
            $resultado[] = $this->clasificacion('FALTA', 'Entrada posterior a 90 minutos', 100, $minutosEntrada);
        } elseif ($minutosEntrada > 30) {
            $resultado[] = $this->clasificacion('RM', 'Retardo mayor', 25, $minutosEntrada);
        } elseif ($minutosEntrada > 20) {
            $resultado[] = $this->clasificacion('R2', 'Retardo de 21 a 30 minutos', 0, $minutosEntrada);
        } elseif ($minutosEntrada > 10) {
            $resultado[] = $this->clasificacion('R1', 'Retardo de 11 a 20 minutos', 0, $minutosEntrada);
        }

        $minutosSalida = $this->diferenciaMinutos($salidaReal, $salidaProgramada);
        if ($minutosSalida > 20) {
            $resultado[] = $this->clasificacion('SM', 'Salida anticipada mayor a 20 minutos', 25, $minutosSalida);
        } elseif ($minutosSalida > 10) {
            $resultado[] = $this->clasificacion('S2', 'Salida anticipada de 11 a 20 minutos', 0, $minutosSalida);
        } elseif ($minutosSalida > 0) {
            $resultado[] = $this->clasificacion('S1', 'Salida anticipada de 1 a 10 minutos', 0, $minutosSalida);
        }

        return $resultado;
    }

    private function marcasParaBloque(Collection $marcas, array &$usadas, string $fecha, $horario): array
    {
        $entradaObjetivo = Carbon::parse($fecha . ' ' . $horario->hora_entrada);
        $salidaObjetivo = Carbon::parse($fecha . ' ' . $horario->hora_salida);

        $entrada = $this->marcaMasCercana($marcas, $usadas, $entradaObjetivo, -10, 90);
        $salida = $this->marcaMasCercana($marcas, $usadas, $salidaObjetivo, -1440, 59);

        return [
            'entrada' => $entrada ? $entrada->fecha_hora->format('H:i:s') : null,
            'salida' => $salida ? $salida->fecha_hora->format('H:i:s') : null,
        ];
    }

    private function marcaMasCercana(Collection $marcas, array &$usadas, Carbon $objetivo, int $desdeMinutos, int $hastaMinutos)
    {
        $candidatas = $marcas->filter(function ($marca) use ($usadas, $objetivo, $desdeMinutos, $hastaMinutos) {
            if (isset($usadas[$marca->id])) {
                return false;
            }
            $diferencia = $objetivo->diffInMinutes($marca->fecha_hora, false);
            return $diferencia >= $desdeMinutos && $diferencia <= $hastaMinutos;
        })->sortBy(function ($marca) use ($objetivo) {
            return abs($objetivo->diffInSeconds($marca->fecha_hora, false));
        });

        $marca = $candidatas->first();
        if ($marca) {
            $usadas[$marca->id] = true;
        }

        return $marca;
    }

    private function diferenciaMinutos(string $inicio, string $fin): int
    {
        return Carbon::parse('2000-01-01 ' . $inicio)->diffInMinutes(Carbon::parse('2000-01-01 ' . $fin), false);
    }

    private function clasificacion(string $codigo, string $descripcion, int $porcentaje, $minutos): array
    {
        return compact('codigo', 'descripcion', 'porcentaje', 'minutos');
    }

    private function buscarJustificacion(Collection $justificaciones, int $empleadoId, string $fecha, int $horarioId, string $codigo)
    {
        return $justificaciones->first(function ($item) use ($empleadoId, $fecha, $horarioId, $codigo) {
            return $item->empleado_id === $empleadoId
                && $item->fecha->format('Y-m-d') === $fecha
                && (int) $item->horario_id === $horarioId
                && $item->codigo_incidencia === $codigo;
        });
    }

    private function filaIncidencia($empleado, $asistencia, $asignacion, string $fecha, array $reales, array $clasificacion, $justificacion): array
    {
        $nombre = trim(implode(' ', array_filter([
            $empleado->nombre,
            $empleado->apellido_paterno,
            $empleado->apellido_materno,
        ])));

        $justificada = $justificacion
            && $justificacion->estado === 'aprobada'
            && $justificacion->evita_descuento;

        return [
            'empleado_id' => $empleado->id,
            'asistencia_id' => $asistencia ? $asistencia->id : null,
            'horario_id' => $asignacion->horario_id,
            'numero_reloj' => $empleado->numero_reloj,
            'empleado' => $nombre ?: 'Sin nombre',
            'tipo_personal' => $empleado->tipo_personal,
            'departamento' => optional($empleado->departamento)->nombre,
            'fecha' => $fecha,
            'mes' => substr($fecha, 0, 7),
            'bloque' => $asignacion->horario->nombre,
            'hora_entrada_programada' => $asignacion->horario->hora_entrada,
            'hora_salida_programada' => $asignacion->horario->hora_salida,
            'entrada_real' => $reales['entrada'],
            'salida_real' => $reales['salida'],
            'codigo' => $clasificacion['codigo'],
            'incidencia' => $clasificacion['descripcion'],
            'minutos' => $clasificacion['minutos'],
            'porcentaje_base_sugerido' => $clasificacion['porcentaje'],
            'justificada' => (bool) $justificada,
            'justificacion_id' => $justificacion ? $justificacion->id : null,
            'tipo_justificacion' => $justificacion ? $justificacion->tipo_justificacion : null,
            'descripcion_justificacion' => $justificacion ? $justificacion->descripcion : null,
            'documento_referencia' => $justificacion ? $justificacion->documento_referencia : null,
            'justificada_por' => $justificacion && $justificacion->usuario ? $justificacion->usuario->name : null,
            'estado' => $justificada ? 'Justificada - sin descuento' : 'Pendiente de validar',
        ];
    }

    private function resumir(Collection $incidencias): array
    {
        return $incidencias->groupBy(function ($fila) {
            return $fila['empleado_id'] . '|' . $fila['mes'];
        })->map(function (Collection $filas) {
            $primera = $filas->first();
            $aplicables = $filas->where('justificada', false);
            $conteos = $aplicables->countBy('codigo');
            $retardosMenores = ($conteos->get('R1', 0) + (2 * $conteos->get('R2', 0))) / 6;
            $salidasMenores = ($conteos->get('S1', 0) + (2 * $conteos->get('S2', 0))) / 6;
            $dias = $conteos->get('FALTA', 0)
                + $conteos->get('OES', 0)
                + floor($retardosMenores)
                + floor($salidasMenores)
                + ($conteos->get('RM', 0) * .25)
                + ($conteos->get('SM', 0) * .25);

            return [
                'empleado_id' => $primera['empleado_id'],
                'numero_reloj' => $primera['numero_reloj'],
                'empleado' => $primera['empleado'],
                'mes' => $primera['mes'],
                'r1' => $conteos->get('R1', 0),
                'r2' => $conteos->get('R2', 0),
                'rm' => $conteos->get('RM', 0),
                's1' => $conteos->get('S1', 0),
                's2' => $conteos->get('S2', 0),
                'sm' => $conteos->get('SM', 0),
                'oes' => $conteos->get('OES', 0),
                'faltas' => $conteos->get('FALTA', 0),
                'justificadas' => $filas->where('justificada', true)->count(),
                'dias_descuento_sugerido' => round($dias, 2),
                'porcentaje_dia_sugerido' => round($dias * 100, 2),
            ];
        })->sortBy(function ($fila) {
            return $fila['mes'] . '|' . $fila['numero_reloj'];
        })->values()->all();
    }
}
