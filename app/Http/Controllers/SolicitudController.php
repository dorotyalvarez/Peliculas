<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{
    // GET /peliculas/solicitar  (muestra el form)
    public function create()
    {
        return view('peliculas.solicitar');
    }

    // POST /peliculas/solicitar  (guarda la solicitud)
    public function store(Request $request)
    {
        $data = $request->validate([
    'nombre'      => 'required|string|max:255|unique:solicitudes,nombre',
    'trailer_url' => 'nullable|url|max:255',
    'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    'banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:6144',
    'sinopsis'    => 'nullable|string|max:2000',
], [
    'nombre.unique' => 'Ya existe una solicitud con ese nombre.',
]);

        $payload = [
            'nombre'      => $data['nombre'],
            'trailer_url' => $data['trailer_url'] ?? null,
            'sinopsis'    => $data['sinopsis'] ?? null,
            'estado'      => 'pendiente',
            // 'user_id'   => optional(auth()->user())->id,
        ];

        if ($request->hasFile('poster')) {
            $payload['poster_path'] = $request->file('poster')->store('solicitudes/posters', 'public');
        }
        if ($request->hasFile('banner')) {
            $payload['banner_path'] = $request->file('banner')->store('solicitudes/banners', 'public');
        }

        Solicitud::create($payload);

        return redirect()
            ->route('solicitudes.create')
            ->with('ok', '🎬 ¡Tu solicitud fue enviada! La revisaremos pronto.');
    }

    // (Opcional) listado admin
    public function index()
    {
        $solicitudes = Solicitud::latest()->paginate(20);
        return view('solicitudes.index', compact('solicitudes'));
    }
}
