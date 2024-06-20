<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserFilm;
use App\Models\Film;
use Carbon\Carbon;

/* 

  -- ESTE CONTROLADOR NO SE UTILIZA --

*/

class UserFilmController extends Controller
{
    /*public static function storeViewedFilm($user_id, $film_id)
    {
        
        // Verificar si el registro ya existe
        $existingRecord = UserFilm::where('user_id', $user_id)
                                ->where('film_id', $film_id)
                                ->exists();

        if (!$existingRecord) {
            try {
                UserFilm::create([
                    'user_id' => $user_id,
                    'film_id' => $film_id,
                    'viewed_date' => Carbon::now()->toDateString()
                ]);

                return response()->json(['message' => 'Registro creado exitosamente'], 200);
            
            } catch (\Exception $e) {
                
                return response()->json(['error' => 'Error al crear el registro'], 500);
            }
        } else {
            return response()->json(['message' => 'El usuario ya ha visto esta película'], 200);
        }
    }*/

    public function getUsersViewedFilms($user_id) {

        $viewedFilmIds = UserFilm::where('user_id', $user_id)->pluck('film_id');
    
        $viewedFilms = Film::whereIn('id', $viewedFilmIds)->with('media')->get();
    
        return $viewedFilms;
    }
}
