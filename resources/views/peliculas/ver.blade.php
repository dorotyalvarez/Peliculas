@extends('layouts.app')

@section('title', 'Reproduciendo: ' . $pelicula->titulo)

@section('content')
<main class="container py-5 text-center">

    <h2 class="mb-4 text-light">🎬 {{ $pelicula->titulo }}</h2>

    <!-- Botones para cambiar fuente -->
    <div class="mb-3">
        @if($pelicula->video_url)
            <button class="btn btn-primary btn-sm" onclick="cambiarFuente('{{ $pelicula->video_url }}')">
                Fuente principal
            </button>
        @endif
        @if($pelicula->video_backup)
            <button class="btn btn-secondary btn-sm" onclick="cambiarFuente('{{ $pelicula->video_backup }}')">
                Fuente alternativa
            </button>
        @endif
    </div>

    <!-- Video.js Player -->
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />

    <video
      id="player"
      class="video-js vjs-big-play-centered vjs-theme-city custom-video"
      controls
      preload="auto"
      width="960"
      height="540"
      poster="{{ $pelicula->imagen }}"
      data-setup="{}"
    >
      @if($pelicula->video_url)
          <source src="{{ $pelicula->video_url }}" type="video/mp4" />
      @elseif($pelicula->video_backup)
          <source src="{{ $pelicula->video_backup }}" type="video/mp4" />
      @endif
      Tu navegador no soporta video HTML5.
    </video>

    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

    <script>
        let player = videojs('player');

        function cambiarFuente(url) {
            player.src({ type: "video/mp4", src: url });
            player.play();
        }
    </script>

    <!-- Botón volver -->
    <div class="mt-4">
        <a href="{{ route('peliculas.show', $pelicula->id) }}" class="btn btn-secondary">
            ⬅ Volver a la información
        </a>
    </div>

</main>

<style>
    body {
        background-color: #000; /* Fondo negro estilo cine */
    }

    /* Fondo oscuro del player */
    .custom-video {
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.9);
        border-radius: 10px;
    }

    /* Barra de controles más grande */
    .vjs-control-bar {
        font-size: 1.2rem;
        background: rgba(20, 20, 20, 0.85);
    }

    /* Botón de play gigante */
    .vjs-big-play-button {
        font-size: 3rem !important;
        height: 80px !important;
        width: 80px !important;
        border-radius: 50%;
        background: rgba(255, 193, 7, 0.9) !important; /* amarillo */
        color: #000 !important;
        border: none;
        transition: 0.3s;
    }

    .vjs-big-play-button:hover {
        background: #ffc107 !important;
        transform: scale(1.1);
    }
</style>
@endsection
