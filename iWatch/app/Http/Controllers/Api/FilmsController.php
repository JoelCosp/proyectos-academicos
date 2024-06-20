<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Categoria;
use App\Models\Suscripcion;
use App\Models\UserFilm;
use App\Models\User;
use Carbon\Carbon;

class FilmsController extends Controller
{
    // Listar peliculas
    public function index(){
        $films = Film::with('media')->get();

        return $films;
    }

    public function getOnlyFilmsContent(){
        $filmsOnly = Film::with('media')->where('type', 'film')->get();
    
        return $filmsOnly;
    }

    public function getOnlySeriesContent(){
        $filmsOnly = Film::with('media')->where('type', 'serie')->get();
    
        return $filmsOnly;
    }

    // Listar series
    public function getSeries(){
        $series = Film::with('media')
                 ->where('type', '=','serie')
                 ->get();

        return $series;
    }
    // Obtener peli segun categorias
    public function getFilmByCat($id){
        $filmByCat = Film::with('media')->where('categoria_id', $id)->get();
        return $filmByCat;
    }
    // Obtener peliculas segun categorias
    public function getFilmsByCats($id)
    {
        if ($id > 0) {
            $query = Film::select('films.*')
                ->join('category_film', 'films.id', '=', 'category_film.film_id')
                ->where('category_film.category_id', $id)
                ->where('films.type', 'film') // Additional where condition for type
                ->with('media');

            $films = $query->get();

            return $films;
        } else {
            $films = Film::with('media')->where('type', 'film')->get();
            return $films;
        }
    }
    // Obtener series segun categorias
    public function getSeriesByCats($id)
    {
        if ($id > 0) {
            $query = Film::select('films.*')
                ->join('category_film', 'films.id', '=', 'category_film.film_id')
                ->where('category_film.category_id', $id)
                ->where('films.type', 'serie') // Additional where condition for type
                ->with('media');

            $films = $query->get();

            return $films;
        } else {
            $films = Film::with('media')->where('type', 'serie')->get();
            return $films;
        }
    }
    
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'synopsis' => 'required',
            'director' => 'required',
            'duration' => 'required',
            'episodes' => 'required',
            'seasons' => 'required',
            'type' => 'required',
            'suscripcion_id' => 'array',
            'categoria_id' => 'array', // Asegúrate de validar que el campo es un array
        ]);
    
        // Crea la película
        $filmData = $request->except(['categoria_id', 'thumbnail', 'thumbnail2', 'video']);
        $filmData['punctuation'] = 0;
        $peli = Film::create($filmData);
    
        // Asigna las categorías
        $creationDate = now()->toDateString();
        $categorias = $request->input('categoria_id', []);
        $peli->categories()->attach($categorias, ['creation_date' => $creationDate]);

        $suscripcion = $request->input('suscripcion_id', []);
        $peli->suscripcions()->attach($suscripcion);
    
        // Maneja la carga de medios
        if ($request->hasFile('thumbnail')) { 
            $peli->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-films');
        }
    
        if ($request->hasFile('thumbnail2')) { 
            $peli->addMediaFromRequest('thumbnail2')->preservingOriginal()->toMediaCollection('images2-films');
        }
        
        if ($request->hasFile('video')) {
            $peli->addMediaFromRequest('video')
                ->preservingOriginal()
                ->toMediaCollection('videos-films', 'video');
        }
    
        return response()->json(['success' => true, 'data' => $peli]);
    }
    

    // Eliminar pelicula
    public function destroy($id){
        $filmDelete = Film::find($id);
        $filmDelete->delete();
        return response()->json(['success' => true, 'data' => 'Serie eliminada correctamente']);
    }

    // Actualizar pelicula
    public function update($id, Request $request){
        $film = Film::find($id);

        $request->validate([
            'name' => 'required',
            'synopsis' => 'required',
            'director' => 'required',
            'punctuation' => 'required',
            'duration' => 'required',
            'video' => 'video',
            'poster' => 'poster'
        ]);

        $dataToUpdate = $request->all();
        $film->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $film]);
    }
    // Obtener pelicula segun el id
    public function getFilmById($id) {
        $film = Film::with('media')->find($id);
    
        if (!$film) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }
    
        return $film;
    }
    // Obtener el nombre de la serie segun el id
    public static function getSeriesNameById($id)
    {
        $serie = Film::find($id);

        if (!$serie) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }

        return response()->json(['name' => $serie->name]);
    }
    // Obtener nombres de las series
    public function getAllSeriesNames()
    {
        $series = Film::where('type', 'serie')->orderBy('name')->select('id', 'name')->get();
        return $series;
    }

    public function getFilmsIds()
    {
        $movieIds = Film::pluck('id')->toArray();
        return $movieIds;
    }
    // Obtener ultimas 5 novedades
    public function getNews(){
        // Obtener los últimos 5 registros de películas con sus medios asociados
        $news = Film::with('media')->orderBy('id', 'desc')->take(5)->get();
    
        return $news;
    }
    // Obtener pelicula random 
    public function getRandomFilm()
    {
        $randomFilm = Film::with('media')->inRandomOrder()->first();
        return $randomFilm;
    }
    // Obtener la ultima pelicula insertada
    public function getLastInsertedFilmId() {
        $lastInsertedFilm = Film::orderBy('id', 'desc')->first(); // Ordena por id de forma descendente
        return $lastInsertedFilm->id; // Retorna el ID del último registro insertado
    }
    
    // Relacionar pelicula con categoria mediante el attach
    public function addFilmCategoryRelation($filmId, $categoryId)
    {
        // Verificar si existen la película y la categoría
        $film = Film::find($filmId);
        $category = Categoria::find($categoryId);

        if (!$film || !$category) {
            return response()->json(['error' => 'Película o categoría no encontrada'], 404);
        }

        // Añadir la relación en la tabla pivot
        $film->categories()->attach($category);

        return response()->json(['success' => 'Relación película-categoría añadida exitosamente']);
    }
    // Relacionar pelicula con suscripcion mediante el attach
    public function addFilmSuscripcionRelation($filmId, $suscripcionId)
    {
        // Verificar si existen la película y la categoría
        $film = Film::find($filmId);
        $suscripcion = Suscripcion::find($suscripcionId);

        if (!$film || !$suscripcion) {
            return response()->json(['error' => 'Película o categoría no encontrada'], 404);
        }

        // Añadir la relación en la tabla pivot
        $film->suscripcions()->attach($suscripcion);

        return response()->json(['success' => 'Relación película-categoría añadida exitosamente']);
    }

    // Buscar pelis en el buscador
    public function getFilmContentByContentName($name) {
        $contents = Film::where('films.name', 'like', '%' . $name . '%')
                        ->where('type', 'film')
                        ->with('media')
                        ->get();
    
        if ($contents->isEmpty()) {
            return [];
        }
        return $contents;
    }

    // Buscar series en el buscador
    public function getSerieContentByContentName($name) {
        $contents = Film::where('films.name', 'like', '%' . $name . '%')
                        ->where('type', 'serie')
                        ->with('media')
                        ->get();
    
        if ($contents->isEmpty()) {
            return [];
        }
        return $contents;
    }
    // Funcion para filtrar favoritos segun el nombre que se le pasa 
    public function getFavoriteContentByContentName($name) {
        $contents = Film::where('films.name', 'like', '%' . $name . '%')
                        ->with('media')
                        ->get();
    
        if ($contents->isEmpty()) {
            return [];
        }
        return $contents;
    }

    public function getContentByContentCategoryId($id) {
        $contents = Film::where('films.id', 'like', '%' . $name . '%')
                        ->with('media') // Incluye la relación media
                        ->get();
    
        if ($contents->isEmpty()) {
            return [];
        }
        return $contents;
    }

    public function getContByContId($c_id)
{
    $cont = Film::with('media')
                 ->with('categories')
                 ->where('id', $c_id)
                 ->first();

    return response()->json($cont);
}
// Eliminar pelicula se SEGUIR VIENDO
public function deleteViewedFilm($id){
    $userId = auth()->user()->id;
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    // Utiliza el método detach para eliminar la película vista de la tabla pivote
    $user->films()->detach($id);

    return response()->json(['success' => true, 'message' => 'Película vista eliminada con éxito']);
}
    
// Insertar pelicula en SEGUIR VIENDO 
public function storeViewedFilm($user_id, $film_id)
{
    // Obtener la película
    $film = Film::find($film_id);

    if (!$film) {
        return response()->json(['error' => 'Película no encontrada'], 404);
    }

    // Verificar si el usuario ya ha visto esta película
    if ($film->users()->where('user_id', $user_id)->exists()) {
        return response()->json(['message' => 'El usuario ya ha visto esta película'], 200);
    }

    try {
        // Añadir el registro usando attach
        $film->users()->attach($user_id, ['viewed_date' => Carbon::now()->toDateString()]);

        return response()->json(['message' => 'Película vista registrada exitosamente'], 200);
    
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al registrar la película vista'], 500);
    }
}

}
