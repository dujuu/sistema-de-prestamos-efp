<?php
namespace App\Services;
use App\Models\TipoEquipo;

class TipoEquipoService
{
    function getAll()
    {
        return TipoEquipo::all();
    }

    function getById($id)
    {
        return TipoEquipo::findOrFail($id);
    }

    function create($data)
    {
        
        $tipoEquipo = TipoEquipo::create($data);

        return $tipoEquipo;

    }

    function update($id, $data)
    {  
        $tipoEquipo = TipoEquipo::findOrfail($id);

        $tipoEquipo->fill($data);

        $tipoEquipo->save();
        return $tipoEquipo;
    }

    public function delete($id)
    {
        $tipo = TipoEquipo::findOrFail($id);

        // Verificar si tiene equipos asociados
        if ($tipo->equipos()->exists()) {
            return [
                'error' => true,
                'message' => 'No se puede eliminar el tipo de equipo, existen equipos asociados.'
            ];
        }

        $tipo->delete();

        return [
            'error' => false,
            'message' => 'Tipo de equipo eliminado correctamente.'
        ];
    }

}