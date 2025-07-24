<?php

namespace App\Models\Papeleria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoConfirmado extends Model
{
    use HasFactory;

    protected $table = 'carrito_confirmados';

    protected $fillable = [
        'carrito_id',
        'nombre_cliente',
        'telefono',
        'comentarios',
        'fecha_confirmacion',
        'notificado',
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }
}
