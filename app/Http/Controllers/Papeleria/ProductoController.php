<?php

namespace App\Http\Controllers\Papeleria;

use App\Http\Controllers\Controller;
use App\Models\Papeleria\Categoria;
use App\Models\Papeleria\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->orderBy('nombre')->get();

        return view('papeleria.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('papeleria.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        Producto::create($this->validatedData($request));

        return redirect()->route('papeleria.productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function show(Producto $producto)
    {
        $producto->load('categoria');

        return view('papeleria.productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('papeleria.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($this->validatedData($request));

        return redirect()->route('papeleria.productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('papeleria.productos.index')
            ->with('success', 'Producto eliminado correctamente');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'activo' => ['nullable', 'boolean'],
        ]);
    }
}
