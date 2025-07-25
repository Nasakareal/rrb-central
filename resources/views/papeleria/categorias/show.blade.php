@extends('layouts.app')

@section('title', 'Categoría: ' . $categoria->nombre)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">{{ $categoria->nombre }}</h2>
        <a href="{{ route('papeleria.categorias.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    @auth
        <div class="mb-4 d-flex">
            <a href="{{ route('papeleria.categorias.edit', $categoria) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Editar categoría
            </a>

            <form action="{{ route('papeleria.categorias.destroy', $categoria) }}" method="POST"
                  onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar categoría
                </button>
            </form>
        </div>
    @endauth

    <div class="alert alert-info">
        Aquí se podrían mostrar los productos de esta categoría.
    </div>

    {{-- Ejemplo futuro:
    <div class="row">
        @foreach ($categoria->productos as $producto)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">${{ number_format($producto->precio, 2) }}</p>
                        <a href="{{ route('papeleria.productos.show', $producto) }}" class="btn btn-sm btn-primary">
                            Ver producto
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    --}}
@endsection
