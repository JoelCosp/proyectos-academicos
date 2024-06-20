<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'categories';

    protected $fillable = [
        "name"
    ];

    // Relacion con la tabla films
    public function films()
    {
        return $this->belongsToMany(Film::class, 'category_film', 'category_id', 'film_id');
    }
}
