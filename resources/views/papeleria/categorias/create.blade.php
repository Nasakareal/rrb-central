@extends('layouts.app')

@section('title', 'Nueva Categoría')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Agregar nueva categoría</h2>
        <a href="{{ route('papeleria.categorias.index') }}" class="btn btn-secondary mt-2">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos errores:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('papeleria.categorias.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la categoría</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required maxlength="100"
                   value="{{ old('nombre') }}" placeholder="Ej. Papelería, Tecnología, Regalos">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Guardar categoría
        </button>
    </form>
@endsection
