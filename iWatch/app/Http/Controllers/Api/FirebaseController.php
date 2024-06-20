<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use Kreait\Firebase\ServiceAccount;



class FirebaseController extends Controller
{
    protected $database;
    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    public function index()
    {





        // // Crear una instancia de Factory con las credenciales de Firebase
        // $serviceAccount = ServiceAccount::fromJsonFile(env('FIREBASE_CREDENTIALS'));
        // $firebase = (new Factory)
        //     ->withServiceAccount($serviceAccount)
        //     ->create();

        // // Obtener una instancia de Firestore Database
        // $firestore = $firebase->getFirestore();

        // // Obtener una referencia al documento que deseas leer
        // $document = $firestore->collection('movie_playlist')->document('name');

        // // Obtener los datos del documento
        // $snapshot = $document->snapshot();
        // if ($snapshot->exists()) {
        //     $data = $snapshot->data();
        //     return response()->json($data);
        // } else {
        //     return response()->json(['message' => 'Documento no encontrado'], 404);
        // }
    }
    
}
