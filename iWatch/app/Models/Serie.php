<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// ESTE MODELO NO SE UTILIZA

class Serie extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "name",
        "synopsis",
        "director",
        "punctuation",
        "episodes",
        "duration",
        "seasons",
        "video",
        "poster"
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/series')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
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
