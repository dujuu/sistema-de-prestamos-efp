<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sancion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SancionNotificacion; // la creamos más abajo

class UserSancionController extends Controller
{
    // -------- ASIGNAR SANCION A UN USUARIO (ID, CORREO O RUT) --------
    public function asignarSancion(Request $request)
    {
        $request->validate([
            'usuario'      => 'required|string',     // puede ser id, correo o rut
            'nivel'        => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $identificador = $request->usuario;

        // Buscar usuario por idUser, Email o Rut (en persona)
        $userQuery = User::with('persona'); // asumiendo relación persona() en User

        if (is_numeric($identificador)) {
            $userQuery->where('idUser', $identificador);
        } elseif (str_contains($identificador, '@')) {
            $userQuery->where('Email', $identificador);
        } else {
            // Se asume que el rut está en tabla persona, campo Rut
            $userQuery->whereHas('persona', function ($q) use ($identificador) {
                $q->where('Rut', $identificador);
            });
        }

        $user = $userQuery->firstOrFail();

        // Crear sanción (estado siempre se inicia en 'activo')
        $sancion = Sancion::create([
            'nivel'        => $request->nivel,
            'estado'       => 'ACTIVA',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
        ]);

        // Asignar sanción en tabla pivote
        $user->sanciones()->attach($sancion->idSancion);

        // Enviar correo
        Mail::to($user->Email)->send(
            new SancionNotificacion('asignada', $user, $sancion)
        );

        return response()->json([
            'message' => 'Sanción creada y asignada correctamente.',
            'sancion' => $sancion,
            'usuario' => [
                'idUser'   => $user->idUser,
                'Email'    => $user->Email,
                'Rut'      => $user->persona->Rut ?? null,
                'Nombre'   => $user->persona->Nombre ?? null,
                'Apellido' => $user->persona->Apellido1 ?? null,
            ],
        ], 201);
    }


    public function listarSanciones()
    {
        $sanciones = Sancion::with(['users.persona'])->get();

        return response()->json([
            'message'   => 'Listado completo de sanciones con sus usuarios.',
            'sanciones' => $sanciones
        ]);
    }

    public function listarSancionesActivas()
    {
        $sanciones = Sancion::with(['users.persona'])
            ->where('estado', 'ACTIVA') // filtra solo las activas
            ->get();

        return response()->json([
            'message'   => 'Listado de sanciones activas.',
            'sanciones' => $sanciones
        ]);
    }

   
    public function ampliarSancion(Request $request, $idSancion)
    {
        $request->validate([
            'motivo' => 'required|string'
        ]);

        $sancion = Sancion::with('users.persona')->findOrFail($idSancion);

        // extender 7 días
        $fechaFin = $sancion->fecha_fin ?? now()->toDateString();
        $nuevaFecha = now()->parse($fechaFin)->addDays(7)->toDateString();
        $sancion->fecha_fin = $nuevaFecha;
        $sancion->save();

        // tomamos el primer usuario asociado (puedes adaptar a más)
        $user = $sancion->users->first();

        if ($user) {
            Mail::to($user->Email)->send(
                new SancionNotificacion('ampliada', $user, $sancion, $request->motivo)
            );
        }

        return response()->json([
            'message' => 'Sanción ampliada 7 días correctamente.',
            'sancion' => $sancion
        ]);
    }

    // -------- QUITAR / DESACTIVAR SANCION --------
    public function quitarSancion(Request $request, $idSancion)
    {
        $request->validate([
            'motivo' => 'nullable|string'
        ]);

        $sancion = Sancion::with('users.persona')->findOrFail($idSancion);

        // en vez de borrar, la marcamos como no activo para mantener historial
        $sancion->estado = 'EXPIRADA    ';
        $sancion->save();

        $user = $sancion->users->first();

        if ($user) {
            Mail::to($user->Email)->send(
                new SancionNotificacion('quitada', $user, $sancion, $request->motivo)
            );
        }

        return response()->json([
            'message' => 'Sanción desactivada correctamente.',
            'sancion' => $sancion
        ]);
    }
}
