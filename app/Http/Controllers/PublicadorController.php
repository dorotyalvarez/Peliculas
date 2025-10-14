<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PublicadorController extends Controller
{
    /**
     * Lista SOLO solicitudes aprobadas que aún NO se han publicado.
     */
    public function index()
    {
        $solicitudes = Solicitud::where('estado', 'aprobada')
            ->whereNull('publicada_at')   // 👈 clave: sin publicar todavía
            ->latest()
            ->paginate(10);

        return view('publicador.index', compact('solicitudes'));
    }

    /**
     * Formulario de publicación pre-llenado desde una solicitud.
     */
    public function createFromSolicitud(Solicitud $solicitud)
    {
        $data = [
            'titulo'       => $solicitud->nombre,
            'genero'       => null,
            'descripcion'  => $solicitud->sinopsis,
            'anio'         => null,
            'categoria'    => null,
            'imagen'       => $solicitud->poster_path, // solo mostrar
            'banner'       => $solicitud->banner_path, // solo mostrar
            'trailer'      => $solicitud->trailer_url,
            'video_url'    => null,
            'video_backup' => null,
        ];

        return view('publicador.publicar', compact('solicitud', 'data'));
    }

    /**
     * Publica: copia assets, crea película y marca solicitud como publicada (sin tocar estado).
     */
    public function storeFromSolicitud(Request $request, Solicitud $solicitud)
    {
        $val = $request->validate([
            'titulo'       => ['required', 'string', 'max:255'],
            'genero'       => ['nullable', 'string', 'max:255'],
            'descripcion'  => ['nullable', 'string'],
            'anio'         => ['nullable', 'digits:4'],
            'categoria'    => ['nullable', 'string', 'max:255'],
            'trailer'      => ['nullable', 'url'],
            'video_url'    => ['nullable', 'url'],
            'video_backup' => ['nullable', 'url'],
        ]);

        return DB::transaction(function () use ($val, $solicitud) {
            // 1) Copiar poster y banner desde 'solicitudes/*' a sus carpetas finales
            $posterFinal = $this->copyIfExists($solicitud->poster_path, 'posters');
            $bannerFinal = $this->copyIfExists($solicitud->banner_path, 'banners');

            // 2) Crear película
            $pelicula = Pelicula::create([
                'titulo'       => $val['titulo'],
                'genero'       => $val['genero']       ?? null,
                'descripcion'  => $val['descripcion']  ?? $solicitud->sinopsis,
                'anio'         => $val['anio']         ?? date('Y'),   // evita NULL si tu columna no es nullable
                'categoria'    => $val['categoria']    ?? 'película',
                'imagen'       => $posterFinal,
                'banner'       => $bannerFinal,
                'trailer'      => $val['trailer']      ?? $solicitud->trailer_url,
                'video_url'    => $val['video_url']    ?? null,
                'video_backup' => $val['video_backup'] ?? null,
            ]);

            // 3) Marcar solicitud como publicada (sin tocar estado)
            $solicitud->update([
                'publicada_at' => now(),
                'publicada_por' => auth()->id(),   // requiere sesión iniciada (ya la tienes)
                // 'estado' => 'aprobada',          // NO cambiar ENUM
            ]);

            return redirect()
                ->route('publicador.panel')
                ->with('ok', 'Película publicada: ' . $pelicula->titulo);
        });
    }

    /**
     * Copia un archivo del disk 'public' si existe, a una carpeta destino.
     * Devuelve el path final (relativo al disk) o null.
     */
    private function copyIfExists(?string $origen, string $carpetaDestino): ?string
    {
        if (!$origen) return null;

        if (!Storage::disk('public')->exists($origen)) {
            return null;
        }

        $nombre = basename($origen);
        $destino = rtrim($carpetaDestino, '/') . '/' . $nombre;

        // Evitar sobrescribir
        if (Storage::disk('public')->exists($destino)) {
            $destino = rtrim($carpetaDestino, '/') . '/' . uniqid() . '-' . $nombre;
        }

        Storage::disk('public')->makeDirectory($carpetaDestino);
        Storage::disk('public')->copy($origen, $destino);

        return $destino;
    }
}
