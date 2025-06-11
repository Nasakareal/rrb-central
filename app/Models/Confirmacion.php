<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmacion extends Model
{
    use HasFactory;

    protected $table = 'confirmaciones';

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'asistencia',
        'boletos',
        'mensaje',
    ];
}
