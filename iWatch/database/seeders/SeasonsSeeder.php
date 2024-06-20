<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Season;
use App\Models\Film;

class SeasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filmIds = Film::pluck('id')->all();

        for ($i = 0; $i < 10; $i++){
            Season::create([
                'season_name' => 'Season ' . ($i + 1),
                'order' => $i + 1,
                'content_id' => $filmIds[array_rand($filmIds)],
            ]);
        }
    }
}
