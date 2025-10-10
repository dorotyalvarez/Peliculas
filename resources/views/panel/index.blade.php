@extends('layouts.bootstrap')
@section('title','Panel')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-light m-0">🎬 Panel</h3>
    <a href="{{ route('peliculas.index') }}" class="btn btn-outline-warning btn-sm">Ir al inicio</a>
  </div>

  {{-- Tarjetas --}}
  <div class="row g-3">
    <div class="col-12 col-md-4">
      <div class="card bg-dark border-0 text-light shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <span class="fw-semibold">Películas</span>
            <span class="badge bg-warning text-dark">{{ $stats['peliculas'] }}</span>
          </div>
          <small class="text-muted">Total en catálogo</small>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card bg-dark border-0 text-light shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <span class="fw-semibold">Solicitudes pendientes</span>
            <span class="badge bg-danger">{{ $stats['solicitudes_pend'] }}</span>
          </div>
          <small class="text-muted">Por revisar</small>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card bg-dark border-0 text-light shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <span class="fw-semibold">Solicitudes totales</span>
            <span class="badge bg-secondary">{{ $stats['solicitudes_totales'] }}</span>
          </div>
          <small class="text-muted">Histórico</small>
        </div>
      </div>
    </div>
  </div>

  {{-- Últimas solicitudes --}}
  <div class="card bg-dark border-0 text-light shadow-sm mt-4">
    <div class="card-header bg-warning text-dark fw-semibold">Últimas solicitudes</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle m-0">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Tráiler</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ultimas as $s)
              <tr>
                <td>{{ $s->nombre }}</td>
                <td>
                  @if($s->trailer_url)
                    <a href="{{ $s->trailer_url }}" target="_blank" class="link-warning">Ver</a>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td>
                  @php
                    $badge = [
                      'pendiente' => 'warning',
                      'aprobada'  => 'success',
                      'rechazada' => 'danger',
                    ][$s->estado] ?? 'secondary';
                  @endphp
                  <span class="badge bg-{{ $badge }}">{{ ucfirst($s->estado ?? 'N/A') }}</span>
                </td>
                <td>{{ $s->created_at?->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a href="#" class="btn btn-outline-secondary" title="Ver">Ver</a>
                    {{-- Próximo: Aprobar / Rechazar --}}
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No hay solicitudes aún</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
