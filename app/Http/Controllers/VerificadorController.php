<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;

class VerificadorController extends Controller
{
    public function index()
    {
        // Ejemplo: ver solo solicitudes pendientes
        $solicitudes = Solicitud::where('estado', 'pendiente')
            ->latest()
            ->paginate(10);

        return view('verificador.index', compact('solicitudes'));
    }
}
