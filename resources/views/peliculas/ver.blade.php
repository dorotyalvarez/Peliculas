@extends('layouts.bootstrap')

@section('title', 'Reproduciendo: ' . $pelicula->titulo)

@section('content')
@php
    // Fuentes disponibles
    $local   = $pelicula->video_src;     // /storage/videos/...
    $url     = $pelicula->video_url;     // URL principal
    $backup  = $pelicula->video_backup;  // URL de respaldo

    // Helpers de validación
    $isYouTube = fn(?string $u) => $u && (str_contains($u,'youtube.com') || str_contains($u,'youtu.be'));
    $isVideoExt = fn(?string $u) => $u && preg_match('/\.(mp4|webm|ogv|m3u8|mpd)(\?|$)/i', $u);

    // Filtramos solo videos válidos (sin duplicados)
    $fuentes = collect([$local, $url, $backup])
        ->filter(fn($u) => $isYouTube($u) || $isVideoExt($u))
        ->unique()
        ->values();

    // Etiquetas para los botones
    $labels = [];
    if ($local  && $fuentes->contains($local))  $labels['📁 Local']        = $local;
    if ($url    && $fuentes->contains($url))    $labels['🌐 URL principal'] = $url;
    if ($backup && $fuentes->contains($backup)) $labels['🔁 URL backup']    = $backup;

    // Fuente activa (por query ?src=... o la primera válida)
    $srcReq = request('src');
    $activa = $srcReq && $fuentes->contains($srcReq) ? $srcReq : ($fuentes[0] ?? null);

    // Generar embed de YouTube
    $toEmbed = function (string $u) {
        if (preg_match('/youtu\.be\/([^?&\/]+)/', $u, $m))      $id = $m[1];
        elseif (preg_match('/[?&]v=([^&]+)/', $u, $m))          $id = $m[1];
        elseif (preg_match('/embed\/([^?&\/]+)/', $u, $m))      $id = $m[1];
        else $id = null;
        return $id ? "https://www.youtube.com/embed/{$id}?autoplay=1&rel=0&modestbranding=1" : $u;
    };
@endphp

<main class="container py-5 text-center">
  <h2 class="mb-4 text-light">🎬 {{ $pelicula->titulo }}</h2>

  {{-- Botones de fuente --}}
  @if(count($labels))
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
      @foreach($labels as $texto => $u)
        <a class="btn btn-sm {{ $u === $activa ? 'btn-warning' : 'btn-outline-light' }}"
           href="{{ request()->fullUrlWithQuery(['src' => $u]) }}">
           {{ $texto }} — Ver aquí
        </a>
        <a class="btn btn-sm btn-secondary" target="_blank" href="{{ $u }}">
          Abrir en pestaña
        </a>
      @endforeach
    </div>
  @endif

  {{-- Reproductor principal --}}
  @if($activa)
    <div class="mx-auto rounded shadow" style="max-width: 960px; overflow: hidden;">
      @if($isYouTube($activa))
        <div class="ratio ratio-16x9">
          <iframe src="{{ $toEmbed($activa) }}"
                  allow="autoplay; encrypted-media; picture-in-picture"
                  allowfullscreen loading="lazy"></iframe>
        </div>
      @else
        <video controls playsinline class="w-100">
          <source src="{{ $activa }}" type="video/mp4">
          Tu navegador no soporta video HTML5.
        </video>
      @endif
    </div>
  @else
    <div class="alert alert-warning mt-4">
      No hay una <strong>fuente de video válida</strong>.  
      Usa una URL de YouTube o un archivo local <code>.mp4</code>.
    </div>
  @endif

  <div class="mt-4">
    <a href="{{ route('peliculas.show', $pelicula) }}" class="btn btn-secondary">
      ⬅ Volver a la información
    </a>
  </div>
</main>

<style>
  body { background:#000; }
  h2 { font-weight:600; }
  .shadow { box-shadow:0 0 35px rgba(255,193,7,.25)!important; }
</style>
@endsection
