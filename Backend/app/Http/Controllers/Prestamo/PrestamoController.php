<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Prestamo;
use App\Models\BloquePrestamo;


/**
 * Class PrestamoController
 *
 * Controlador encargado de gestionar las solicitudes de préstamo de equipos
 * realizadas por usuarios autenticados. Permite listar el historial de préstamos
 * y registrar nuevas solicitudes tanto para uso interno (por bloques) como externo 
 * (por fechas).
 */
class PrestamoController extends Controller
{
    /**
     * Obtiene todos los préstamos del usuario autenticado.
     *
     * Carga relaciones necesarias para el frontend:
     * - Equipo asociado
     * - Bloques asignados (si aplica)
     * - Asignatura correspondiente
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function index(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $prestamos = Prestamo::with([
                    'equipo',
                    'bloquePrestamo.bloque',
                    'bloquePrestamo.asignatura'
                ])
                ->where('idUser', $user->idUser)
                ->orderByDesc('idPrestamo')
                ->get();

            return response()->json($prestamos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener las solicitudes.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crea nuevos préstamos según los parámetros enviados por el usuario.
     *
     * Tipos de préstamo admitidos:
     * - DENTRO: solicita bloques y asignatura.
     * - FUERA: solicita fecha de inicio y fecha de fin.
     *
     * Cada equipo enviado en el arreglo 'equipos' genera un préstamo independiente.
     *
     * La operación se ejecuta dentro de una transacción para asegurar que todos
     * los préstamos se registren correctamente o que ninguno quede a medias.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //  Validación base (común)
        $request->validate([
            'equipos' => 'required|array|min:1',
            'equipos.*' => 'integer|exists:equipos,idEquipo',
            'tipo' => 'required|string|in:DENTRO,FUERA',
            'asignatura' => 'nullable|integer|exists:asignaturas,idAsignatura',
            'motivo' => 'nullable|string|max:500',
            'observacion' => 'nullable|string|max:500',
        ]);
        
        if ($request->tipo === 'DENTRO') {
            $request->validate([
                'bloques' => 'required|array|min:1',
                'bloques.*' => 'integer|exists:bloques,idBloque',
            ]);
        } else { 
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            ]);
        }

        $usuarioId = Auth::id();

        DB::beginTransaction();
        try {
            $prestamosCreados = [];
             // Cada equipo genera un préstamo independiente
            foreach ($request->equipos as $idEquipo) {
              
                $prestamo = Prestamo::create([
                    'idUser'        => $usuarioId,
                    'idEquipo'      => $idEquipo,
                    'fecha_inicio'  => $request->filled('fecha_inicio') ? $request->fecha_inicio : null,
                    'fecha_fin'     => $request->filled('fecha_fin') ? $request->fecha_fin : null,
                    'otra_motivo'  => $request->motivo ?: null,

                    'tipo'          => $request->tipo,
                    'estado'        => 'pendiente',
                    'observacion'   => $request->observacion ?: null,
                ]);

                // vincula bloques y asignatura
                if ($request->tipo === 'DENTRO' && $request->bloques) {
                    foreach ($request->bloques as $idBloque) {
                        BloquePrestamo::create([
                            'idPrestamo'   => $prestamo->idPrestamo,
                            'idBloque'     => $idBloque,
                            'idAsignatura' => $request->asignatura,
                        ]);
                    }
                }
                 // Cargar relaciones para la respuesta final
                $prestamosCreados[] = $prestamo->load(
                    'user',
                    'equipo',
                    'bloquePrestamo.bloque',
                    'bloquePrestamo.asignatura'
                );
            }

            DB::commit();

            return response()->json([
                'message' => ' Préstamos creados correctamente.',
                'prestamos' => $prestamosCreados,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => ' Error al crear los préstamos.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}