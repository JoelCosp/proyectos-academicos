<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Episode;

class EpisodesController extends Controller
{
    // Listar episodios
    public function index(){
        /*$episodes = Episode::all(); // Obtener todos los episodios sin cargar la relación 'media'
        return response()->json([$episodes]);*/

        $episodes = Episode::with('media')->get();

        return $episodes;
    }
    

    // Crear episodio
    public function store(Request $request){

        $request->validate([
            'episode_name' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'order' => 'required',
            'season_id' => 'required',
        ]);
        $episodeData = $request->all();
        $episode = Episode::create($episodeData);

        if ($request->hasFile('thumbnail')) { 
            $episode->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-episodes');
        }
        
        if ($request->hasFile('video')) {
            $episode->addMediaFromRequest('video')
                ->preservingOriginal()
                ->toMediaCollection('videos-episodes', 'video');
        }

        return response()->json(['success' => true, 'data' => $episode]);
    }

    // Eliminar episodio
    public function destroy($id){
        $episodeDelete = Episode::find($id);
        $episodeDelete->delete();
        return response()->json(['success' => true, 'data' => 'Episodio eliminado correctamente']);
    }

    public function getEpisodesBySeasonId($id) {
        $episodes = Episode::with('media')->where('season_id', $id)->get();
        if ($episodes->isEmpty()) {
            return [];
        }
        return $episodes;
    }
    // Obtener ids de los episodios
    public function getEpisodesIds()
    {
        $episodesIds = Episode::pluck('id')->toArray();
        return $episodesIds;
    }
}
