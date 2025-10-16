<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Pelicula extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'genero',
        'descripcion',
        'anio',
        'categoria',
        'imagen',
        'banner',
        'trailer',
        'video_url',     // URL externa
        'video_backup',  // URL externa backup
        'video_path',    // ← ruta relativa local (videos/xxx.mp4) — si ya creaste la columna
    ];

    /* ---------- Posters/Banners ---------- */

    public function getPosterUrlAttribute(): ?string
    {
        $v = $this->imagen;
        if (!$v) return null;
        return Str::startsWith($v, ['http://','https://']) ? $v : Storage::url($v);
    }

    public function getBannerUrlAttribute(): ?string
    {
        $v = $this->banner;
        if (!$v) return null;
        return Str::startsWith($v, ['http://','https://']) ? $v : Storage::url($v);
    }

    public function getPosterOrDefaultAttribute(): string
    {
        return $this->poster_url ?? asset('images/default-poster.jpg');
    }

    /* ---------- Video: fuente unificada ---------- */

    /**
     * URL final que debe consumir el reproductor:
     * - Si hay video local (video_path) => /storage/videos/xxx.mp4
     * - Si no, usa video_url externa (http/https)
     * - Si no, null
     */
    public function getVideoSrcAttribute(): ?string
    {
        if (!empty($this->video_path)) {
            return Storage::url($this->video_path); // ej: /storage/videos/uuid.mp4
        }

        if (!empty($this->video_url) && Str::startsWith($this->video_url, ['http://','https://'])) {
            return $this->video_url;
        }

        return null;
    }

    /**
     * Fuente alternativa (si quieres usarla como backup en el player):
     * - Prioriza backup local si algún día tienes video_path_backup
     * - Si no, devuelve video_backup si es http/https
     */
    public function getVideoBackupSrcAttribute(): ?string
    {
        if (!empty($this->video_backup) && Str::startsWith($this->video_backup, ['http://','https://'])) {
            return $this->video_backup;
        }
        return null;
    }

    /** Helper opcional */
    public function hasLocalVideo(): bool
    {
        return !empty($this->video_path);
    }
}
