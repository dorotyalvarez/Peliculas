<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;

class PeliculaController extends Controller
{
    /**
     * LISTADO + BÚSQUEDA
     */
    public function index(Request $request)
    {
        $peliculas = Pelicula::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = trim($request->search);
                $q->where(function ($w) use ($s) {
                    $w->where('titulo', 'like', "%{$s}%")
                      ->orWhere('descripcion', 'like', "%{$s}%")
                      ->orWhere('anio', 'like', "%{$s}%")
                      ->orWhere('categoria', 'like', "%{$s}%");
                });
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('welcome', compact('peliculas'));
    }

    /**
     * DETALLE (SHOW)
     * Usa route model binding.
     */
 public function show(Pelicula $pelicula)   // ← binding para {pelicula}
{
    return view('peliculas.show', compact('pelicula'));
}

public function ver($id)                   // ← {id} simple
{
    $pelicula = Pelicula::findOrFail($id);
    return view('peliculas.ver', compact('pelicula'));
}

    /**
     * FILTROS POR CATEGORÍA
     */
    public function animadas()
    {
        $peliculas = Pelicula::where('categoria', 'Animada')
            ->latest('id')->get();

        return view('peliculas.animadas', compact('peliculas'));
    }

    public function cartoon()
    {
        $peliculas = Pelicula::where('categoria', 'Cartoon')
            ->latest('id')->get();

        return view('peliculas.cartoon', compact('peliculas'));
    }

    public function normal()
    {
        $peliculas = Pelicula::where('categoria', 'Normal')
            ->latest('id')->get();

        return view('peliculas.normal', compact('peliculas'));
    }

    /**
     * FORMULARIO DE SOLICITUD (si lo quieres aquí)
     * Nota: La creación/guardado de solicitudes lo maneja SolicitudController.
     */
    public function solicitar()
    {
        return view('peliculas.solicitar');
    }
    // PeliculaController.php




}
