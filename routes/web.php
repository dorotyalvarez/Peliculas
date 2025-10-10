<?php
use App\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\SolicitudController;

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
    
Route::get('/peliculas/solicitar', [PeliculaController::class, 'solicitar'])
    ->name('peliculas.solicitar');
    


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


// Ruta para ver el formulario de solicitud
Route::get('/solicitudes/nueva', [SolicitudController::class, 'create'])
    ->name('solicitudes.create');

// Ruta para guardar la solicitud
Route::post('/solicitudes', [SolicitudController::class, 'store'])
    ->name('solicitudes.store');

// Ruta temporal de dashboard (para Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->get('/panel', [PanelController::class, 'index'])->name('panel');

require __DIR__.'/auth.php';
