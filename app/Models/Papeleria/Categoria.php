<?php

namespace App\Models\Papeleria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activa',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
