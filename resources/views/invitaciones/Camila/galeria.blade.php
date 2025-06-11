<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Galería de Fotos • Camila</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/plantillas/xv/plantilla001.css') }}">
</head>

<body>
  <section class="py-5">
    <div class="container">
      <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">📸 Galería de Fotos del Evento</h2>

      @if($evento->fotos->isEmpty())
        <p class="text-center">Aún no se han subido fotos.</p>
      @else
        <div class="row">
          @foreach ($evento->fotos as $foto)
            <div class="col-md-4 mb-4">
              <div class="card shadow">
                <img src="{{ asset('storage/' . $foto->imagen_path) }}" class="card-img-top" alt="Foto subida">
                <div class="card-body">
                  @if($foto->nombre_invitado)
                    <h5 class="card-title">{{ $foto->nombre_invitado }}</h5>
                  @endif
                  @if($foto->comentario)
                    <p class="card-text">{{ $foto->comentario }}</p>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <div class="text-center mt-4">
        <a href="{{ url('/camila') }}" class="btn btn-outline-dark">
          ← Regresar a la invitación
        </a>
      </div>
    </div>
  </section>

  <!-- Formulario para subir foto -->
  <section class="py-5 bg-light">
    <div class="container">
      <h3 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">📤 Sube tu propia foto</h3>

      @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
      @endif

      <form action="{{ route('camila.foto.subir') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 700px;">
        @csrf
        <input type="hidden" name="evento_id" value="{{ $evento->id }}">

        <div class="mb-3">
          <label for="nombre_invitado" class="form-label">Tu nombre (opcional)</label>
          <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado">
        </div>

        <div class="mb-3">
          <label for="comentario" class="form-label">Comentario (opcional)</label>
          <textarea class="form-control" id="comentario" name="comentario" rows="2"></textarea>
        </div>

        <div class="mb-3">
          <label for="imagen" class="form-label">Selecciona tu foto</label>
          <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-warning">
            Subir Foto 📷
          </button>
        </div>
      </form>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
