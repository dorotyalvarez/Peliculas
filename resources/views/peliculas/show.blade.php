@extends('layouts.app')

@section('title', $pelicula->titulo)

@section('content')
<main class="container py-5 text-light">
    <div class="row">
        <!-- Poster grande -->
        <div class="col-md-4">
            <img src="{{ asset($pelicula->imagen) }}" 
                 alt="Poster de {{ $pelicula->titulo }}" 
                 class="img-fluid rounded shadow">
        </div>

        <!-- Info -->
        <div class="col-md-8">
            <h2>{{ $pelicula->titulo }}</h2>
            <p class="text-muted">
                Género: {{ $pelicula->genero ?? 'no tiene' }} | 
                Año: {{ $pelicula->anio }}
            </p>
            <p>{{ $pelicula->descripcion }}</p>

            <!-- Tráiler (YouTube embed o fallback) -->
            @php
                $raw = $pelicula->trailer ?? '';
                $embedUrl = null;
                $youtubeWatch = null;
                if (!empty($raw)) {
                    if (preg_match('/youtu\.be\/([^\?\/\&]+)/', $raw, $m)) {
                        $id = $m[1];
                    } elseif (preg_match('/[?&]v=([^&]+)/', $raw, $m)) {
                        $id = $m[1];
                    } elseif (preg_match('/embed\/([^&?\/]+)/', $raw, $m)) {
                        $id = $m[1];
                    } else {
                        $id = null;
                    }

                    if (!empty($id)) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $id;
                        $youtubeWatch = 'https://www.youtube.com/watch?v=' . $id;
                    }
                }
            @endphp

            @if($embedUrl)
                <div class="ratio ratio-16x9 my-4">
                    <iframe src="{{ $embedUrl }}"
                            title="Tráiler de {{ $pelicula->titulo }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy"></iframe>
                </div>
                <p class="small text-muted">
                    Si no ves el reproductor, 
                    <a href="{{ $youtubeWatch }}" target="_blank" rel="noopener">
                        mirar en YouTube
                    </a>.
                </p>
            @else
                <div class="alert alert-secondary my-4">
                    <strong>Tráiler no disponible</strong>.
                    @if(!empty($raw))
                        <span>(URL guardada: <code>{{ $raw }}</code>)</span>
                        — <a href="{{ $raw }}" target="_blank" rel="noopener">abrir enlace</a>
                    @endif
                </div>
            @endif

            <!-- Botón futuro para ver la película completa -->
            
            <a href="{{ route('peliculas.ver', $pelicula->id) }}" class="btn btn-warning">🎬 Ver película</a>
        </div>
    </div>
</main>
@endsection
