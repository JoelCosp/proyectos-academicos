<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Episode extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    public $timestamps = false;

    protected $fillable = [
        "episode_name",
        "description",
        "duration",
        "order",
        "season_id"
    ];

    // Funciones para establecer las relaciones con la tabla media

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/episodes')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));

        $this->addMediaCollection('videos/episodes');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        if (env('RESIZE_IMAGE') === true) {

            $this->addMediaConversion('resized-image')
                ->width(env('IMAGE_WIDTH', 300))
                ->height(env('IMAGE_HEIGHT', 300));
        }
    }
}
