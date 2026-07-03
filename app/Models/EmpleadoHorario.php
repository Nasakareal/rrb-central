<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoHorario extends Model
{
    protected $table = 'empleado_horarios';

    protected $fillable = [
        'empleado_id',
        'horario_id',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
