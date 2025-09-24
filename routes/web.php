<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculaController;

// Página principal redirige al listado de películas
Route::get('/', function () {
    return redirect()->route('peliculas.index');
});

// Rutas personalizadas de películas
Route::get('/peliculas/animadas', [PeliculaController::class, 'animadas'])
    ->name('peliculas.animadas');

Route::get('/peliculas/cartoon', [PeliculaController::class, 'cartoon'])
    ->name('peliculas.cartoon');

Route::get('/peliculas/normal', [PeliculaController::class, 'normal'])
    ->name('peliculas.normal');

Route::get('/peliculas/{id}/ver', [PeliculaController::class, 'ver'])
    ->name('peliculas.ver');

// Recurso REST de películas (debe ir al final)
Route::resource('peliculas', PeliculaController::class);

// Ruta home
Route::get('/home', function () {
    return view('home.home');
})->name('home');

// Ruta test
Route::get('/test', function () {
    return view('test');
});
