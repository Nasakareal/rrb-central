<?php

namespace App\Models\Papeleria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'activo',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
