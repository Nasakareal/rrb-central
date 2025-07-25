@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Categorías disponibles</h2>

        @auth
            <a href="{{ route('papeleria.categorias.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva categoría
            </a>
        @endauth
    </div>

    <div class="mb-4">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar categoría...">
    </div>

    <div class="row" id="contenedor-categorias">
        @forelse ($categorias as $categoria)
            <div class="col-md-4 mb-3 categoria-item">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $categoria->nombre }}</h5>

                        <a href="{{ route('papeleria.categorias.show', $categoria) }}" class="btn btn-primary mt-auto">
                            Ver productos
                        </a>

                        @auth
                            <div class="mt-3 d-flex justify-content-between">
                                <a href="{{ route('papeleria.categorias.edit', $categoria) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('papeleria.categorias.destroy', $categoria) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-warning">No hay categorías registradas.</div>
            </div>
        @endforelse
    </div>

    <script>
        document.getElementById('buscador').addEventListener('input', function () {
            const filtro = this.value.toLowerCase();
            document.querySelectorAll('.categoria-item').forEach(function (card) {
                const nombre = card.querySelector('.card-title').textContent.toLowerCase();
                card.style.display = nombre.includes(filtro) ? 'block' : 'none';
            });
        });
    </script>
@endsection
