<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Solicitud;

class PanelController extends Controller
{
    public function index()
    {
        $stats = [
            'peliculas'           => Pelicula::count(),
            'solicitudes_totales' => Solicitud::count(),
            'solicitudes_pend'    => Solicitud::where('estado','pendiente')->count(),
        ];

        $ultimas = Solicitud::latest()->take(10)->get();

        return view('panel.index', compact('stats','ultimas'));
    }
}
