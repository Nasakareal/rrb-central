<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de confirmaciones</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
  <div class="container">
    <h1 class="mb-4">
      🎉 Lista de confirmaciones - Camila ({{ $confirmaciones->where('asistencia', 'Sí')->reject(fn($c) => in_array($c->nombre, ['Mario Bautista', 'Lucas Aviles']))->count() }} asistentes confirmados)
    </h1>
    <div class="mb-4">
      <p class="mb-1"><strong>Total de confirmados:</strong> {{ $confirmaciones->where('asistencia', 'Sí')->reject(fn($c) => in_array($c->nombre, ['Mario Bautista', 'Lucas Aviles']))->count() }}</p>
      <p class="mb-1"><strong>No asistirán:</strong> {{ $confirmaciones->where('asistencia', 'No')->reject(fn($c) => in_array($c->nombre, ['Mario Bautista', 'Lucas Aviles']))->count() }}</p>
      <p class="mb-1"><strong>Registros totales:</strong> {{ $confirmaciones->reject(fn($c) => in_array($c->nombre, ['Mario Bautista', 'Lucas Aviles']))->count() }}</p>
    </div>
    <table class="table table-bordered table-striped">
      <thead class="table-warning text-center">
        <tr>
          <th>Nombre</th>
          <th>Asistencia</th>
          <th>Boletos</th>
          <th>Mensaje</th>
        </tr>
      </thead>
      <tbody>
        @php
            $filtradas = $confirmaciones->reject(fn($c) => in_array($c->nombre, ['Mario Bautista', 'Lucas Aviles']));
        @endphp

        @forelse($filtradas as $c)
          <tr>
            <td>{{ $c->nombre }}</td>
            <td class="text-center">{{ $c->asistencia }}</td>
            <td class="text-center">
                @if (is_numeric($c->boletos))
                    {{ $c->boletos }} boleto{{ $c->boletos == 1 ? '' : 's' }}
                @else
                    No respondió
                @endif
            </td>
            <td>{{ $c->mensaje ?? '-' }}</td>
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
