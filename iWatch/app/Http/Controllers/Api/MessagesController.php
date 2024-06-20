<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessagesController extends Controller
{
    //
    public function index(){

        $messages = Message::all()->toArray();
        return $messages;
    }

    // Crear reseña
    public function store(Request $request){

        $request->validate([
            'message' => 'required',
            'creation_date' => 'required',
        ]);

        $messageData = $request->all();
        $messages = Message::create($messageData);

        return response()->json(['success' => true, 'data' => $messages]);
    }

    // Eliminar reseña
    public function destroy($id){
        $messageDelete = Message::find($id);
        $messageDelete->delete();
        return response()->json(['success' => true, 'data' => 'reseña eliminada correctamente']);
    }

    // Actualizar reseña
    public function update($id, Request $request){
        $message = Message::find($id);

        $request->validate([
            'message' => 'required',
            'creation_date' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $message->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $message]);
    }
}
