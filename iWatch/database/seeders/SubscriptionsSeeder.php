<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Suscripcion;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Suscripcion::create([
            'name' => 'Básico',
            'description' => 'Amplia variedad de películas y series, incluyendo estrenos recientes, a un precio accesible.',
            'price' => 9.95,
            'duration' => now()->addDays(30)->format('Y-m-d H:i:s'),
            'resolution' => 'SD',
            'quality' => 'Baja',
        ]);

        Suscripcion::create([
            'name' => 'Estándar',
            'description' => 'Diversidad de contenido, desde éxitos de taquilla hasta clásicos, con acceso a lanzamientos recientes.',
            'price' => 14.95,
            'duration' => now()->addDays(60)->format('Y-m-d H:i:s'),
            'resolution' => 'HD',
            'quality' => 'Media',
        ]);

        Suscripcion::create([
            'name' => 'Premium',
            'description' => 'Experiencia única con acceso exclusivo a lanzamientos y clásicos en calidad premium.',
            'price' => 19.95,
            'duration' => now()->addDays(90)->format('Y-m-d H:i:s'),
            'resolution' => '4K',
            'quality' => 'Alta',
        ]);
    }
}
