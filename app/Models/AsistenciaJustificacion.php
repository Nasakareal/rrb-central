<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciaJustificacion extends Model
{
    protected $table = 'asistencia_justificaciones';

    protected $fillable = [
        'empleado_id',
        'asistencia_id',
        'horario_id',
        'fecha',
        'codigo_incidencia',
        'tipo_justificacion',
        'descripcion',
        'documento_referencia',
        'estado',
        'evita_descuento',
        'justificada_por',
        'origen',
    ];

    protected $casts = [
        'fecha' => 'date',
        'evita_descuento' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'justificada_por');
    }
}
