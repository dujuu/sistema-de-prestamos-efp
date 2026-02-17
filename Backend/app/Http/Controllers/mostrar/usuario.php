<?php

namespace App\Http\Controllers\mostrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class usuario extends Controller
{
    public function index(Request $request)
        {
            $authUser = $request->user();

            if (!$authUser) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // Trae al usuario con su relación persona
            $user = User::with('persona')->find($authUser->idUser ?? $authUser->id);

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            return response()->json($user);
        }
}