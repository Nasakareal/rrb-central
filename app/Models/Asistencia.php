<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'empleado_id',
        'fecha',
        'entrada',
        'salida',
        'total_marcas',
        'observaciones',
        'archivo_origen',
        'llave_registro',
    ];

    protected $casts = [
        'fecha' => 'date',
        'total_marcas' => 'integer',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
