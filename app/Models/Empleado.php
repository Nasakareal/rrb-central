<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'numero_reloj',
        'numero_empleado',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'campus_id',
        'departamento_id',
        'puesto_id',
        'estatus',
        'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'empleado_horarios')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'activo'])
            ->withTimestamps();
    }
}
