@extends('layouts.bootstrap')
@section('title','Solicitar película')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-warning bg-gradient text-dark fw-bold fs-5">
          🎬 Solicitar nueva película
        </div>

        <div class="card-body bg-light">
          @if(session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
          @endif
          @if(session('ok'))
  <div class="alert alert-success text-center fw-semibold mt-2" id="successMessage">
    🎉 {{ session('ok') }}<br>
    Serás redirigido al inicio en <span id="countdown">6</span> segundos...
  </div>

  <script>
    let counter = 6;
    const interval = setInterval(() => {
      counter--;
      document.getElementById('countdown').textContent = counter;
      if (counter <= 0) {
        clearInterval(interval);
        window.location.href = "{{ url('/') }}";
      }
    }, 1000);
  </script>
@endif

          <form method="POST" action="{{ route('solicitudes.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Nombre --}}
            <div class="mb-3">
              <label class="form-label fw-semibold">Nombre de la película</label>
              <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
               @error('nombre')
                <div class="invalid-feedback d-flex align-items-center mt-1 fade-in" style="display: flex;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1 text-danger" viewBox="0 0 16 16">
               <path d="M7.938 2.016a.13.13 0 0 1 .124 0l6.857 3.94a.13.13 0 0 1 0 .23L8.062 10.13a.13.13 0 0 1-.124 0L1.08 6.186a.13.13 0 0 1 0-.23l6.857-3.94z"/>
                   <path d="M8 5.255a.255.255 0 1 0 0 .51.255.255 0 0 0 0-.51zM7.002 7h1v4h-1V7z"/>
             </svg>
      <span class="text-danger fw-semibold">{{ $message }}</span>
              </div>
             @enderror

            {{-- Trailer --}}
            <div class="mb-3">
              <label class="form-label fw-semibold">URL del tráiler</label>
              <input type="url" name="trailer_url" value="{{ old('trailer_url') }}" class="form-control" placeholder="https://youtube.com/..." required>
            </div>

            {{-- Imágenes --}}
            <div class="row g-3">
              {{-- PÓSTER --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold d-flex justify-content-between">
                  <span>Póster</span><small class="text-muted">mín. 600x800</small>
                </label>
                <div class="preview-box ratio ratio-3x4 mb-2 position-relative">
                  <img id="previewPoster" class="preview-img rounded-3 shadow-sm" alt="">
                  <span class="placeholder-text">Sin imagen</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                  <input type="file" name="poster" id="inputPoster" class="form-control form-control-sm flex-grow-1" accept="image/*">
                  <button type="button" class="btn btn-outline-danger btn-sm" id="clearPoster" title="Quitar imagen">✖</button>
                </div>
              </div>

              {{-- BANNER --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold d-flex justify-content-between">
                  <span>Banner</span><small class="text-muted">mín. 1200x500</small>
                </label>
                <div class="preview-box ratio ratio-21x9 mb-2 position-relative">
                  <img id="previewBanner" class="preview-img rounded-3 shadow-sm" alt="">
                  <span class="placeholder-text">Sin imagen</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                  <input type="file" name="banner" id="inputBanner" class="form-control form-control-sm flex-grow-1" accept="image/*">
                  <button type="button" class="btn btn-outline-danger btn-sm" id="clearBanner" title="Quitar imagen">✖</button>
                </div>
              </div>
            </div>

            {{-- Sinopsis --}}
            <div class="mt-4 mb-3">
              <label class="form-label fw-semibold">Sinopsis</label>
              <textarea name="sinopsis" class="form-control" rows="4" placeholder="Describe brevemente la película...">{{ old('sinopsis') }}</textarea>
            </div>

            {{-- Botones --}}
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancelar</a>
              <button class="btn btn-warning fw-semibold">Enviar solicitud</button>
            </div>
          </form>
        </div>
      </div>
      <small class="text-muted d-block text-center mt-3">Usa imágenes proporcionales: vertical para póster, panorámica para banner.</small>
    </div>
  </div>
</div>


<style>
  .preview-box {
    background: #f0f0f0;
    border: 2px dashed #d6d6d6;
    border-radius: .75rem;
    overflow: hidden;
    position: relative;
  }
  .preview-img {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .3s ease, opacity .2s;
    opacity: 0;
  }
  .preview-box.has-image .preview-img { opacity: 1; }
  .preview-img:hover { transform: scale(1.03); }

  .placeholder-text {
    position: absolute;
    inset: 0;
    display: flex; align-items: center; justify-content: center;
    color: #999;
    font-size: .9rem;
    pointer-events: none;
  }
  .preview-box.has-image .placeholder-text { display: none; }

  /* fallback ratios */
  .ratio-21x9::before { content:""; display:block; padding-top: calc(100% * 9 / 21); }
  .ratio-3x4::before { content:""; display:block; padding-top: calc(100% * 4 / 3); }
  .fade-in {
  animation: fadeIn .5s ease-in-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-4px); }
  to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
(() => {
  const fields = [
    { input:'inputPoster', preview:'previewPoster', clear:'clearPoster', minW:600, minH:800 },
    { input:'inputBanner', preview:'previewBanner', clear:'clearBanner', minW:1200, minH:500 },
  ];

  function showPreview(file, img, box, minW, minH){
    if(!file){ clearPreview(img, box); return; }
    const url = URL.createObjectURL(file);
    const probe = new Image();
    probe.onload = () => {
      if(probe.width < minW || probe.height < minH){
        alert(`La imagen debe tener al menos ${minW}x${minH}px (actual: ${probe.width}x${probe.height}).`);
        URL.revokeObjectURL(url);
        clearPreview(img, box);
        return;
      }
      img.src = url;
      box.classList.add('has-image');
      img.onload = ()=>URL.revokeObjectURL(url);
    };
    probe.src = url;
  }

  function clearPreview(img, box){
    img.removeAttribute('src');
    box.classList.remove('has-image');
  }

  fields.forEach(f=>{
    const input = document.getElementById(f.input);
    const img   = document.getElementById(f.preview);
    const clear = document.getElementById(f.clear);
    const box   = img.closest('.preview-box');

    input.addEventListener('change',()=>showPreview(input.files?.[0], img, box, f.minW, f.minH));
    clear.addEventListener('click',()=>{ input.value=''; clearPreview(img, box); });
  });
})();
</script>
@endsection
