@extends('papeleria.layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Administración</h1>

    <div class="row g-4">
        {{-- Categorías --}}
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-list fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Categorías</h5>
                        <p class="card-text fs-4">{{ $categoriasCount }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('papeleria.categorias.index') }}" class="text-white">
                        Ver categorías <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Productos --}}
        <div class="col-md-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-boxes fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text fs-4">{{ $productosCount }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('papeleria.productos.index') }}" class="text-white">
                        Ver productos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Carritos --}}
        <div class="col-md-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-shopping-cart fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Carritos</h5>
                        <p class="card-text fs-4">{{ $carritosCount }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('papeleria.carrito.index') }}" class="text-white">
                        Ver carritos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Pedidos confirmados --}}
        <div class="col-md-3">
            <div class="card text-white bg-danger h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-check fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Pedidos</h5>
                        <p class="card-text fs-4">{{ $confirmadosCount }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="text-white">
                        Ver pedidos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
