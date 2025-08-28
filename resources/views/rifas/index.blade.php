@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-3">Rifas activas</h1>
  <div class="row">
    @forelse($rifas as $r)
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          @if($r->imagen)
            <img src="{{ $r->imagen }}" class="card-img-top" alt="Rifa">
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $r->titulo }}</h5>
            <p class="card-text">{{ Str::limit($r->descripcion, 120) }}</p>
            <p class="mb-1"><strong>Precio:</strong> ${{ number_format($r->precio_boleto,2) }}</p>
            <p class="mb-1"><strong>Avance:</strong> {{ $r->avance_venta_porc }}%</p>
            <a href="{{ route('rifas.show', $r) }}" class="btn btn-primary btn-sm">Ver rifa</a>
          </div>
        </div>
      </div>
    @empty
      <p>No hay rifas disponibles.</p>
    @endforelse
  </div>
</div>
@endsection
