<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Controllers\Api\FilmsController;
use App\Models\Film;

class FilmsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     */
    public function testIndex()
    {
        // Obtén algunas películas existentes en la base de datos
        $existingFilms = Film::all();

        if ($existingFilms->isEmpty()) {
            $this->markTestSkipped('No hay películas en la base de datos para probar');
        }

        // Crea una instancia del controlador FilmsController
        $controller = new FilmsController();

        // Llama al método index del controlador
        $result = $controller->index();

        // Verifica que el resultado no sea nulo
        $this->assertNotNull($result);

        // Verifica que el resultado sea una instancia de Illuminate\Support\Collection
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);

        // Verifica que el número de películas devueltas es igual al número de películas existentes
        $this->assertCount($existingFilms->count(), $result);
    }

    public function testGetFilmByIdExistingFilm()
    {
        // Obtener una película existente de la base de datos
        $existingFilm = Film::inRandomOrder()->first();

        // Asegurarse de que haya al menos una película en la base de datos
        if (!$existingFilm) {
            $this->markTestSkipped('No hay películas en la base de datos para probar');
        }

        // Crear una instancia del controlador FilmsController
        $controller = new FilmsController();

        // Llamar a la función getFilmById con el ID de la película seleccionada
        $result = $controller->getFilmById($existingFilm->id);

        // Verificar que el resultado no sea nulo
        $this->assertNotNull($result);

        // Verificar que el resultado sea la película seleccionada
        $this->assertEquals($existingFilm->id, $result->id);
    }

    public function testGetFilmByIdNonExistingFilm()
    {
        // ID de una película que no existe
        $nonExistingFilmId = 9999;

        // Crear una instancia del controlador FilmsController
        $controller = new FilmsController();

        // Llamar a la función getFilmById con el ID de la película no existente
        $result = $controller->getFilmById($nonExistingFilmId);

        // Verificar que el resultado sea un mensaje de error y un código de estado 404
        $this->assertEquals(404, $result->status());
        $this->assertEquals('Película no encontrada', $result->getData()->error);
    }
}
