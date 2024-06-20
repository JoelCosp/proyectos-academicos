<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all()->toArray();

        return $tasks;
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:5',
            'descripcion' => 'required'
        ]);

        $task = $request->all();
        $tarea = Task::create($task);

        return response()->json(['success' => true, 'data' => $tarea]);
    }

    public function show($id){
        $task = Task::find($id);
        return response()->json($task);
    }

    public function update($id, Request $request){
        $task = Task::find($id);

        $request->validate([
            'name' => 'required|max:5',
            'descripcion' => 'required'
        ]);

        $dataToUpdate = $request->all();
        $task->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $task]);
    }

    public function destroy($id){
        $task = Task::find($id);
        $task->delete();
        return response()->json(['success' => true, 'data' => 'Tarea eliminada correctamente']);
    }
}
