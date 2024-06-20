<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionsController extends Controller
{
    //
    public function index(){

        $subscriptions = Subscription::all()->toArray();
        return $subscriptions;
    }

    // Crear subscription
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);

        $subscriptionData = $request->all();
        $subscription = Subscription::create($subscriptionData);

        return response()->json(['success' => true, 'data' => $subscription]);
    }

    // Eliminar subscription
    public function destroy($id){
        $subscriptionDelete = Subscription::find($id);
        $subscriptionDelete->delete();
        return response()->json(['success' => true, 'data' => 'subscription eliminada correctamente']);
    }

    // Actualizar subscription
    public function update($id, Request $request){
        $subscription = Subscription::find($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $subscription->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $subscription]);
    }
}
