<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <meta charset="UTF-8">
  <title>Lista de confirmaciones</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
  <div class="container">
    <h1 class="mb-4">
      🎉 Lista de confirmaciones - Camila ({{ $confirmaciones->where('asistencia', 'Sí')->count() }} asistentes confirmados)
    </h1>

    <div class="mb-4">
      <p class="mb-1"><strong>Total de confirmados:</strong> {{ $confirmaciones->where('asistencia', 'Sí')->count() }}</p>
      <p class="mb-1"><strong>No asistirán:</strong> {{ $confirmaciones->where('asistencia', 'No')->count() }}</p>
      <p class="mb-1"><strong>Registros totales:</strong> {{ $confirmaciones->count() }}</p>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-warning text-center">
        <tr>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Asistencia</th>
          <th>Boletos</th>
          <th>Mensaje</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        @forelse($confirmaciones as $c)
          <tr>
            <td>{{ $c->nombre }}</td>
            <td>{{ $c->telefono }}</td>
            <td>{{ $c->email }}</td>
            <td class="text-center">{{ $c->asistencia }}</td>
            <td class="text-center">{{ $c->boletos ?? 'No respondió' }}</td>
            <td>{{ $c->mensaje ?? '-' }}</td>
            <td>{{ $c->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">Nadie ha confirmado aún.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</body>
</html>
