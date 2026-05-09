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

          {{-- errores de validación --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('publicador.publicar.store', $solicitud) }}" enctype="multipart/form-data">
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
                <label class="form-label">Video principal (URL externa)</label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $data['video_url']) }}" placeholder="https://... (opcional)">
              </div>
            </div>

            {{-- NUEVO: subir archivo de video local --}}
            <div class="row">
              <div class="col-md-12 mb-3">
                <label class="form-label">Subir archivo de video (opcional)</label>
                <input type="file" name="video_file" class="form-control" accept="video/mp4,video/webm,video/ogg">
                <div class="form-text">
                  Se guardará en <code>storage/app/public/videos</code> → URL pública <code>/storage/videos/...</code>.
                  Si subes archivo, el reproductor usará ese video local (tiene prioridad sobre la URL externa).
                </div>
              </div>
            </div>
            
{{-- 🔁 NUEVO: backup por URL --}}
<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Video backup (URL externa)</label>
    <input type="url" name="video_backup" class="form-control" value="{{ old('video_backup') }}" placeholder="https://... (opcional)">
  </div>

  {{-- (Opcional) backup como archivo local --}}
  <div class="col-md-6 mb-3">
    <label class="form-label">Subir archivo de video (backup) (opcional)</label>
    <input type="file" name="video_backup_file" class="form-control" accept="video/mp4,video/webm,video/ogg">
    <div class="form-text">
      Si subes un archivo aquí, se usará como fuente alternativa. Quedará en <code>/storage/videos/...</code>
    </div>
  </div>
</div>

            {{-- (opcionales) permitir reemplazar imágenes al publicar --}}
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Poster (archivo)</label>
                <input type="file" name="poster" class="form-control" accept="image/*">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Banner (archivo)</label>
                <input type="file" name="banner" class="form-control" accept="image/*">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Poster origen (solo lectura)</label>
                <input type="text" class="form-control" value="{{ $solicitud->poster_path ?? '—' }}" disabled>
                <div class="form-text">Se copiará a <code>publicar/posters</code> si no subes uno nuevo.</div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Banner origen (solo lectura)</label>
                <input type="text" class="form-control" value="{{ $solicitud->banner_path ?? '—' }}" disabled>
                <div class="form-text">Se copiará a <code>publicar/banners</code> si no subes uno nuevo.</div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button class="btn btn-warning" id="btnPublicar">Publicar ahora</button>

{{-- Barra de progreso --}}
<div id="progressWrapper" class="mt-3" style="display:none;">
  <div class="d-flex justify-content-between text-light mb-1">
    <small>Subiendo video...</small>
    <small id="progressPercent">0%</small>
  </div>
  <div class="progress">
    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
         role="progressbar" style="width: 0%"></div>
  </div>
  <small class="text-secondary" id="progressSize"></small>
  <div> 
  <small class="text-secondary" id="progressTime"></small>
  </div>
</div>
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

<script>
document.getElementById('btnPublicar').addEventListener('click', function(e) {
    e.preventDefault();

    const form = this.closest('form');
    const formData = new FormData(form);
    const wrapper = document.getElementById('progressWrapper');
    const bar = document.getElementById('progressBar');
    const percent = document.getElementById('progressPercent');
    const size = document.getElementById('progressSize');
    const timeLeft = document.getElementById('progressTime');

    wrapper.style.display = 'block';
    this.disabled = true;
    this.textContent = 'Subiendo...';

    let startTime = null;

    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            if (!startTime) startTime = Date.now();

            const pct = Math.round((e.loaded / e.total) * 100);
            const mb = (e.loaded / 1024 / 1024).toFixed(1);
            const total = (e.total / 1024 / 1024).toFixed(1);

            // Tiempo restante
            const elapsed = (Date.now() - startTime) / 1000;
            const speed = e.loaded / elapsed;
            const remaining = (e.total - e.loaded) / speed;

            const mins = Math.floor(remaining / 60);
            const secs = Math.floor(remaining % 60);
            const tiempoTexto = mins > 0
                ? `${mins} min ${secs} seg restantes`
                : `${secs} seg restantes`;

            bar.style.width = pct + '%';
            percent.textContent = pct + '%';
            size.textContent = mb + ' MB de ' + total + ' MB';
            timeLeft.textContent = tiempoTexto;
        }
    });

    xhr.addEventListener('load', function() {
        if (xhr.status === 200 || xhr.status === 302) {
            window.location.href = xhr.responseURL;
        } else {
            alert('Error al publicar. Código: ' + xhr.status);
            document.getElementById('btnPublicar').disabled = false;
            document.getElementById('btnPublicar').textContent = 'Publicar ahora';
        }
    });

    xhr.addEventListener('error', function() {
        alert('Error de conexión al subir el video.');
    });

    xhr.open('POST', form.action);
    xhr.send(formData);
});
</script>
@endsection
