<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitudes';

    protected $fillable = [
        'nombre','trailer_url','poster_path','banner_path',
        'sinopsis','estado','user_id','revisado_por','nota_revisor',
        'publicada_at','publicada_por',
    ];
}