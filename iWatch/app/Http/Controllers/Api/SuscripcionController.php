<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Http\Resources\SuscripcionResource;

class SuscripcionController extends Controller
{
    //
    public function index(){

        $suscripciones = Suscripcion::all()->toArray();
        return $suscripciones;
    }

    public function indexSuscripcions(){
        $suscripcions = Suscripcion::
            when(request('search_id'), function ($query) {
                $query->where('id', request('search_id'));
            })
            ->when(request('search_title'), function ($query) {
                $query->where('name', 'like', '%'.request('search_title').'%');
            })
            ->when(request('search_global'), function ($query) {
                $query->where(function($q) {
                    $q->where('id', request('search_global'))
                        ->orWhere('name', 'like', '%'.request('search_global').'%');

                });
            })
            ->paginate(50);
        return SuscripcionResource::collection($suscripcions);
    }

    // Crear suscripcion
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);

        $suscripcionData = $request->all();
        $suscripcion = Suscripcion::create($suscripcionData);

        return response()->json(['success' => true, 'data' => $suscripcion]);
    }

    // Eliminar suscripcion
    public function destroy($id){
        $suscripcionDelete = Suscripcion::find($id);
        $suscripcionDelete->delete();
        return response()->json(['success' => true, 'data' => 'Suscripcion eliminada correctamente']);
    }

    // Actualizar suscripcion
    public function update($id, Request $request){
        $suscripcion = Suscripcion::find($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $suscripcion->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $suscripcion]);
    }
}
