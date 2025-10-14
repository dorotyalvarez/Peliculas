@extends('layouts.bootstrap')
@section('title','Panel Verificador')

@section('content')
<div class="container py-4">
  <h3 class="text-light mb-3">🔎 Panel Verificador</h3>

  <div class="card border-0 shadow-sm" style="background:#0f0f0f;">
    <div class="card-header bg-warning text-dark fw-semibold">
      Solicitudes pendientes
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle m-0">
          <thead>
            <tr>
              <th class="ps-3">Título</th>
              <th>Tráiler</th>
              <th>Estado</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            @forelse($solicitudes as $s)
              <tr>
                <td class="ps-3">{{ $s->nombre }}</td>
                <td>
                  @if($s->trailer_url)
                    <a class="link-warning" target="_blank" href="{{ $s->trailer_url }}">Ver</a>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td><span class="badge bg-warning">Pendiente</span></td>
                <td>{{ optional($s->created_at)->format('d/m/Y H:i') }}</td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center text-secondary py-4">No hay pendientes</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($solicitudes->hasPages())
      <div class="card-footer bg-transparent border-0">
        <div class="d-flex justify-content-end">
          {{ $solicitudes->links('pagination::bootstrap-5') }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
