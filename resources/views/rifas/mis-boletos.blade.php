@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Mis boletos — {{ $rifa->titulo }}</h1>
  <ul>
    @forelse($boletos as $b)
      <li>#{{ $b->numero }} ({{ strtoupper($b->estado) }})</li>
    @empty
      <li>No tienes boletos en esta rifa.</li>
    @endforelse
  </ul>
</div>
@endsection
