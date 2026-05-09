<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicadorController extends Controller
{
    /**
     * Lista SOLO solicitudes aprobadas que aún NO se han publicado.
     */
    public function index()
    {
        $solicitudes = Solicitud::where('estado', 'aprobada')
            ->whereNull('publicada_at')
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
            'imagen'       => $solicitud->poster_path, // para previsualizar
            'banner'       => $solicitud->banner_path, // para previsualizar
            'trailer'      => $solicitud->trailer_url,
            'video_url'    => null,
            'video_backup' => null,
        ];

        return view('publicador.publicar', compact('solicitud', 'data'));
    }

    /**
     * Publica: guarda/copía assets a publicar/*, crea película y marca solicitud como publicada.
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
    'video_url'    => ['nullable', 'url'],      // principal externa
    'video_backup' => ['nullable', 'url'],      // 🔁 backup externa

    'video_file'        => ['nullable','file','mimetypes:video/mp4,video/webm,video/ogg','max:4194304'], // principal local
    'video_backup_file' => ['nullable','file','mimetypes:video/mp4,video/webm,video/ogg','max:4194304'], // 🔁 backup local

    'poster'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
    'banner'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:6144'],
]);
        return DB::transaction(function () use ($request, $val, $solicitud) {

            // 1) Guardar/duplicar imágenes a publicar/*
            $posterFinal = $this->storeOrCopyToPublicar(
                $request,
                inputName: 'poster',
                fallbackOrigen: $solicitud->poster_path,
                subcarpeta: 'posters'
            ); // publicar/posters/... | https://... | null

            $bannerFinal = $this->storeOrCopyToPublicar(
                $request,
                inputName: 'banner',
                fallbackOrigen: $solicitud->banner_path,
                subcarpeta: 'banners'
            ); // publicar/banners/... | https://... | null

            // 2) Si subieron un video local, guardarlo en storage/app/public/videos
            $videoPath = null; // ruta relativa tipo "videos/xxxx.mp4"
            if ($request->hasFile('video_file')) {
                $videoPath = $request->file('video_file')->store('videos', 'public');
            }
            // 2) videos locales (principal y backup)
$videoPath = null;        // principal local → videos/...
$videoBackupUrl = $val['video_backup'] ?? null; // por defecto: URL externa

if ($request->hasFile('video_file')) {
    $videoPath = $request->file('video_file')->store('videos', 'public');
}

// 🔁 si suben backup local, lo guardamos y lo usamos como backup (sin migración extra)
if ($request->hasFile('video_backup_file')) {
    $stored = $request->file('video_backup_file')->store('videos', 'public'); // videos/xxx.mp4
    // Como tu modelo tiene video_backup (URL), ponemos la URL pública para que el player la pueda usar
    $videoBackupUrl = Storage::disk('public')->url($stored); // => /storage/videos/xxx.mp4
}

            // 3) Crear película (video_path tendrá prioridad en el reproductor via accessor)
           $pelicula = Pelicula::create([
    'titulo'       => $val['titulo'],
    'genero'       => $val['genero']       ?? null,
    'descripcion'  => $val['descripcion']  ?? $solicitud->sinopsis,
    'anio'         => $val['anio']         ?? date('Y'),
    'categoria'    => $val['categoria']    ?? 'película',
    'imagen'       => $posterFinal,
    'banner'       => $bannerFinal,
    'trailer'      => $val['trailer']      ?? $solicitud->trailer_url,

    // principal
    'video_url'    => $val['video_url']    ?? null,
    'video_path'   => $videoPath,                // local (si lo subieron)

    // 🔁 backup
    'video_backup' => $videoBackupUrl,           // URL externa o /storage/videos/... si subieron archivo
]);
            // 4) Marcar solicitud como publicada
            $solicitud->update([
                'publicada_at'  => now(),
                'publicada_por' => optional(auth()->user())->id,
            ]);

            return redirect()
                ->route('publicador.panel')
                ->with('ok', 'Película publicada: ' . $pelicula->titulo);
        });
    }

    /**
     * Guarda un archivo subido en publicar/{subcarpeta} o, si no hay archivo,
     * copia el origen (de storage público) a publicar/{subcarpeta}. Si el origen
     * es URL externa, la devuelve tal cual. Retorna ruta relativa o URL.
     */
    private function storeOrCopyToPublicar(
        Request $request,
        string $inputName,
        ?string $fallbackOrigen,
        string $subcarpeta
    ): ?string {
        $disk = Storage::disk('public');

        // A) si suben archivo nuevo
        if ($request->hasFile($inputName)) {
            return $request->file($inputName)->store("publicar/{$subcarpeta}", 'public');
        }

        // B) si no suben archivo, usar origen de solicitud
        if (!$fallbackOrigen) {
            return null;
        }

        // URL externa → devolverla
        if (Str::startsWith($fallbackOrigen, ['http://', 'https://'])) {
            return $fallbackOrigen;
        }

        // archivo existente en disk public → copiar a publicar/*
        if ($disk->exists($fallbackOrigen)) {
            $nombre     = basename($fallbackOrigen);
            $destFolder = 'publicar/' . trim($subcarpeta, '/');
            $destino    = $destFolder . '/' . $nombre;

            if ($disk->exists($destino)) {
                $destino = $destFolder . '/' . uniqid() . '-' . $nombre;
            }

            $disk->makeDirectory($destFolder);
            $disk->copy($fallbackOrigen, $destino);

            return $destino;
        }

        return null;
    }
}
