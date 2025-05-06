<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acerca de – RRB Central</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .section-title { margin-top: 3rem; margin-bottom: 1rem; }
  </style>
</head>
<body>

  {{-- Mismo navbar que welcome --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ route('welcome') }}">RRB Central</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('sistemas') }}">Sistemas</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('about') }}">Acerca de</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Contenido --}}
  <div class="container py-5">
    <h2 class="section-title text-center">Nuestra Misión</h2>
    <p>En RRB Central nos dedicamos a ofrecer un punto de acceso único, seguro y confiable para todos los sistemas desarrollados por nuestra Universidad Technológica de Morelia. Facilitamos la navegación y experimentación con cada demo.</p>

    <h2 class="section-title">Nuestra Visión</h2>
    <p>Ser reconocidos como el hub tecnológico principal de la UTM, donde estudiantes y personal puedan interactuar de forma sencilla con soluciones digitales innovadoras.</p>

    <h2 class="section-title">Metas</h2>
    <ul>
      <li>Lanzar nuevas integraciones cada semestre.</li>
      <li>Aumentar la adopción de nuestros sistemas en un 50% en el próximo año.</li>
      <li>Mantener un uptime superior al 99,5%.</li>
    </ul>

    <h2 class="section-title">Compromisos</h2>
    <ul>
      <li>Actualizaciones periódicas basadas en feedback.</li>
      <li>Soporte técnico y documentación completa.</li>
      <li>Adopción de estándares de seguridad y accesibilidad.</li>
    </ul>
  </div>

  {{-- Mismo footer que welcome --}}
  <footer class="text-center py-4 bg-light">
    <small class="text-muted">© {{ date('Y') }} RRB · Universidad Tecnológica de Morelia</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
