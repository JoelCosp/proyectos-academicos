<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $numFilms = 20;

        // Usa un bucle para crear filas aleatorias
        for ($i = 0; $i < $numFilms; $i++) {
            $film = Film::factory()->create();

            $media = Media::inRandomOrder()->first();
        if ($media) {
            $film->addMediaFromUrl($media->getUrl())->toMediaCollection();
        }
        }
    }
}
