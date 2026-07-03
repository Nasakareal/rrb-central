<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'nombre',
        'hora_entrada',
        'hora_salida',
        'tolerancia_entrada_minutos',
        'tolerancia_salida_minutos',
        'activo',
    ];

    protected $casts = [
        'tolerancia_entrada_minutos' => 'integer',
        'tolerancia_salida_minutos' => 'integer',
        'activo' => 'boolean',
    ];

    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_horarios')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'activo'])
            ->withTimestamps();
    }
}
