<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelojMarca extends Model
{
    protected $table = 'reloj_marcas';

    protected $fillable = [
        'clave', 'dispositivo_id', 'dispositivo_serial', 'dispositivo_ip',
        'numero_reloj', 'fecha_hora', 'modo_verificacion',
        'modo_entrada_salida', 'codigo_trabajo',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'modo_verificacion' => 'integer',
        'modo_entrada_salida' => 'integer',
        'codigo_trabajo' => 'integer',
    ];
}