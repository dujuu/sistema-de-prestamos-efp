<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Buscar o crear usuario
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => bcrypt(Str::random(16)), 
                ]);
            }

            // Crear token para el frontend
            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                'message' => 'Login exitoso con Google',
                'token'   => $token,
                'user'    => $user
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'No se pudo iniciar sesión con Google',
                'details' => $th->getMessage()
            ], 500);
        }
    }
}
