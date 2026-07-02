<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'numero_reloj',
        'nombre',
        'campus_id',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
