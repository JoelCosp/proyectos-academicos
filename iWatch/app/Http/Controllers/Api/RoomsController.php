<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Film;

class RoomsController extends Controller
{
    //
    public function index(){

        $rooms = Room::all()->toArray();
        return $rooms;
    }

    // Crear sala
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'state' => 'required',
            'capacity' => 'required',
        ]);

        $roomData = $request->all();
        $rooms = Room::create($roomData);

        return response()->json(['success' => true, 'data' => $rooms]);
    }

    // Eliminar sala
    public function destroy($id){
        $roomDelete = Room::find($id);
        $roomDelete->delete();
        return response()->json(['success' => true, 'data' => 'sala eliminada correctamente']);
    }

    // Actualizar sala
    public function update($id, Request $request){
        $room = Room::find($id);

        $request->validate([
            'name' => 'required',
            'state' => 'required',
            'capacity' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $room->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $room]);
    }

    public function getRoomsByMovie($movieId)
{
    // Busca la película por su ID
    $film = Film::find($movieId);

    // Si la película existe y tiene una sala asociada, devuelve esa sala
    if ($film && $film->sala_id) {
        $room = Room::find($film->sala_id);
        return response()->json([$room]);
    }

    // Si no se encuentra la sala asociada a la película, devuelve un array vacío
    return response()->json([]);
}
}
