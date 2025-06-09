<!-- resources/views/systems.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistemas RRB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      transition: .3s;
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <h2 class="mb-4 text-center">Nuestros Sistemas</h2>
    <div class="row g-4">
      <!-- Carga Horaria -->
      <div class="col-md-4">
        <div class="card card-hover h-100 text-center">
          <div class="card-body">
            <img src="{{ asset('schedule.png') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
            <h5 class="card-title mt-3">Carga Horaria</h5>
            <p class="card-text">Gestión de horarios escolares y asignaciones de salones.</p>
            <a href="https://rrb-soluciones.com/cargaDemo/login/" class="btn btn-primary">Ir a demo</a>
          </div>
        </div>
      </div>
        <!-- Invitaciones Inteligentes -->
        <div class="col-md-4">
            <div class="card card-hover h-100 text-center">
            <div class="card-body">
                <img src="{{ asset('invitation.png') }}" alt="Invitaciones Inteligentes" class="img-fluid mx-auto d-block" style="max-height: 80px;">
                <h5 class="card-title mt-3">Invitaciones Inteligentes</h5>
                <p class="card-text">Catálogo de diseños para eventos: bodas, XV años, convivios, y más.</p>
                <a href="{{ route('catalogo.index') }}" class="btn btn-primary">Ver diseños</a>
            </div>
            </div>
        </div>

      <!-- Inventarios -->
      <div class="col-md-4">
        <div class="card card-hover h-100 text-center">
          <div class="card-body">
            <img src="https://img.icons8.com/ios-filled/64/4e54c8/warehouse.png" alt="Inventarios">
            <h5 class="card-title mt-3">Inventarios</h5>
            <p class="card-text">Control de productos, QR y movimientos de almacén.</p>
            <a href="http://utmorelia.com/sistemaInventarios" class="btn btn-primary">Ir a demo</a>
          </div>
        </div>
      </div>
      <!-- Asistencias RFID -->
      <div class="col-md-4">
        <div class="card card-hover h-100 text-center">
          <div class="card-body">
            <img src="https://img.icons8.com/ios-filled/64/4e54c8/attendance-mark.png" alt="Asistencias RFID">
            <h5 class="card-title mt-3">Asistencias RFID</h5>
            <p class="card-text">Registro de entradas/salidas con ESP32 y Laravel.</p>
            <a href="http://utmorelia.com/sistemaAsistencias" class="btn btn-primary">Ir a demo</a>
          </div>
        </div>
      </div>
      <!-- (Agrega más tarjetas aquí) -->
    </div>
  </div>

  <footer class="text-center py-4 bg-light">
    <small class="text-muted">© {{ date('Y') }} RRB · Universidad Tecnológica de Morelia</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
