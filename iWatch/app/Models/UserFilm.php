<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFilm extends Model
{
    use HasFactory;

    protected $table = 'user_film';

    protected $fillable = [
        'user_id',
        'film_id',
        'viewed_date'
    ];
}
