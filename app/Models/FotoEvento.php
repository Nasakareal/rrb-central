<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoEvento extends Model
{
    use HasFactory;

    protected $table = 'fotos_evento';

    protected $fillable = [
        'evento_id',
        'nombre_invitado',
        'imagen_path',
        'comentario',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
