<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = 'campus';

    protected $fillable = [
        'clave',
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
