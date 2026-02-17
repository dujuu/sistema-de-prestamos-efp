<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Observacion;

class PrestamoAdminController extends Controller
{
    public function cambiarEstado(Request $request)
{
    $user = auth()->user();

    // Verificar que sea admin
    if (!$user->isAdmin()) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    $idPrestamo = $request->input('id');       // id del préstamo desde el body
    $accion = strtolower($request->input('accion')); // "aceptar" o "rechazar"
    $motivo = trim($request->input('motivo'));

    $prestamo = Prestamo::find($idPrestamo);

    if (!$prestamo) {
        return response()->json(['message' => 'Préstamo no encontrado'], 404);
    }

    // Cambiar el estado según la acción
    if ($accion === 'aceptar') {
        $prestamo->estado = 'aceptado';
    } elseif ($accion === 'rechazar') {
        $prestamo->estado = 'rechazado';
    } else {
        return response()->json(['message' => 'Acción inválida'], 400);
    }

    $prestamo->save();
            Observacion::create([
            'idPrestamo'  => $prestamo->idPrestamo,
            'descripcion' => $motivo ?: 'Sin motivo especificado',
            'estado'      => $accion === 'aceptar' ? 'aprobacion' : 'rechazo',
        ]);

    return response()->json([
        'message' => 'Estado del préstamo actualizado correctamente',
        'prestamo' => $prestamo
    ]);
}
    public function verTodosLosPrestamos()
    {
        $user = auth()->user();

        if (!$user->isAdmin()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // 🔹 Cargar todas las relaciones necesarias
        $prestamos = \App\Models\Prestamo::with([
            'user.persona', // para obtener nombre y correo del usuario
            'equipo',       // nombre y código del equipo
            'bloquePrestamo.bloque', // bloque asociado
        ])->get();

        // 🔹 Estructurar datos limpios
        $data = $prestamos->map(function ($p) {
    // 🔹 Obtener texto de bloque solo si tiene bloques asociados
    $bloquesTexto = null;
    if ($p->bloquePrestamo && $p->bloquePrestamo->count() > 0) {
        $bloquesTexto = $p->bloquePrestamo
            ->map(fn($bp) => $bp->bloque->nombre ?? "Bloque {$bp->idBloque}")
            ->join(', ');
    }

    return [
        'idPrestamo' => $p->idPrestamo,
        'user' => [
            'nombre' => $p->user->persona->Nombre ?? 'Desconocido',
            'email' => $p->user->Email ?? ''
        ],
        'tipo' => $p->tipo,
        'fecha_inicio' => $p->fecha_inicio,
        'fecha_fin' => $p->fecha_fin,
        'bloquePrestamo' => $bloquesTexto, // 👈 bloque formateado
        'equipo' => [
            'nombre' => $p->equipo->nombre ?? 'Sin equipo',
            'codigo_activo' => $p->equipo->codigo ?? '—'
        ],
        'observacion' => $p->Observacion ?? 'Sin observación',
        'estado' => $p->estado ?? 'pendiente',
        'created_at' => $p->created_at,
    ];
});


        return response()->json($data);
    }

}