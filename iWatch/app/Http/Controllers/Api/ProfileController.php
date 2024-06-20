<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function update(UpdateProfileRequest $request)
    {
        $profile = Auth::user();
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->apellido = $request->apellido;
        // Guarda la imagen en el almacenamiento de medios
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images');
            $profile->profile_image = $path;
        }

        if ($profile->save()) {
            return response()->json(['success' => true, 'message' => 'Perfil actualizado exitosamente']);
        }

        return response()->json(['success' => false, 'message' => 'Error al actualizar el perfil'], 500);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        return $this->successResponse($user, 'User found');
    }
}
