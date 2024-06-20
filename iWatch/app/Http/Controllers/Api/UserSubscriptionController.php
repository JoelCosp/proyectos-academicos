<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use Carbon\Carbon; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserSubscriptionController extends Controller
{
    // Realizar la suscripcion del usuario
    public function subscribe(Request $request, $subscriptionId)
    {
        $user = Auth::user();
        $days= $request->input("days");
        
        // Sincronizar la suscripción para el usuario
        $user->suscripcions()->sync([$subscriptionId]);

        // Obtener la suscripción asociada al usuario
        $subscription = $user->suscripcions()->where('suscripcion_id', $subscriptionId)->first();

        // Obtener la fecha actual
        $today = Carbon::today();

        // Calcular la fecha de finalización basada en la duración
        $endDate = $today->copy()->addDays($days);

        // Actualizar las fechas de inicio y finalización de la suscripción
        $subscription->pivot->start_date = $today;
        $subscription->pivot->end_date = $endDate;
        $subscription->pivot->save();
    }

    // Obtener la info del user en la tabla user_subscriptions
    public static function getUserSubscriptionInfo($id)
    {
        $subscriptionInfo = DB::table('user_subscriptions')
                                ->where('user_id', $id)
                                ->first();

        if (!$subscriptionInfo) {
            return response()->json(['error' => 'Suscripción de usuario no encontrada'], 404);
        }

        // Devolver solo la información de la suscripción
        return response()->json($subscriptionInfo);
    }
}
