<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'campus_id',
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
