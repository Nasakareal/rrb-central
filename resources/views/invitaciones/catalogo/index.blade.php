<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catálogo de Invitaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    .catalog-header {
      background: linear-gradient(135deg,#4e54c8,#8f94fb);
      color: #fff;
      padding: 4rem 1rem;
      text-align: center;
    }
    .filter-btn {
      margin: 0 .25rem;
      border-radius: 50px;
    }
    .filter-btn.active {
      background-color: #4e54c8;
      color: #fff;
    }
    .card-hover {
      border: none;
      transition: transform .3s, box-shadow .3s;
    }
    .card-hover:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>

  <section class="catalog-header animate__animated animate__fadeInDown">
    <h1 class="display-4 fw-bold">Catálogo de Diseños</h1>
    <p class="lead">Elige el estilo perfecto: XV años, bodas, cumpleaños…</p>
  </section>

  <div class="container py-5">
    <div class="text-center mb-4 animate__animated animate__fadeInUp">
      <button class="btn btn-outline-primary filter-btn active" data-filter="all">Todos</button>
      @foreach($categorias as $clave => $cat)
        <button class="btn btn-outline-primary filter-btn" data-filter="{{ $clave }}">{{ $cat['nombre'] }}</button>
      @endforeach
    </div>

    <div class="row g-4">
      @foreach ($categorias as $clave => $cat)
        <div class="col-lg-3 col-md-4 col-sm-6 filtrable category-{{ $clave }} animate__animated animate__zoomIn">
          <div class="card card-hover h-100 text-center">
            <img src="{{ asset('images/catalogo/' . $cat['imagen']) }}" 
                 class="img-fluid mx-auto d-block mt-4" 
                 style="max-height: 180px; border-radius: 10px;" 
                 alt="{{ $cat['nombre'] }}">

            <div class="card-body">
              <h5 class="card-title">{{ $cat['nombre'] }}</h5>
              <a href="{{ route('catalogo.show', $clave) }}" class="btn btn-primary">Ver diseños</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;

        document.querySelectorAll('.filtrable').forEach(card => {
          card.style.display = (filter === 'all' || card.classList.contains(`category-${filter}`)) ? 'block' : 'none';
        });
      });
    });
  </script>
</body>
</html>
