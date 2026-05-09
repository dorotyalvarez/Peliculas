@extends('layouts.bootstrap')

@section('title', $pelicula->titulo)

@section('content')
<main class="container py-5 text-light position-relative">

  {{-- Fondo degradado --}}
  <div class="bg-gradient"></div>

  <div class="row align-items-start g-4">
    {{-- Poster --}}
    <div class="col-lg-4">
      <div class="poster-card shadow-lg rounded-4 overflow-hidden">
        <img
          src="{{ $pelicula->poster_url ?? 'https://via.placeholder.com/700x1050?text=Sin+Imagen' }}"
          alt="Poster de {{ $pelicula->titulo }}"
          class="w-100 d-block poster-img"
          onerror="this.src='https://via.placeholder.com/700x1050?text=Sin+Imagen'">
      </div>
    </div>

    {{-- Info --}}
    <div class="col-lg-8">
      <div class="glass p-4 p-md-5 rounded-4 shadow-lg">

        <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
          <h1 class="display-6 mb-0">{{ $pelicula->titulo }}</h1>
          {{-- Chips info rápida --}}
          <div class="d-flex flex-wrap gap-2">
            @if($pelicula->genero)
              <span class="badge rounded-pill bg-warning text-dark">🎭 {{ $pelicula->genero }}</span>
            @endif
            @if($pelicula->anio)
              <span class="badge rounded-pill bg-secondary">📅 {{ $pelicula->anio }}</span>
            @endif
            @if($pelicula->categoria)
              <span class="badge rounded-pill bg-info text-dark">🏷️ {{ ucfirst($pelicula->categoria) }}</span>
            @endif
          </div>
        </div>

        {{-- Descripción --}}
        @if($pelicula->descripcion)
          <p class="lead text-light-50 mb-4">{{ $pelicula->descripcion }}</p>
        @else
          <p class="text-muted fst-italic">Sin descripción.</p>
        @endif

        {{-- Trailer --}}
        @php
          $raw = $pelicula->trailer ?? '';
          $embedUrl = null; $youtubeWatch = null; $id = null;

          if (!empty($raw)) {
            if (preg_match('/youtu\.be\/([^\?\/\&]+)/', $raw, $m))      $id = $m[1];
            elseif (preg_match('/[?&]v=([^&]+)/', $raw, $m))            $id = $m[1];
            elseif (preg_match('/embed\/([^&?\/]+)/', $raw, $m))        $id = $m[1];
          }

          if (!empty($id)) {
            $embedUrl = 'https://www.youtube.com/embed/' . $id;
            $youtubeWatch = 'https://www.youtube.com/watch?v=' . $id;
          }
        @endphp

        <div class="mb-4">
          @if($embedUrl)
            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
              <iframe
                src="{{ $embedUrl }}"
                title="Tráiler de {{ $pelicula->titulo }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen loading="lazy"></iframe>
            </div>
            <p class="small text-muted mt-2">
              Si no ves el reproductor, <a href="{{ $youtubeWatch }}" target="_blank" rel="noopener">abrir en YouTube</a>.
            </p>
          @elseif(!empty($raw))
            <div class="alert alert-secondary">
              <strong>Tráiler no embebible</strong> — <a href="{{ $raw }}" target="_blank" rel="noopener">abrir enlace</a>
            </div>
          @else
            <div class="alert alert-dark border-0">🎞️ Tráiler no disponible.</div>
          @endif
        </div>

        {{-- Botones de acción --}}
        <div class="d-flex flex-wrap gap-2">
          {{-- ⚠️ Tu ruta es /peliculas/{id}/ver, así que pasamos id explícito --}}
          <a href="{{ route('peliculas.ver', ['id' => $pelicula->id]) }}" class="btn btn-warning btn-lg shadow-sm">
            🎬 Ver película
          </a>

          @if($embedUrl || !empty($raw))
            <a href="{{ $embedUrl ? $youtubeWatch : $raw }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-lg shadow-sm">
              ▶️ Ver tráiler
            </a>
          @endif

          <button class="btn btn-outline-warning btn-lg shadow-sm" onclick="copiarEnlace()">
            🔗 Copiar enlace
          </button>
        </div>

      </div>
    </div>
  </div>

</main>

{{-- UX Scripts --}}
<script>
  function copiarEnlace() {
    const url = "{{ route('peliculas.show', $pelicula) }}";
    navigator.clipboard.writeText(url).then(() => {
      const b = document.createElement('div');
      b.className = 'toast-copy';
      b.textContent = 'Enlace copiado ✔';
      document.body.appendChild(b);
      setTimeout(()=> b.classList.add('show'), 10);
      setTimeout(()=> { b.classList.remove('show'); setTimeout(()=>b.remove(), 200); }, 1800);
    });
  }
</script>

{{-- Estilos pro: glass + gradient + microinteracciones --}}
<style>
  :root {
    --amber: #ffc107;
  }
  body {
    background: #0b0b0b;
  }
  .bg-gradient {
    position: absolute;
    inset: 0;
    background:
      radial-gradient(60rem 30rem at 10% 10%, rgba(255,193,7,.12), transparent 60%),
      radial-gradient(50rem 25rem at 90% 20%, rgba(255,255,255,.06), transparent 60%),
      radial-gradient(40rem 20rem at 50% 90%, rgba(255,193,7,.08), transparent 60%);
    pointer-events: none;
    z-index: 0;
  }
  .glass {
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
    background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
    border: 1px solid rgba(255,255,255,.08);
  }
  .poster-card {
    border-radius: 1.25rem;
    background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
    border: 1px solid rgba(255,255,255,.08);
  }
  .poster-img {
    display:block;
    transition: transform .35s ease;
  }
  .poster-card:hover .poster-img {
    transform: scale(1.03);
  }
  .text-light-50 { color: rgba(255,255,255,.7) !important; }

  /* Toast copy */
  .toast-copy {
    position: fixed;
    bottom: 18px; right: 18px;
    background: rgba(0,0,0,.85);
    border: 1px solid rgba(255,255,255,.15);
    color: #fff;
    padding: .6rem .9rem;
    border-radius: .75rem;
    opacity: 0;
    transform: translateY(10px);
    transition: all .2s ease;
    z-index: 1080;
    box-shadow: 0 10px 30px rgba(0,0,0,.35);
  }
  .toast-copy.show {
    opacity: 1; transform: translateY(0);
  }
</style>
@endsection
