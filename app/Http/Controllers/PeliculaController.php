<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;

class PeliculaController extends Controller
{
    // LISTADO + BÚSQUEDA
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

        return view('welcome', ['peliculas' => $peliculas]);
    }

    // SHOW
    public function show($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        return view('peliculas.show', compact('pelicula'));
    }

    // VER PERSONALIZADO
    public function ver($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        return view('peliculas.ver', compact('pelicula'));
    }

    // FILTROS
    public function animadas()
    {
        $peliculas = Pelicula::where('categoria', 'Animada')->get();
        return view('peliculas.animadas', compact('peliculas'));
    }

    public function cartoon()
    {
        $peliculas = Pelicula::where('categoria', 'Cartoon')->get();
        return view('peliculas.cartoon', compact('peliculas'));
    }

    public function normal()
    {
        $peliculas = Pelicula::where('categoria', 'Normal')->get();
        return view('peliculas.normal', compact('peliculas'));
    }

    // --- SOLICITAR PELÍCULA ---

    // GET: muestra el formulario
    public function solicitar()
    {
        return view('peliculas.solicitar');
    }

 
}
