<?php

namespace App\Services;

use App\Models\Equipo;
use App\Models\EquipoRelacionado;
use Illuminate\Support\Facades\DB;

class EquipoRelacionadoService
{
    /**
     * Crear una relación entre dos equipos
     */
    public function crearRelacion($equipoId, $relacionadoId, $tipo)
    {
        // No permitir autorelación
        if ($equipoId == $relacionadoId) {
            throw new \Exception("Un equipo no puede relacionarse consigo mismo.");
        }

        // Validar existencia de ambos equipos
        $equipo = Equipo::findOrFail($equipoId);
        $relacionado = Equipo::findOrFail($relacionadoId);

        // Validar duplicado (aunque el índice único ya protege, es mejor manejarlo aquí)
        $existe = EquipoRelacionado::where('equipo_id', $equipoId)
            ->where('relacionado_id', $relacionadoId)
            ->where('tipo_relacion', $tipo)
            ->first();

        if ($existe) {
            throw new \Exception("Esta relación ya existe.");
        }

        // Crear relación
        return EquipoRelacionado::create([
            'equipo_id'       => $equipoId,
            'relacionado_id'  => $relacionadoId,
            'tipo_relacion'   => $tipo
        ]);
    }

    /**
     * Eliminar una relación
     */
    public function eliminarRelacion($equipoId, $relacionadoId, $tipo = null)
    {
        $query = EquipoRelacionado::where('equipo_id', $equipoId)
            ->where('relacionado_id', $relacionadoId);

        if ($tipo) {
            $query->where('tipo_relacion', $tipo);
        }

        $deleted = $query->delete();

        if ($deleted === 0) {
            throw new \Exception("No existe la relación especificada.");
        }

        return true;
    }

    /**
     * Obtener recomendaciones de un equipo
     */
    public function obtenerRecomendaciones($equipoId, $tipo = null)
    {
        $equipo = Equipo::findOrFail($equipoId);

        $relaciones = $equipo->recomendados();

        if ($tipo) {
            $relaciones->where('tipo_relacion', $tipo);
        }

        // Retornar equipos recomendados con datos del pivote
        return $relaciones->get();
    }
}
