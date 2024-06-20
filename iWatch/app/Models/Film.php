<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use App\Models\User;
use App\Models\UserFilm;
use App\Models\Categoria;
use App\Models\Suscripcion;

class Film extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    public $timestamps = false;

    protected $fillable = [
        "name",
        "synopsis",
        "director",
        "duration",
        "episodes",
        "seasons",
        "type",
        "required_subscription_level",
    ];

    // Funciones para establecer relaciones con la tabla media

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/films')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));

        $this->addMediaCollection('images2/films')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));

        $this->addMediaCollection('videos/films');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        if (env('RESIZE_IMAGE') === true) {

            $this->addMediaConversion('resized-image')
                ->width(env('IMAGE_WIDTH', 300))
                ->height(env('IMAGE_HEIGHT', 300));
        }
    }

    // Funciones para establecer las relaciones con las tablas favoritos, categorias, suscripciones y usuarios

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'film_id', 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Categoria::class, 'category_film', 'film_id', 'category_id');
    }

    public function suscripcions()
    {
        return $this->belongsToMany(Suscripcion::class, 'suscripcion_film', 'film_id', 'suscripcion_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_film', 'film_id', 'user_id');
    }
}
