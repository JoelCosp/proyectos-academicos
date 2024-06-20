<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\SuscripcionFilm;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class SuscripcionsFilmsController extends Controller
{
    /*public static function getUserSubscriptionInfo($id)
    {
        $subscriptionInfo = DB::table('user_subscriptions')
                                ->where('user_id', $id)
                                ->first();

        if (!$subscriptionInfo) {
            return response()->json(['error' => 'Suscripción de usuario no encontrada'], 404);
        }

        // Devolver solo la información de la suscripción
        return response()->json($subscriptionInfo);
    }*/

    public static function getInfoSubscriptionFilm($id)
    {
        $filmInfoSub = DB::table('suscripcion_film')
                                ->where('film_id', $id)
                                ->get();

        if (!$filmInfoSub) {
            return response()->json(['error' => 'Suscripción de usuario no encontrada'], 404);
        }

        // Devolver solo la información de la suscripción
        return response()->json($filmInfoSub);
    }
}
