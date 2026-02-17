<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class DevolucionAdminController extends Controller
{
    public function devolverEquipo(Request $request)
    {
        // Validación del request
        $request->validate([
            'idPrestamo' => 'required|exists:prestamos,idPrestamo',
            'estado' => 'required|string|in:devuelto'
        ]);

        // Buscar préstamo
        $prestamo = Prestamo::findOrFail($request->idPrestamo);

        // Cambiar estado
        $prestamo->estado = $request->estado;
        $prestamo->save();

        return response()->json([
            'message' => 'Equipo marcado como devuelto correctamente por el administrador.',
            'prestamo' => $prestamo
        ]);
    }
}
