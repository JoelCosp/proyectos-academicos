<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Film;
use Carbon\Carbon;


class FavoritesController extends Controller
{

    public function index()
    {
        // Obtener los favoritos del usuario actual
        $userId = auth()->user()->id;
        $favoriteFilms = Favorite::where('user_id', $userId)->get();

        return response()->json(['success' => true, 'data' => $favoriteFilms]);
    }

    // Almacenar favorito
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'film_id' => 'required',
        ]);

        $userId = $request->input('user_id');
        $filmId = $request->input('film_id');

        // Verificar si el usuario ya ha marcado esta película como favorita
        $existingFavorite = Favorite::where('user_id', $userId)
                                    ->where('film_id', $filmId)
                                    ->first();

        if ($existingFavorite) {
            return response()->json(['error' => 'Esta película ya está marcada como favorita'], 400);
        }

        // La película no está marcada como favorita, crear el favorito
        $favoriteData = [
            'user_id' => $userId,
            'film_id' => $filmId,
            'creation_date' => Carbon::now()->toDateString()
        ];

        $favorite = Favorite::create($favoriteData);

        return response()->json(['success' => true, 'data' => $favorite]);
    }

    // Eliminar favorito
    public function destroy($id)
    {
        $userId = auth()->user()->id;
        $favorite = Favorite::where('user_id', $userId)
                            ->where('film_id', $id)
                            ->first();

        if (!$favorite) {
            return response()->json(['error' => 'El favorito no existe'], 404);
        }

        $favorite->delete();

        return response()->json(['success' => true, 'message' => 'Favorito eliminado con éxito']);
    }
    // Obtener favoritos de un usuario
    public function getFavoritesByUserId($id) {
        $subquery = Favorite::where('user_id', $id)->select('film_id');
        
        $films = Film::whereIn('id', $subquery)->with('media')->get();
        
        return $films;
    }
    // Obtener solo favoritos
    public function getOnlyFavoriteContent($user_id) {
        // Obtener las películas favoritas del usuario con todas las relaciones de medios
        $favoriteFilms = Film::whereHas('favoritedBy', function($query) use ($user_id) {
            $query->where('users.id', $user_id); // Especifica la tabla 'users' para la columna 'id'
        })
        ->with('media')
        ->get();
        
        return $favoriteFilms;
    }
    // Obtener favoritos de un user segun categoria id
    public function getFavoritesByCats($category_id, $user_id)
{
    // Verificar si se proporcionó un ID de categoría válido
    if ($category_id > 0) {
        $films = Film::join('category_film', 'films.id', '=', 'category_film.film_id')
                     ->where('category_film.category_id', $category_id)
                     ->join('favorites', 'films.id', '=', 'favorites.film_id') // Unir con la tabla de favoritos
                     ->with('media')
                     ->get();

        return $films;
    } else {
        // Obtener las películas favoritas del usuario con todas las relaciones de medios
        $favoriteFilms = Film::whereHas('favoritedBy', function($query) use ($user_id) {
            $query->where('users.id', $user_id); // Especifica la tabla 'users' para la columna 'id'
        })
        ->with('media')
        ->get();
        
        return $favoriteFilms;
    }
}
    
}
