<?php

namespace Database\Factories;

use App\Models\Film;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    protected $model = Film::class;

    public function definition()
    {
        $media = Media::inRandomOrder()->first();

        return [
            'name' => $this->faker->sentence,
            'synopsis' => $this->faker->paragraph,
            'director' => $this->faker->name,
            'punctuation' => $this->faker->numberBetween(0, 10),
            'duration' => $this->faker->time('H:i:s'),
            'episodes' => $this->faker->numberBetween(1, 20),
            'seasons' => $this->faker->numberBetween(1, 10),
            'type' => $this->faker->word,
            'categoria_id' => $this->faker->numberBetween(1, 10), 
            'thumbnail' => $media->original_url,
        ];
    }
}
