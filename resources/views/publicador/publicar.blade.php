@extends('layouts.bootstrap')
@section('title','Publicar película')

@section('content')
<div class="container py-4">
  <h3 class="text-light mb-3">🎬 Publicar película</h3>

  <div class="mb-3">
    <a href="{{ route('publicador.panel') }}" class="btn btn-outline-light btn-sm">← Volver</a>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card bg-dark text-light">
        <div class="card-body">
          <form method="POST" action="{{ route('publicador.publicar.store', $solicitud) }}">
            @csrf

            <div class="row">
              <div class="col-md-8 mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $data['titulo']) }}" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Año</label>
                <input type="text" name="anio" class="form-control" value="{{ old('anio', $data['anio']) }}" placeholder="2024">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Género</label>
                <input type="text" name="genero" class="form-control" value="{{ old('genero', $data['genero']) }}" placeholder="Acción, Drama">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Categoría</label>
                <input type="text" name="categoria" class="form-control" value="{{ old('categoria', $data['categoria']) }}" placeholder="Película/Serie">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" rows="4" class="form-control">{{ old('descripcion', $data['descripcion']) }}</textarea>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Tráiler (URL)</label>
                <input type="url" name="trailer" class="form-control" value="{{ old('trailer', $data['trailer']) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Video principal (URL)</label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $data['video_url']) }}">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Video backup (URL)</label>
                <input type="url" name="video_backup" class="form-control" value="{{ old('video_backup', $data['video_backup']) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Poster origen (solo lectura)</label>
                <input type="text" class="form-control" value="{{ $solicitud->poster_path ?? '—' }}" disabled>
                <div class="form-text">Se copiará a <code>storage/app/public/posters</code></div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button class="btn btn-warning">Publicar ahora</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Vista previa del poster si existe --}}
    <div class="col-lg-4">
      <div class="card bg-dark">
        <div class="card-header text-light">Poster (solicitud)</div>
        <div class="card-body text-center">
          @if($solicitud->poster_path && Storage::disk('public')->exists($solicitud->poster_path))
            <img src="{{ asset('storage/'.$solicitud->poster_path) }}" alt="poster" class="img-fluid rounded">
          @else
            <div class="text-secondary">Sin poster</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
