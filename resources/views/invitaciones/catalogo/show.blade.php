<!DOCTYPE html>
<html lang="es">
<head>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <meta charset="UTF-8">
  <title>Diseños - {{ $nombreCategoria }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    .catalog-header {
      background: linear-gradient(135deg, #4e54c8, #8f94fb);
      color: white;
      padding: 4rem 1rem;
      text-align: center;
    }
    .card-hover {
      border: none;
      transition: transform .3s, box-shadow .3s;
    }
    .card-hover:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
    .img-preview {
      max-height: 250px;
      object-fit: cover;
      border-radius: 0.5rem;
    }
  </style>
</head>
<body>

  <section class="catalog-header animate__animated animate__fadeInDown">
    <h1 class="display-4 fw-bold">{{ $nombreCategoria }}</h1>
    <p class="lead">Explora los diseños disponibles en esta categoría</p>
  </section>

  <div class="container py-5">
    <div class="row g-4">
      @forelse ($plantillas as $plantilla)
        <div class="col-lg-3 col-md-4 col-sm-6 animate__animated animate__fadeInUp">
          <div class="card card-hover h-100 text-center">
            @php
              $previewPath = "images/catalogo/$categoria/{$plantilla['nombre_archivo']}.png";
            @endphp

            @if (file_exists(public_path($previewPath)))
              <img
                src="{{ asset($previewPath) }}"
                class="img-fluid img-preview mx-auto mt-3"
                alt="Diseño {{ $plantilla['nombre'] }}">
            @else
              <img
                src="{{ asset('images/catalogo/default.png') }}"
                class="img-fluid img-preview mx-auto mt-3"
                alt="Sin vista previa">
            @endif

            <div class="card-body">
              <h5 class="card-title">{{ $plantilla['nombre'] }}</h5>
              <a href="{{ $plantilla['ruta'] }}" class="btn btn-outline-primary">
                Ver plantilla
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p class="text-muted">
            No hay diseños disponibles en esta categoría por el momento.
          </p>
        </div>
      @endforelse
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
