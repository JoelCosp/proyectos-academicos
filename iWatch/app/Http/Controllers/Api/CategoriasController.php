<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    // Obtener categorias 
    public function index(){

        $categorias = Categoria::all()->toArray();
        return $categorias;
    }


    public function getPelisByCats()
{
    $categorias = Categoria::with('films.media', 'films.categories')->get();
    return $categorias;
}

    // Crear categoria
    public function store(Request $request){

        $request->validate([
            'name' => 'required',
        ]);

        $categoriaData = $request->all();
        $categorias = Categoria::create($categoriaData);

        return response()->json(['success' => true, 'data' => $categorias]);
    }

    // Eliminar categoria
    public function destroy($id){
        $categoriaDelete = Categoria::find($id);
        $categoriaDelete->delete();
        return response()->json(['success' => true, 'data' => 'categoria eliminada correctamente']);
    }

    // Actualizar categoria
    public function update($id, Request $request){
        $categoria = Categoria::find($id);

        $request->validate([
            'name' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $categoria->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $categoria]);
    }
}
