<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // Aceptar ambas formas de "email"
        $email = $request->input('email') ?? $request->input('Email');

        $request->validate([
            'token' => 'required',
            'email' => 'required_without:Email|email',
            'Email' => 'required_without:email|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Buscar el token en la tabla (siempre en minúsculas)
        $record = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Token inválido o expirado (no encontrado en BD).'], 400);
        }

        // Comparar el token directamente
        if ($request->token !== $record->token) {
            return response()->json([
                'message' => 'El token no coincide.',
                'debug' => [
                    'enviado' => $request->token,
                    'guardado' => $record->token,
                ]
            ], 400);
        }

        // Buscar usuario en tu tabla (campo "Email" con mayúscula)
        $user = User::where('Email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        // Actualizar la contraseña
        $user->Contrasena = Hash::make($request->password);
        $user->save();

        // Eliminar el token usado
        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json(['message' => 'Contraseña restablecida correctamente.']);
    }
    public function validateToken($token)
    {
        $record = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Token inválido o expirado.'], 400);
        }

        return response()->json(['email' => $record->email]);
    }

}
