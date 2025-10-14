<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    'banner',        // 👈 este
    'trailer',
    'video_url',
    'video_backup',
];

}