<?php

namespace App\Http\Controllers\Papeleria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Papeleria\Producto;
use App\Models\Papeleria\Categoria;

class PapeleriaController extends Controller
{
    /**
     * Muestra la página principal de la tienda /la-manzana
     */
    public function index()
    {
        $categorias = Categoria::where('activa', true)->get();
        $productos = Producto::where('activo', true)->take(12)->get();

        return view('papeleria.index', compact('categorias', 'productos'));
    }
}
