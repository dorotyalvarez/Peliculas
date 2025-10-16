@extends('layouts.bootstrap')

@section('title', 'Bienvenido a Películas Web')

@section('content')
    <div class="d-flex justify-content-center mt-4">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" style="max-width: 900px; border-radius: 10px; overflow: hidden;">

        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner text-center">
            <div class="carousel-item active">
                <img src="Img/Posters/1500x300 Poster Encanto.png" class="d-block w-100" alt="Encanto">
                <div class="p-3 bg-dark text-light">
                    <h5 class="text-warning">Encanto</h5>
                    <p>Cuenta la historia de una familia extraordinaria, los Madrigal.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Img/Posters/1500x300 Poster Spider-Man.png" class="d-block w-100" alt="Spider-Man">
                <div class="p-3 bg-dark text-light">
                    <h5 class="text-warning">Spider-Man: Cruzando el Multiverso</h5>
                    <p>Tras reencontrarse con Gwen Stacy, el amigable vecindario de Spider-Man de Brooklyn.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Img/Posters/1500x300 Poster Deadpool y Lobezno.png" class="d-block w-100" alt="Deadpool">
                <div class="p-3 bg-dark text-light">
                    <h5 class="text-warning">Deadpool 3</h5>
                    <p>La tercera entrega con Deadpool y Lobezno juntos.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Img/Posters/1500x300 Poster Dune parte dos.png" class="d-block w-100" alt="Dune Parte Dos">
                <div class="p-3 bg-dark text-light">
                    <h5 class="text-warning">Dune: Parte Dos</h5>
                    <p>Tras los sucesos de la primera parte acontecidos en el planeta Arrakis.</p>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>




<!-- tarjetas con datos de la base de datos -->
<div class="container my-5">
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
    @forelse($peliculas as $pelicula)
      <div class="col">
        <div class="card h-100 shadow-sm border-0 tarjeta-pelicula" style="max-width:160px;margin:auto;">
          <div class="img-container">
            <img
              src="{{ $pelicula->poster_url ?? 'https://via.placeholder.com/200x300?text=Sin+Imagen' }}"
              class="card-img-top rounded"
              alt="{{ $pelicula->titulo }}"
            >
          </div>
          <div class="card-body text-center p-2">
            <h6 class="card-title mb-2 text-truncate" style="font-size:.85rem;" title="{{ $pelicula->titulo }}">
              {{ $pelicula->titulo }}
            </h6>
            <a href="{{ route('peliculas.show', $pelicula->id) }}" class="btn btn-sm btn-warning w-100">🎬 Ver</a>
          </div>
        </div>
      </div>
    @empty
      <!-- tu bloque de “sin resultados” igualito -->
      <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height:10vh;background:#111;">
        <div class="text-center p-5 bg-dark rounded shadow-lg border border-warning">
          <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Sin resultados" width="120" class="mb-4 opacity-75">
          <h2 class="text-warning mb-3">😢 No se encontraron resultados</h2>
          <p class="text-light">Prueba con otro <strong>título</strong>, <strong>categoría</strong> o <strong>descripción</strong>.</p>
        </div>
      </div>
    @endforelse
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
     
    /*no resultado*/
    

</style>




@endsection



