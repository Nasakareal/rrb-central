<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <title>RRB Central</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Animate.css para animaciones sencillas -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    /* Hero con imagen de fondo y overlay semi-oscuro */
    .hero {
      position: relative;
      background: url('{{ asset('prueba.png') }}') no-repeat center center;
      background-size: cover;
      color: #fff;
      height: 80vh;
      min-height: 500px;
      display: flex;
      align-items: center;
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.6);
    }
    .hero-content {
      position: relative;
      z-index: 1;
      text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }
    /* Tarjetas de sección “Acerca de” */
    .feature-card {
      border: none;
      transition: transform .3s, box-shadow .3s;
    }
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    /* Navbar transparente sobre el hero */
    .navbar-transparent {
      background: transparent !important;
    }
  </style>
</head>
<body>

  <!-- Navbar semitransparente -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-transparent position-absolute w-100" style="z-index:2;">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">RRB Central</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">Acerca de</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('sistemas') }}">Sistemas</a></li>
          <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero full-screen -->
  <header class="hero">
    <div class="container text-center hero-content animate__animated animate__fadeInDown">
      <h1 class="display-3 fw-bold">Bienvenido a RRB Central</h1>
      <p class="lead mt-3">Tu empresa confiable del soluciones informaticas.</p>
      <a href="{{ route('sistemas') }}" class="btn btn-primary btn-lg mt-4">Ver sistemas</a>
    </div>
  </header>

  <!-- Sección “Acerca de” -->
  <section id="about" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5 animate__animated animate__fadeInUp">¿Quiénes Somos?</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card feature-card text-center p-4 animate__animated animate__zoomIn">
            <img src="{{ asset('goal.png') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
            <div class="card-body">
              <h5 class="card-title">Nuestra Misión</h5>
              <p class="card-text">Desarrollar y ofrecer múltiples soluciones digitales integradas desde una plataforma central, brindando acceso seguro, confiable y eficiente para distintas necesidades institucionales.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card feature-card text-center p-4 animate__animated animate__zoomIn animate__delay-1s">
            <img src="{{ asset('vision.png') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
            <div class="card-body">
              <h5 class="card-title">Nuestra Visión</h5>
              <p class="card-text">Ser un referente en el desarrollo e integración de soluciones tecnológicas que impulsen la transformación digital de las organizaciones.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card feature-card text-center p-4 animate__animated animate__zoomIn animate__delay-2s">
            <img src="{{ asset('commitment.png') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
            <div class="card-body">
              <h5 class="card-title">Metas & Compromisos</h5>
              <p class="card-text mb-1">Desarrollar nuevas integraciones, facilitar el uso del sistema y asegurar la disponibilidad continua para todos los usuarios.</p>
                <p class="card-text">Brindar soporte técnico, actualizaciones constantes y mantener altos estándares de seguridad.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Sección “Clientes” -->
  <section id="clients" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5 animate__animated animate__fadeInUp">Nuestros Clientes</h2>
      <div class="row justify-content-center g-4">
        <div class="col-md-6 text-center animate__animated animate__zoomIn">
          <img src="{{ asset('ssp.svg') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
          <h5>Secretaría de Seguridad Pública de Michoacán</h5>
        </div>
        <div class="col-md-6 text-center animate__animated animate__zoomIn animate__delay-1s">
          <img src="{{ asset('utm.png') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
          <h5>Universidad Tecnológica de Morelia</h5>
        </div>
      </div>
      <div class="row justify-content-center g-4">
        <div class="col-md-6 text-center animate__animated animate__zoomIn">
          <img src="{{ asset('transporte.jpg') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
          <h5>Instituto del Transporte de Michoacán</h5>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer con contacto -->
  <footer id="contacto" class="bg-dark text-white text-center py-4">
    <div class="container">
      <p>📧 <a href="mailto:info@rrbs-soluciones.com" class="text-white">info@rrb-soluciones.com</a> | ☎️ (443) 347-65057</p>
      <small>© {{ date('Y') }} RRB · Soluciones informaticas</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
