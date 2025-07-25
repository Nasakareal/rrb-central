<?php

namespace App\Http\Controllers\Papeleria;

use App\Http\Controllers\Controller;
use App\Models\Papeleria\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('papeleria.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('papeleria.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('papeleria.categorias.index')->with('success', 'Categoría creada correctamente');
    }

    public function show(Categoria $categoria)
    {
        return view('papeleria.categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('papeleria.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('papeleria.categorias.index')->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('papeleria.categorias.index')->with('success', 'Categoría eliminada correctamente');
    }
}
