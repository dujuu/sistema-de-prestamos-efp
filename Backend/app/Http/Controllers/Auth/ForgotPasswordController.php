<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Envía un enlace de restablecimiento de contraseña al correo del usuario.
     */
    public function sendResetLinkEmail(Request $request)
{
    $email = $request->input('email') ?? $request->input('Email');

    if (!$email) {
        return response()->json([
            'message' => 'El correo no fue recibido correctamente.',
            'debug' => $request->all()
        ], 400);
    }

    $request->merge(['email' => $email]);
    $request->validate(['email' => 'required|email']);

    $user = \App\Models\User::where('Email', $email)->first();

    if (!$user) {
        return response()->json(['message' => 'No existe un usuario con ese correo.'], 404);
    }

    \DB::table('password_resets')->where('email', $email)->delete();
    $token = \Str::random(60);

    \DB::table('password_resets')->insert([
        'email' => $email,
        'token' => $token,
        'created_at' => now(),
    ]);

    $frontendUrl = "http://localhost:4200/reset-password#$token";
   // $frontendUrl = "http://localhost:4200/reset-password?token=$token&email=$email";

    // ✅ Envío del correo usando el Mailable
    \Illuminate\Support\Facades\Mail::to($email)
        ->send(new \App\Mail\PasswordResetMail($user, $frontendUrl));

    return response()->json(['message' => 'Correo de recuperación enviado correctamente.']);
}

}
