<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmacion extends Model
{
    use HasFactory;

    protected $table = 'confirmaciones';

    protected $fillable = [
        'evento_id',
        'nombre',
        'telefono',
        'email',
        'asistencia',
        'boletos',
        'mensaje',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
