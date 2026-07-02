<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoleoImportado extends Model
{
    protected $table = 'poleos_importados';

    protected $fillable = [
        'nombre_archivo',
        'hash_archivo',
        'total_registros',
    ];

    protected $casts = [
        'total_registros' => 'integer',
    ];
}
