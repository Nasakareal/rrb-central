<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Papelería La Manzana')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Bootstrap & FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f8;
        }
        .topbar {
            background-color: #0d6efd; /* Azul principal */
            color: white;
            padding: 1rem;
        }
        .topbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        .topbar a:hover {
            text-decoration: underline;
        }
        .search-bar input {
            border-radius: 30px 0 0 30px;
        }
        .search-bar button {
            border-radius: 0 30px 30px 0;
        }
    </style>
</head>
<body>

    {{-- Barra superior estilo OfficeDepot pero en azul --}}
    <div class="topbar d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <img src="{{ asset('papeleria/apple.png') }}" alt="Logo" style="height: 42px; margin-right: 15px;">
            <a href="#">Categorías</a>
            <a href="#">Servicios</a>
            <a href="#">Negocios</a>
            <a href="#">Facturación</a>
            <a href="#">Tienda</a>
            <a href="#">Ayuda</a>
        </div>
        <div class="d-flex align-items-center mt-3 mt-sm-0">
            <div class="input-group search-bar me-3">
                <input type="text" class="form-control" placeholder="Buscar producto o categoría...">
                <button class="btn btn-light"><i class="fas fa-search"></i></button>
            </div>
            <a href="#"><i class="far fa-heart"></i> Favoritos</a>
            <a href="{{ route('papeleria.carrito.index') }}" class="ms-3">
                <i class="fas fa-shopping-cart"></i> Carrito (0)
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="ms-3">
                    <i class="fas fa-user"></i> Panel
                </a>
            @else
                <a href="{{ route('login') }}" class="ms-3">
                    <i class="fas fa-user"></i> Iniciar sesión
                </a>
            @endauth
        </div>
    </div>

    {{-- Contenido principal --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
