<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula; // Asegúrate de que este sea el nombre de tu modelo

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    if ($request->filled('search')) {
        $search = $request->search;

        $peliculas = Pelicula::where('titulo', 'like', "%{$search}%")
            ->orWhere('descripcion', 'like', "%{$search}%")
            ->orWhere('anio', 'like', "%{$search}%")
            ->orWhere('categoria', 'like', "%{$search}%")
            ->get();
    } else {
        $peliculas = Pelicula::all();
    }

    return view('welcome', ['peliculas' => $peliculas]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $pelicula = Pelicula::findOrFail($id);
    return view('peliculas.show', compact('pelicula'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
 
    public function ver($id)
{
    $pelicula = Pelicula::findOrFail($id);
    return view('peliculas.ver', compact('pelicula'));
}

public function animadas()
{
    // Si el campo en tu tabla se llama 'categoria'
    $peliculas = Pelicula::where('categoria', 'Animada')->get();

    // Si el campo se llama 'genero', cámbialo:
    // $peliculas = Pelicula::where('genero', 'Animada')->get();

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

}

