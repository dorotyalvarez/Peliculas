<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class PanelController extends Controller
{
   
// ...

public function index(Request $request)
{
    // Stats
    $stats = [
        'peliculas'           => \App\Models\Pelicula::count(),
        'solicitudes_totales' => \App\Models\Solicitud::count(),
        'solicitudes_pend'    => \App\Models\Solicitud::where('estado','pendiente')->count(),
    ];

    // Filtros
    $estado   = $request->query('estado');                 // pendiente|aprobada|rechazada|null
    $q        = trim((string) $request->query('q'));       // texto a buscar
    $orden    = $request->query('orden', 'desc');          // asc|desc (por fecha)
    $validos  = ['pendiente','aprobada','rechazada'];
    $orden    = in_array(strtolower($orden), ['asc','desc']) ? strtolower($orden) : 'desc';

    $query = \App\Models\Solicitud::query();

    // Estado
    if (in_array($estado, $validos, true)) {
        $query->where('estado', $estado);
    } else {
        $estado = null; // “todas”
    }

    // Búsqueda por nombre / sinopsis / trailer
    if ($q !== '') {
        $query->where(function($qq) use ($q) {
            $qq->where('nombre', 'like', "%{$q}%")
               ->orWhere('sinopsis', 'like', "%{$q}%")
               ->orWhere('trailer_url', 'like', "%{$q}%");
        });
    }

    // Orden por fecha (created_at)
    $query->orderBy('created_at', $orden);

    // Conteos para tabs
    $contadores = [
        'todas'     => \App\Models\Solicitud::count(),
        'pendiente' => \App\Models\Solicitud::where('estado','pendiente')->count(),
        'aprobada'  => \App\Models\Solicitud::where('estado','aprobada')->count(),
        'rechazada' => \App\Models\Solicitud::where('estado','rechazada')->count(),
    ];

    // Paginación (preserva query string)
    $ultimas = $query->paginate(10)->withQueryString();

    return view('panel.index', compact('stats','ultimas','estado','contadores','q','orden'));
}

}