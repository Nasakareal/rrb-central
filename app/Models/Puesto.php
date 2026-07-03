<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
