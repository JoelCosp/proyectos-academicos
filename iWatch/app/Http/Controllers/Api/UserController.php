<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $orderColumn = request('order_column', 'created_at');
        if (!in_array($orderColumn, ['id', 'name', 'apellido', 'phone', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }
        $users = User::
        when(request('search_id'), function ($query) {
            $query->where('id', request('search_id'));
        })
            ->when(request('search_title'), function ($query) {
                $query->where('name', 'like', '%'.request('search_title').'%');
            })
            ->when(request('search_global'), function ($query) {
                $query->where(function($q) {
                    $q->where('id', request('search_global'))
                        ->orWhere('name', 'like', '%'.request('search_global').'%');

                });
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(50);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */

    //  Almacenar usuario
    public function store(StoreUserRequest $request)
    {
        $role = Role::find($request->role_id);
        $user = new User();
        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $phone->phone = $request->phone;

        if ($user->save()) {
            if ($role) {
                $user->assignRole($role);
            }

            if ($request->hasFile('profile_image')) {
                $media = $user->addMediaFromRequest('profile_image')
                              ->toMediaCollection('images2/profile');
                // Si deseas preservar la imagen original y también hacer conversiones, puedes usar el método preservingOriginal()
                // ->preservingOriginal()
            }

            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show(User $user)
    {
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(Request $request)
    {
        // Obtener el usuario actualmente autenticado (si estás autenticando usuarios)
        $user = auth()->user();

        // Validar los datos del formulario
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'apellido' => 'string|max:255',
            'phone' => 'string|max:255',
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->apellido = $request->apellido;
        $user->phone = $request->phone;

        // Guardar los cambios en la base de datos
        $user->save();

        return response()->json(['message' => 'Perfil actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('user-delete');
        $user->delete();

        return response()->noContent();
    }

    // Actualizar foto de perfil
    public function storeProfileImage(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'profile_image_url' => 'required',
        ]);

        // Obtener el usuario por su ID
        $user = auth()->user();

        // Actualizar el campo profile_image con la URL de la imagen
        $user->profile_image = $request->profile_image_url;

        // Guardar los cambios en la base de datos
        $user->save();

        return response()->json(['message' => 'URL de la imagen de perfil almacenada correctamente'], 200);
    }
    // Obtener informacion del user
    public function getUserData()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si se encontró el usuario
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $user = User::with('roles')->find($user->id);

        $isAdmin = $user->roles->contains('name', 'admin');
        // Devolver los datos del usuario en formato JSON
        return response()->json(['user' => $user, 'isAdmin' => $isAdmin], 200);
    }

    public function deleteUser(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el usuario'], 500);
        }
    }
}
