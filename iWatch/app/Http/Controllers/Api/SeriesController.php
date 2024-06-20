<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Serie;

class SeriesController extends Controller
{
    // Listar series
    public function index(){
        $series = Serie::all()->toArray();
        return $series;
    }

    // Crear serie
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'synopsis' => 'required',
            'director' => 'required',
            'episodes' => 'required',
            'duration' => 'required',
            'seasons' => 'required',
        ]);

        $serieData = $request->all();
        $serieData['punctuation'] = 0;
        $serie = Serie::create($serieData);

        if ($request->hasFile('thumbnail')) {
            $serie->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-series');
        }

        return response()->json(['success' => true, 'data' => $serie]);
    }

    // Eliminar serie
    public function destroy($id){
        $serieDelete = Serie::find($id);
        $serieDelete->delete();
        return response()->json(['success' => true, 'data' => 'Serie eliminada correctamente']);
    }

    // Actualizar pelicula
    public function update($id, Request $request){
        $serie = Serie::find($id);

        $request->validate([
            'name' => 'required',
            'synopsis' => 'required',
            'director' => 'required',
            'punctuation' => 'required',
            'episodes' => 'required',
            'duration' => 'required',
            'seasons' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $serie->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $serie]);
    }
}
