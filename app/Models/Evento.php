<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'codigo_unico',
    ];

    public function confirmaciones()
    {
        return $this->hasMany(Confirmacion::class);
    }

    public function fotos()
    {
        return $this->hasMany(FotoEvento::class);
    }
}
