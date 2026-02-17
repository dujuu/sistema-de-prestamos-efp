<?php
namespace App\Services;
use App\Models\Categoria;

class CategoriaService
{
    function getAll()
    {
        return Categoria::all();
    }

    function getById($id)
    {
        return Categoria::findOrFail($id);
    }

    function create($data)
    {
        
    
        $categoria = Categoria::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
        ]);
            
        return $categoria;
    }

    function update($id, $data)
    {  
        $categoria = Categoria::findOrFail($id);

        $categoria->nombre = $data['nombre'];
        $categoria->descripcion = $data['descripcion'];

    
        $categoria->save();

            
        return $categoria;
    }

    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);

        // Verificar relaciones
        if ($categoria->tipoEquipos()->exists()) {
            return [
                'error' => true,
                'message' => 'No se puede eliminar la categoría, tiene tipos de equipo asociados.'
            ];
        }

        $categoria->delete();

        return [
            'error' => false,
            'message' => 'Categoría eliminada correctamente.'
        ];
    }

}