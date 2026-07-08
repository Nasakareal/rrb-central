<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BioSyncLicencia extends Model
{
    protected $table = 'biosync_licencias';

    protected $fillable = [
        'clave',
        'cliente',
        'equipo_id',
        'activa',
        'fecha_vencimiento',
        'ultima_validacion',
        'ultima_version',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'fecha_vencimiento' => 'date',
        'ultima_validacion' => 'datetime',
    ];
}