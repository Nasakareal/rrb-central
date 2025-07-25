<?php

namespace App\Http\Controllers;

use App\Models\Papeleria\Categoria;
use App\Models\Papeleria\Producto;
use App\Models\Papeleria\Carrito;
use App\Models\Papeleria\CarritoConfirmado;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'categoriasCount'   => Categoria::count(),
            'productosCount'    => Producto::count(),
            'carritosCount'     => Carrito::count(),
            'confirmadosCount'  => CarritoConfirmado::count(),
        ]);
    }
}
