<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Home -> listado
Route::get('/', fn () => redirect()->route('peliculas.index'));

// Categorías públicas
Route::get('/peliculas/animadas', [PeliculaController::class, 'animadas'])->name('peliculas.animadas');
Route::get('/peliculas/cartoon',  [PeliculaController::class, 'cartoon'])->name('peliculas.cartoon');
Route::get('/peliculas/normal',   [PeliculaController::class, 'normal'])->name('peliculas.normal');

// Ver detalle
Route::get('/peliculas/{id}/ver', [PeliculaController::class, 'ver'])->name('peliculas.ver');

// Alias para el formulario de solicitud (apunta al controlador correcto)
Route::get('/peliculas/solicitar', fn () => redirect()->route('solicitudes.create'))->name('peliculas.solicitar');

// Solicitudes (público crea)
Route::get('/solicitudes/nueva', [SolicitudController::class, 'create'])->name('solicitudes.create');
Route::post('/solicitudes',      [SolicitudController::class, 'store'])->name('solicitudes.store');

// Panel y acciones de admin
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/panel', [PanelController::class, 'index'])->name('panel');
    Route::patch('/solicitudes/{solicitud}/aprobar',  [SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
    Route::patch('/solicitudes/{solicitud}/rechazar', [SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
});

// Verificador
Route::middleware(['auth', RoleMiddleware::class.':verificador'])
    ->get('/verificaciones', [\App\Http\Controllers\VerificadorController::class, 'index'])
    ->name('verificador.panel');

// Publicador
Route::middleware(['auth', RoleMiddleware::class.':publicador'])->group(function () {
    Route::get('/publicaciones', [\App\Http\Controllers\PublicadorController::class, 'index'])->name('publicador.panel');
    Route::get('/publicar/{solicitud}', [\App\Http\Controllers\PublicadorController::class, 'createFromSolicitud'])->name('publicador.publicar.form');
    Route::post('/publicar/{solicitud}', [\App\Http\Controllers\PublicadorController::class, 'storeFromSolicitud'])->name('publicador.publicar.store');
});
    


// Recurso REST (al final)
Route::resource('peliculas', PeliculaController::class);

// Otros
Route::get('/home', fn () => view('home.home'))->name('home');
Route::get('/test', fn () => view('test'));

// Breeze/Auth
Route::get('/dashboard', fn () => view('dashboard'))->middleware(['auth'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';