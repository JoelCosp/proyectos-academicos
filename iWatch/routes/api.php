<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\FilmsController;
use App\Http\Controllers\Api\EpisodesController;
use App\Http\Controllers\Api\SeasonsController;
use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\Api\SuscripcionController;
use App\Http\Controllers\Api\UserSubscriptionController;
use App\Http\Controllers\Api\UsuarioSuscripcionesController;
use App\Http\Controllers\Api\UserFilmController;
use App\Http\Controllers\Api\FavoritesController;
use App\http\Controllers\Api\ReviewsController;
use App\http\Controllers\Api\MessagesController;
use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\CategoriasController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Api\SuscripcionsFilmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ForgotPasswordController;

Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

Route::get('tasks', [TaskController::class,'index']);
Route::post('tasks/', [TaskController::class, 'store']);
Route::put('tasks/update/{id}',[TaskController::class, 'update']);
Route::delete('tasks/{id}',[TaskController::class, 'destroy']);

// Acciones admin peliculas
Route::get('films', [FilmsController::class,'index']);

Route::post('films/', [FilmsController::class, 'store']);
Route::put('films/update/{id}',[FilmsController::class, 'update']);
Route::delete('films/{id}',[FilmsController::class, 'destroy']);
Route::get('filmsIds', [FilmsController::class,'getFilmsIds']);
Route::get('news', [FilmsController::class,'getNews']);

Route::get('films-only', [FilmsController::class,'getOnlyFilmsContent']);
Route::get('series-only', [FilmsController::class,'getOnlySeriesContent']);
Route::get('favorites-only/{user_id}', [FavoritesController::class,'getOnlyFavoriteContent']);

// Funciones buscador pelis, series, favoritos
Route::get('films/{name}', [FilmsController::class,'getFilmContentByContentName']);
Route::get('series/{name}', [FilmsController::class,'getSerieContentByContentName']);
Route::get('favorites/{name}', [FilmsController::class,'getFavoriteContentByContentName']);

Route::get('random-film', [FilmsController::class,'getRandomFilm']);
Route::get('lastFilm', [FilmsController::class,'getLastInsertedFilmId']);
Route::get('getSeries', [FilmsController::class,'getSeries']);

// Añadir peliculas en la tablade user_film
Route::post('store/{user_id}/{film_id}', [FilmsController::class, 'storeViewedFilm']);

//Obtener peliculas vistas
Route::get('viewed-films/{user_id}', [UserFilmController::class, 'getUsersViewedFilms']);

// Acciones admin peliculas
Route::get('episodes', [EpisodesController::class,'index']);
Route::post('episodes/', [EpisodesController::class, 'store']);
Route::put('episodes/update/{id}',[EpisodesController::class, 'update']);
Route::delete('episodes/{id}',[EpisodesController::class, 'destroy']);
Route::get('episodesBySeason/{id}', [EpisodesController::class, 'getEpisodesBySeasonId']);

// Mostrar pelicula por ID
Route::get('filmsPlayer/{id}', [FilmsController::class, 'getFilmById']);
Route::get('films/{idCat}', [FilmsController::class,'getFilmByCat']); 

Route::get('films/category/{idCategoria}', [FilmsController::class,'getFilmsByCats']);
Route::get('series/category/{idCategoria}', [FilmsController::class,'getSeriesByCats']);
Route::get('favorites/category/{idCategoria}/{user_id}', [FavoritesController::class,'getFavoritesByCats']);

Route::get('getContentById/{c_id}', [FilmsController::class,'getContByContId']);

Route::get('cats', [CategoriasController::class,'getPelisByCats']); 

// Mostrar solo nombre de series
Route::get('series/names/{id}', [FilmsController::class,'getSeriesNameById']);
Route::get('seriesAllNames', [FilmsController::class,'getAllSeriesNames']);

// Acciones admin seasons
Route::get('seasons', [SeasonsController::class,'index']);
Route::post('seasons/', [SeasonsController::class, 'store']);
Route::get('seasons/{id}', [SeasonsController::class,'getSeasonByContentId']);

// Acciones admin series
Route::get('series', [SeriesController::class,'index']);
Route::post('series/', [SeriesController::class, 'store']);
Route::put('series/update/{id}',[SeriesController::class, 'update']);
Route::delete('series/{id}',[SeriesController::class, 'destroy']);

// Acciones admin suscripciones
Route::get('suscripciones', [SuscripcionController::class,'index']);
Route::post('suscripciones/', [SuscripcionController::class, 'store']);
Route::put('suscripciones/update/{id}',[SuscripcionController::class, 'update']);
Route::delete('suscripciones/{id}',[SuscripcionController::class, 'destroy']);

// Acciones admin reseñas
Route::get('reviews', [ReviewsController::class,'index']);
Route::post('reviews/', [ReviewsController::class, 'store']);
Route::put('reviews/update/{id}',[ReviewsController::class, 'update']);
Route::delete('reviews/{id}',[ReviewsController::class, 'destroy']);

Route::get('reviewsByContentId/{id}', [ReviewsController::class,'getReviewsByContentId']);
Route::get('reviewsByContentName/{name}', [ReviewsController::class,'getReviewsByContentName']);

Route::get('film-punctuation/{film_id}', [ReviewsController::class,'getFilmPunctuation']);

// Obtener numero de reviews de una pelicula/serie
Route::get('conuntReviews/{content_id}', [ReviewsController::class,'getNumReviewsByContentId']);


// Acciones admin mensajes
Route::get('messages', [MessagesController::class,'index']);
Route::post('messages/', [MessagesController::class, 'store']);
Route::put('messages/update/{id}',[MessagesController::class, 'update']);
Route::delete('messages/{id}',[MessagesController::class, 'destroy']);

// Acciones admin salas
Route::get('rooms', [RoomsController::class,'index']);
Route::post('rooms/', [RoomsController::class, 'store']);
Route::put('rooms/update/{id}',[RoomsController::class, 'update']);
Route::delete('rooms/{id}',[RoomsController::class, 'destroy']);
Route::get('/movies/{movieId}/rooms', [RoomsController::class, 'getRoomsByMovie']);

// Acciones admin categorias
Route::get('categorias', [CategoriasController::class,'index']);
Route::post('categorias/', [CategoriasController::class, 'store']);
Route::put('categorias/update/{id}',[CategoriasController::class, 'update']);
Route::delete('categorias/{id}',[CategoriasController::class, 'destroy']);

// Añadir registro en category_film
Route::post('addCategoryFilm/{filmId}/{categoryId}', [FilmsController::class, 'addCategoryFilm']);

// Añadir compra de suscripciones
Route::post('subscriptions/{subscriptionId}', [UserSubscriptionController::class, 'subscribe']);

// Comprobar info de la tabla user_subscriptions
Route::get('subscriptions/userSub-info/{id}', [UserSubscriptionController::class,'getUserSubscriptionInfo']);

Route::get('suscripcionsFilms/{id}', [SuscripcionsFilmsController::class,'getInfoSubscriptionFilm']);

// Añadir favoritos
Route::get('favoriteFilms', [FavoritesController::class,'index']);
Route::post('favorites', [FavoritesController::class, 'store']);
Route::delete('/favorites/{id}', [FavoritesController::class, 'destroy']);
Route::get('favoritesByUser/{id}', [FavoritesController::class,'getFavoritesByUserId']);

Route::delete('viewedFilms/{id}', [FilmsController::class, 'deleteViewedFilm']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);
    //Route::apiResource('exercises', ExerciseController::class);
    Route::post('exercises/', [ExerciseController::class,'store']); //Guardar
    Route::get('exercises', [ExerciseController::class,'index']); //Listar
    Route::get('exercises/{exercise}', [ExerciseController::class,'show']); //Mostrar
    Route::post('exercises/update/{id}', [ExerciseController::class,'update']); //Editar

    Route::get('role-list', [RoleController::class, 'getList']);
    Route::get('role-permissions/{id}', [PermissionController::class, 'getRolePermissions']);
    Route::put('/role-permissions', [PermissionController::class, 'updateRolePermissions']);
    Route::apiResource('permissions', PermissionController::class);
    Route::get('category-list', [CategoryController::class, 'getList']);
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [UserController::class, 'update']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user-image', [UserController::class, 'storeProfileImage']);
    Route::get('/user-data', [UserController::class, 'getUserData']);
    Route::get('/user/profile-image', [UserController::class, 'getUserProfileImage']);

    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);


    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});


Route::get('category-list', [CategoryController::class, 'getList']);
Route::get('get-posts', [PostController::class, 'getPosts']);
Route::get('get-category-posts/{id}', [PostController::class, 'getCategoryByPosts']);
Route::get('get-post/{id}', [PostController::class, 'getPost']);

Route::get('suscripcion-list', [SuscripcionController::class, 'indexSuscripcions']);