<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EquipoRelacionadoService;
use App\Http\Requests\equipoRelacionado\StoreRelacionadoRequest;
use App\Http\Requests\equipoRelacionado\DeleteRelacionadoRequest;
use Illuminate\Http\Request;

class EquipoRelacionadoController extends Controller
{
    protected $service;

    public function __construct(EquipoRelacionadoService $service)
    {
        $this->service = $service;
    }

    /**
     * Crear una relación entre equipos
     */
    public function store(StoreRelacionadoRequest $request)
    {
        try {
            $relacion = $this->service->crearRelacion(
                $request->equipo_id,
                $request->relacionado_id,
                $request->tipo_relacion
            );

            return response()->json([
                'message' => 'Relación creada correctamente.',
                'data' => $relacion
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear relación.',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Obtener recomendaciones de un equipo
     */
    public function recomendaciones($equipoId, Request $request)
    {
        try {
            $tipo = $request->query('tipo');

            $recomendaciones = $this->service->obtenerRecomendaciones($equipoId, $tipo);

            return response()->json([
                'message' => 'Recomendaciones obtenidas.',
                'data' => $recomendaciones
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener recomendaciones.',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Eliminar una relación
     */
    public function destroy(DeleteRelacionadoRequest $request)
    {
        try {
            $this->service->eliminarRelacion(
                $request->equipo_id,
                $request->relacionado_id,
                $request->tipo_relacion
            );

            return response()->json([
                'message' => 'Relación eliminada correctamente.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar relación.',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
