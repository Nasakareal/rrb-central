<?php

namespace App\Models\Papeleria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carritos';

    protected $fillable = [
        'token',
        'confirmado',
        'descuento_aplicado',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carrito_producto')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }
}
