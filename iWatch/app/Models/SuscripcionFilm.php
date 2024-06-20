<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuscripcionFilm extends Model
{
    use HasFactory;

    protected $table = 'suscripcion_film';

    protected $fillable = [
        'suscripcion_id',
        'film_id'
    ];
}
