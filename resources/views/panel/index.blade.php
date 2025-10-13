@extends('layouts.bootstrap')
@section('title','Panel')


@section('content')
<div class="container py-4">

  {{-- Encabezado --}}
  <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <h3 class="text-light m-0 d-flex align-items-center gap-2">
      <span class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width:34px;height:34px;background:rgba(255,193,7,.15)">
        🛠️
      </span>
      Panel
    </h3>
    <div class="d-flex gap-2">
      <a href="{{ route('peliculas.index') }}" class="btn btn-outline-warning btn-sm">Ir al inicio</a>
    </div>
  </div>

  {{-- Tarjetas métricas --}}
  <div class="row g-3">
    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm h-100" style="background: #141414;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="text-muted small">Películas</div>
              <div class="h3 m-0 text-light">{{ $stats['peliculas'] ?? 0 }}</div>
            </div>
            <div class="rounded d-inline-flex align-items-center justify-content-center px-2 py-1" style="background:rgba(255,193,7,.15);">🎬</div>
          </div>
          <div class="text-secondary small mt-2">Total en catálogo</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm h-100" style="background: #141414;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="text-muted small">Pendientes</div>
              <div class="h3 m-0 text-warning">{{ $stats['solicitudes_pend'] ?? 0 }}</div>
            </div>
            <div class="rounded d-inline-flex align-items-center justify-content-center px-2 py-1" style="background:rgba(220,53,69,.15);">⏳</div>
          </div>
          <div class="text-secondary small mt-2">Por revisar</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm h-100" style="background: #141414;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="text-muted small">Solicitudes</div>
              <div class="h3 m-0 text-light">{{ $stats['solicitudes_totales'] ?? 0 }}</div>
            </div>
            <div class="rounded d-inline-flex align-items-center justify-content-center px-2 py-1" style="background:rgba(108,117,125,.15);">📥</div>
          </div>
          <div class="text-secondary small mt-2">Histórico total</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Últimas solicitudes --}}
  <div class="card border-0 shadow-sm mt-4" style="background:#0f0f0f;">
    <div class="card-header bg-warning text-dark fw-semibold">
  <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-2">
      <span>Últimas solicitudes</span>

      {{-- Tabs (preservan búsqueda y orden) --}}
      <div class="btn-group btn-group-sm ms-2">
        <a href="{{ route('panel', array_merge(request()->only(['q','orden']), [])) }}"
           class="btn btn-outline-dark {{ $estado === null ? 'active' : '' }}">
          Todas
          <span class="badge bg-dark text-warning ms-1">{{ $contadores['todas'] ?? 0 }}</span>
        </a>

        <a href="{{ route('panel', array_merge(request()->only(['q','orden']), ['estado'=>'pendiente'])) }}"
           class="btn btn-outline-dark {{ $estado === 'pendiente' ? 'active' : '' }}">
          Pendientes
          <span class="badge bg-dark text-warning ms-1">{{ $contadores['pendiente'] ?? 0 }}</span>
        </a>

        <a href="{{ route('panel', array_merge(request()->only(['q','orden']), ['estado'=>'aprobada'])) }}"
           class="btn btn-outline-dark {{ $estado === 'aprobada' ? 'active' : '' }}">
          Aprobadas
          <span class="badge bg-dark text-warning ms-1">{{ $contadores['aprobada'] ?? 0 }}</span>
        </a>

        <a href="{{ route('panel', array_merge(request()->only(['q','orden']), ['estado'=>'rechazada'])) }}"
           class="btn btn-outline-dark {{ $estado === 'rechazada' ? 'active' : '' }}">
          Rechazadas
          <span class="badge bg-dark text-warning ms-1">{{ $contadores['rechazada'] ?? 0 }}</span>
        </a>
      </div>
    </div>

    {{-- Filtros: búsqueda + orden --}}
    <form method="GET" action="{{ route('panel') }}" class="d-flex flex-wrap gap-2 align-items-center">
      {{-- preserva el estado actual si hay --}}
      @if($estado)
        <input type="hidden" name="estado" value="{{ $estado }}">
      @endif

      <div class="input-group input-group-sm" style="width: 280px;">
        
        <input type="text" name="q" value="{{ $q }}" class="form-control border-dark"
               placeholder="Buscar por título, sinopsis, tráiler">
      </div>

      <select name="orden" class="form-select form-select-sm bg-dark text-light border-dark" style="width: 160px;">
        <option value="desc" @selected($orden==='desc')>Más recientes primero</option>
        <option value="asc"  @selected($orden==='asc')>Más antiguas primero</option>
      </select>

      <button class="btn btn-sm btn-dark text-warning border-0">Aplicar</button>

      @if($q || ($orden && $orden!=='desc') || $estado)
        <a href="{{ route('panel') }}" class="btn btn-sm btn-outline-dark">Limpiar</a>
      @endif
    </form>

  </div>
</div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle m-0">
          <thead class="table-borderless" style="background:#121212">
            <tr>
              <th class="ps-3">Título</th>
              <th>Tráiler</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th class="text-end pe-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ultimas as $s)
              <tr class="border-top border-secondary border-opacity-25">
                <td class="ps-3">
                  <div class="d-flex align-items-center gap-2">
                    @php
                      $thumb = !empty($s->poster_path) ? asset('storage/'.$s->poster_path) : null;
                    @endphp
                    @if($thumb)
                      <img src="{{ $thumb }}" alt="Poster" width="34" height="48" class="rounded shadow-sm object-fit-cover">
                    @else
                      <div class="rounded bg-secondary d-inline-flex align-items-center justify-content-center text-dark fw-bold" style="width:34px;height:48px;">🎬</div>
                    @endif
                    <div>
                      <div class="fw-semibold text-light">{{ $s->nombre }}</div>
                      <div class="small text-secondary text-truncate" style="max-width: 320px;">
                        {{ \Illuminate\Support\Str::limit($s->sinopsis ?? 'Sin sinopsis', 90) }}
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  @if($s->trailer_url)
                    <a href="{{ $s->trailer_url }}" target="_blank" class="link-warning text-decoration-none">Ver</a>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td>
                  @php
                    $badgeMap = [
                      'pendiente' => ['warning','Pendiente'],
                      'aprobada'  => ['success','Aprobada'],
                      'rechazada' => ['danger','Rechazada'],
                    ];
                    [$badgeColor,$badgeText] = $badgeMap[$s->estado ?? 'pendiente'] ?? ['secondary','N/A'];
                  @endphp
                  <span class="badge bg-{{ $badgeColor }}">{{ $badgeText }}</span>
                </td>
                <td>{{ optional($s->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-end pe-3">
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary"
                     data-bs-toggle="modal"
                     data-bs-target="#modalVer-{{ $s->id }}">Ver</button>
                    {{-- Aprobar --}}
                    @if($s->estado !== 'aprobada')
                      <button class="btn btn-outline-success"
                              data-bs-toggle="modal"
                              data-bs-target="#modalAprobar-{{ $s->id }}">
                        Aprobar
                      </button>
                    @endif

                    {{-- Rechazar --}}
                    @if($s->estado !== 'rechazada')
                      <button class="btn btn-outline-danger"
                              data-bs-toggle="modal"
                              data-bs-target="#modalRechazar-{{ $s->id }}">
                        Rechazar
                      </button>
                    @endif
                  </div>

                  {{-- Modal Aprobar --}}
                  <div class="modal fade" id="modalAprobar-{{ $s->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                      <div class="modal-content bg-dark text-light border-0">
                        <div class="modal-header border-0">
                          <h6 class="modal-title">Aprobar solicitud</h6>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          ¿Confirmas aprobar <strong>{{ $s->nombre }}</strong>?
                        </div>
                        <div class="modal-footer border-0">
                          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                          <form method="POST" action="{{ route('solicitudes.aprobar', $s) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">Sí, aprobar</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div> {{-- Modal Ver --}}
<div class="modal fade" id="modalVer-{{ $s->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark text-light border-0">
      <div class="modal-header border-0">
        <h5 class="modal-title">Solicitud: {{ $s->nombre }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form class="row g-3">
          {{-- Nombre --}}
          <div class="col-12">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control bg-dark text-light border-secondary" value="{{ $s->nombre }}" disabled>
          </div>

          {{-- Trailer --}}
          <div class="col-md-6">
            <label class="form-label">URL del tráiler</label>
            <input type="url" class="form-control bg-dark text-light border-secondary" value="{{ $s->trailer_url }}" disabled>
            @if($s->trailer_url)
              <a href="{{ $s->trailer_url }}" target="_blank" class="small link-warning text-decoration-none mt-1 d-inline-block">Abrir tráiler</a>
            @endif
          </div>

          {{-- Estado --}}
          <div class="col-md-6">
            <label class="form-label">Estado</label>
            @php
              $map = ['pendiente'=>'warning','aprobada'=>'success','rechazada'=>'danger'];
              $color = $map[$s->estado] ?? 'secondary';
            @endphp
            <div class="form-control bg-dark text-light border-secondary">
              <span class="badge bg-{{ $color }}">{{ ucfirst($s->estado ?? 'N/A') }}</span>
            </div>
          </div>

          {{-- Imágenes --}}
          <div class="col-md-6">
            <label class="form-label">Póster</label>
            @php $poster = $s->poster_path ? asset('storage/'.$s->poster_path) : null; @endphp
            <div class="border border-secondary rounded p-2 text-center">
              @if($poster)
                <img src="{{ $poster }}" alt="Póster" class="img-fluid rounded" style="max-height:260px;object-fit:cover;">
              @else
                <div class="text-muted">Sin póster</div>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Banner</label>
            @php $banner = $s->banner_path ? asset('storage/'.$s->banner_path) : null; @endphp
            <div class="border border-secondary rounded p-2 text-center">
              @if($banner)
                <img src="{{ $banner }}" alt="Banner" class="img-fluid rounded" style="max-height:260px;object-fit:cover;">
              @else
                <div class="text-muted">Sin banner</div>
              @endif
            </div>
          </div>

          {{-- Sinopsis --}}
          <div class="col-12">
            <label class="form-label">Sinopsis</label>
            <textarea class="form-control bg-dark text-light border-secondary" rows="4" disabled>{{ $s->sinopsis }}</textarea>
          </div>
        </form>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        {{-- Si después quieres permitir edición, aquí podemos poner "Editar" y "Guardar" --}}
      </div>
    </div>
  </div>
</div>

                  {{-- Modal Rechazar --}}
                  <div class="modal fade" id="modalRechazar-{{ $s->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                      <div class="modal-content bg-dark text-light border-0">
                        <div class="modal-header border-0">
                          <h6 class="modal-title">Rechazar solicitud</h6>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          ¿Seguro que deseas rechazar <strong>{{ $s->nombre }}</strong>?
                        </div>
                        <div class="modal-footer border-0">
                          <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                          <form method="POST" action="{{ route('solicitudes.rechazar', $s) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-danger btn-sm">Sí, rechazar</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-secondary py-5">
                  <div class="d-inline-flex flex-column align-items-center">
                    <div class="display-6">🫙</div>
                    <div class="fw-semibold text-light mt-2">Sin solicitudes todavía</div>
                    <div class="text-muted small">Cuando alguien solicite una película, la verás aquí.</div>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        </div> {{-- .table-responsive --}}
</div> {{-- .card-body --}}

@if($ultimas->hasPages())
  <div class="card-footer bg-transparent border-0">
    <div class="d-flex justify-content-end">
      {{ $ultimas->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
  </div>
@endif
      </div>
    </div>
  </div>
</div>

{{-- Estilos sutiles para dark/hover --}}
<style>
  .table-dark.table-hover tbody tr:hover { background-color: #151515 !important; }
  .object-fit-cover { object-fit: cover; }
</style>

{{-- Toast de éxito --}}
@if(session('ok'))
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
    <div id="okToast" class="toast align-items-center text-bg-dark border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('ok') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const t = document.getElementById('okToast');
      if (t && window.bootstrap?.Toast) new bootstrap.Toast(t, { delay: 2500 }).show();
    });
  </script>
@endif
@endsection