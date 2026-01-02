<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Facebook Analyzer')</title>

  {{-- Bootstrap 5 (CDN) SOLO para esta vista --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --fa-text: #eafff4;
      --fa-text-soft: rgba(234,255,244,.85);
      --fa-placeholder: rgba(234,255,244,.55);
      --fa-green: #00ff88;
      --fa-border: rgba(255,255,255,.10);
      --fa-border-2: rgba(255,255,255,.14);
      --fa-bg: #070707;
      --fa-card: rgba(10,10,10,.78);
    }

    body{
      min-height: 100vh;
      background: radial-gradient(circle at top, rgba(0,255,136,.10), transparent 40%),
                  radial-gradient(circle at bottom, rgba(0,150,255,.08), transparent 45%),
                  var(--fa-bg);
      color: var(--fa-text);
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }

    .shell{
      min-height: 100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 32px 16px;
    }

    /* Card base */
    .card{
      background: var(--fa-card) !important;
      border: 1px solid var(--fa-border) !important;
      box-shadow: 0 16px 50px rgba(0,0,0,.55);
      backdrop-filter: blur(6px);
      border-radius: 14px !important;
    }

    /* OJO: NO usamos .card * { color: ... } porque rompe alerts y cosas internas */

    /* Tipografía general dentro del card */
    .card .card-body,
    .card .card-body p,
    .card .card-body li,
    .card .card-body div,
    .card .card-body span{
      color: var(--fa-text);
    }

    h1,h2,h3,h4,h5,h6{
      color: #f4fff9 !important;
    }

    label, .form-label{
      color: var(--fa-text-soft) !important;
      opacity: 1 !important;
    }

    .text-muted, small.text-muted{
      color: var(--fa-text-soft) !important;
      opacity: 1 !important;
    }

    .form-control{
      background: rgba(0,0,0,.35) !important;
      border: 1px solid rgba(255,255,255,.12) !important;
      color: var(--fa-text) !important;
      border-radius: 10px !important;
    }

    .form-control::placeholder{
      color: var(--fa-placeholder) !important;
      opacity: 1 !important;
    }

    .form-control:focus{
      border-color: rgba(0,255,136,.55) !important;
      box-shadow: 0 0 0 .25rem rgba(0,255,136,.12) !important;
    }

    .btn{
      border-radius: 10px !important;
      border: 1px solid var(--fa-border-2) !important;
    }

    .btn-dark{
      background: rgba(0,0,0,.55) !important;
      border: 1px solid rgba(255,255,255,.18) !important;
      color: var(--fa-text) !important;
    }

    .btn-danger{
      background: rgba(255,0,80,.14) !important;
      border: 1px solid rgba(255,0,80,.35) !important;
      color:#ffd6e3 !important;
    }

    .badge{
      color: var(--fa-text) !important;
      background: rgba(255,255,255,.10) !important;
      border: 1px solid rgba(255,255,255,.20) !important;
    }

    /* Consola */
    pre#console{
      background:#050505 !important;
      color: var(--fa-green) !important;
      border:1px solid rgba(255,255,255,.08) !important;
      min-height: 320px;
      overflow:auto;
      border-radius: 12px !important;
    }

    /* Título */
    .brand{
      color: var(--fa-green);
      letter-spacing:.06em;
      font-weight:800;
    }

    /* ===== Aviso de seguridad: versión “hacker” legible ===== */
    .alert{
      border-radius: 12px !important;
    }

    .alert-warning{
      /* Fondo oscuro con vibe warning */
      background: rgba(255,193,7,.10) !important;
      border: 1px solid rgba(255,193,7,.55) !important;
      color: #fff6d1 !important; /* texto claro */
      text-shadow: none !important;
    }

    .alert-warning *{
      color: #fff6d1 !important;
    }

    .alert-warning .fw-bold{
      color: #fff !important;
    }

    /* iconito (si lo tienes) también visible */
    .alert-warning svg, .alert-warning i{
      color: #ffe08a !important;
    }
  </style>
</head>

<body>
  <div class="shell">
    <div class="w-100" style="max-width: 820px;">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
