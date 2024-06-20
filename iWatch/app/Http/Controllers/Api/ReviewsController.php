<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewsController extends Controller
{
    // Obtener reseñas
    public function index(){
        $reviews = Review::join('users', 'reviews.user_id', '=', 'users.id')->get()->toArray();
        return $reviews;
    }

    // Crear reseña
    public function store(Request $request){

        $request->validate([
            'description' => 'required',
            'punctuation' => 'required',
        ]);

        $reviewData = $request->all();
        $review = Review::create($reviewData);

        return response()->json(['success' => true, 'data' => $review]);
    }

    // Eliminar reseña
    public function destroy($id){
        $reviewDelete = Review::find($id);
        $reviewDelete->delete();
        return response()->json(['success' => true, 'data' => 'reseña eliminada correctamente']);
    }

    // Actualizar reseña
    public function update($id, Request $request){
        $review = Review::find($id);

        $request->validate([
            'description' => 'required',
            'punctuation' => 'required',
            'creation_date' => 'required',
        ]);

        $dataToUpdate = $request->all();
        $review->update($dataToUpdate);

        return response()->json(['success' => true, 'data' => $review]);
    }

    // public function getReviewsByContentId($id){
    //     $reviews = Review::where('content_id', $id)->get();
    //     if ($reviews->isEmpty()) {
    //         return [];
    //     }
    //     return $reviews;
    // }

    public function getReviewsByContentId($id){
        $reviews = Review::join('films', 'reviews.content_id', '=', 'films.id')
                         ->join('users', 'reviews.user_id', '=', 'users.id')
                         ->where('films.id', $id)
                         ->get();
    
        if ($reviews->isEmpty()) {
            return [];
        }
        return $reviews;
    }

    public function getReviewsByContentName($name){
        $reviews = Review::join('films', 'reviews.content_id', '=', 'films.id')
                           ->join('users', 'reviews.user_id', '=', 'users.id')
                           ->where('films.name', $name)
                           ->get();
        if ($reviews->isEmpty()) {
            return [];
        }
        return $reviews;
    }

    public function getFilmPunctuation($film_id) {
        $totalReviews = Review::where('content_id', $film_id)->count();
        if ($totalReviews > 0) {
            $totalPunctuation = Review::where('content_id', $film_id)->sum('punctuation');
            $averagePunctuation = $totalPunctuation / $totalReviews;
            return $averagePunctuation;
        } else {
            return 0; // En caso de que no haya revisiones para la película, se devuelve 0 para evitar divisiones por cero.
        }
    }

    public function getNumReviewsByContentId($content_id)
    {
        $numReviews = Review::where('content_id', $content_id)->count();

        return $numReviews;
    }
    
}
