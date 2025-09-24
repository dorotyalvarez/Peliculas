@extends('layouts.app')

@section('title', 'Películas Animadas')

@section('content')
<!-- tarjetas con datos de la base de datos -->
<div class="container my-5">
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
        @foreach($peliculas as $pelicula)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 tarjeta-pelicula" style="max-width: 160px; margin: auto;">
                    <div class="img-container">
                        <img src="{{ $pelicula->imagen ?? 'https://via.placeholder.com/200x300?text=Sin+Imagen' }}" 
                             class="card-img-top rounded"
                             alt="{{ $pelicula->titulo }}">
                    </div>
                    <div class="card-body text-center p-2">
                        <h6 class="card-title mb-2 text-truncate" style="font-size: 0.85rem;" title="{{ $pelicula->titulo }}">
                            {{ $pelicula->titulo }}
                        </h6>
                        <a href="{{ route('peliculas.show', $pelicula->id) }}" 
                           class="btn btn-sm btn-warning w-100">
                            🎬 Ver
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .tarjeta-pelicula .img-container {
        overflow: hidden;
        border-radius: 10px;
    }

    .tarjeta-pelicula img {
        height: 220px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .tarjeta-pelicula:hover img {
        transform: scale(1.1);
    }

    .tarjeta-pelicula:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>
@endsection
