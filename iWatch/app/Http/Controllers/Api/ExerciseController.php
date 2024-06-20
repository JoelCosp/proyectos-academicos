<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\Task;

class ExerciseController extends Controller
{
    public function index()
    { 
        $orderColumn = 'created_at';
        $orderDirection = 'desc';
    
        $exercises = Exercise::with('categories')->with('media')
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(50);

        return ExerciseResource::collection($exercises);
    }

    public function store(StoreExerciseRequest $request)
    {
        $this->authorize('exercise-create');

        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $exercise = Exercise::create($validatedData);

        $categories = explode(",", $request->categories);
        $category = Category::findMany($categories);
        $exercise->categories()->attach($category);

        if ($request->hasFile('thumbnail')) {
            $exercise->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-exercises');
        }

        return new ExerciseResource($exercise);
    }

    public function show(Exercise $exercise)
    {
        $this->authorize('exercise-edit');
        if ($exercise->user_id !== auth()->user()->id && !auth()->user()->hasPermissionTo('exercise-all')) {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only edit your own exercises']);
        } else {
            return new ExerciseResource($exercise);
        }
    }

    public function update($id, StoreExerciseRequest $request)
    {

        $this->authorize('exercise-edit');

        $exercise = Exercise::find($id);

        if ($exercise->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('exercise-all')) {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only edit your own exercises']);
        } else {
            $exercise->update($request->validated());
            $category = Category::findMany($request->categories);
            $exercise->categories()->sync($category);
    
            if($request->hasFile('thumbnail')) {
                $exercise->media()->delete();
                $exercise->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-exercises');
            }

            return new ExerciseResource($exercise);
        }
    }

    public function destroy(Exercise $exercise)
    {
        $this->authorize('exercise-delete');
        if ($exercise->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('exercise-all')) {
            return response()->json(['status' => 405, 'success' => false, 'message' => 'You can only delete your own exercises']);
        } else {
            $exercise->delete();
            return response()->noContent();
        }
    }

    // public function getExercises()
    // {
    //     $exercises = Exercise::with('categories')->with('media')->latest()->paginate();
    //     return ExerciseResource::collection($exercises);
    // }

    public function getCategoryByExercises($id)
    {
        $exercises = Exercise::whereRelation('categories', 'category_id', '=', $id)->paginate();
        return ExerciseResource::collection($exercises);
    }

    public function getExercise($id)
    {
        return Exercise::with('categories', 'user', 'media')->findOrFail($id);
    }
}
