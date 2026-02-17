<?php
namespace App\Services;

use App\Models\Equipo;

/**
 * Servicio encargado de gestionar las operaciones de negocio relacionadas con Equipos.
 *
 * Esta clase centraliza toda la lógica asociada a la consulta, creación, actualización
 * y eliminación de equipos, manteniendo una arquitectura desacoplada en la cual
 * el controlador se limita únicamente a coordinar solicitudes y delegar trabajo.
 *
 * Principios aplicados:
 * - SRP (Single Responsibility Principle): el servicio contiene la lógica del dominio.
 * - Consulta relacional optimizada mediante joins explícitos.
 * - Uso estandarizado de excepciones controladas.
 *
 * @package App\Services
 */

class EquipoService
{

    /**
     * Obtiene el listado completo de equipos registrados en el sistema.
     *
     * Este método ejecuta una consulta relacional que une las tablas
     * `equipos`, `tipo_equipos` y `categorias` para construir un objeto
     * enriquecido que incluye información estructurada del equipo:
     *
     *  - ID del equipo (`idEquipo`)
     *  - Código del activo
     *  - Estado actual
     *  - Timestamps de creación y actualización
     *  - Nombre del modelo asociado
     *  - Categoría correspondiente
     *
     * Esta consulta está optimizada para entregar al frontend (nuevo y legado)
     * un dataset completo sin requerir consultas adicionales.
     *
     * @return Collection  Colección de equipos con información relacional.
     */
    public function getAll()
    {
        return Equipo::select(
            'equipos.id as idEquipo',
            'equipos.codigo',
            'equipos.estado',
            'equipos.created_at',
            'equipos.updated_at',
            'tipo_equipos.nombre as nombre',
            'categorias.nombre as categoria'
        )
        ->join('tipo_equipos', 'tipo_equipos.id', '=', 'equipos.tipo_equipo_id')
        ->join('categorias', 'categorias.id', '=', 'tipo_equipos.categoria_id')
        ->get();
    }

    /**
     * Obtiene un equipo específico por su identificador.
     *
     * La estructura del retorno es idéntica al formato proporcionado por `getAll`,
     * asegurando consistencia en la API. Si el equipo no existe, se genera una
     * excepción `ModelNotFoundException` que es manejada por el controlador.
     *
     * @param  int  $id  Identificador del equipo a consultar.
     * @return object    Objeto con la información del equipo solicitado.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById($id)
    {
        return Equipo::select(
            'equipos.id as idEquipo',
            'equipos.codigo',
            'equipos.estado',
            'equipos.created_at',
            'equipos.updated_at',
            'tipo_equipos.nombre as nombre',
            'categorias.nombre as categoria'
        )
        ->join('tipo_equipos', 'tipo_equipos.id', '=', 'equipos.tipo_equipo_id')
        ->join('categorias', 'categorias.id', '=', 'tipo_equipos.categoria_id')
        ->where('equipos.id', $id)
        ->firstOrFail();
    }


    /**
     * Crea un nuevo registro de equipo en la base de datos.
     *
     * Este método recibe datos previamente validados desde el controlador o desde
     * un Form Request. La creación se delega al modelo Eloquent, manteniendo la
     * separación de responsabilidades y permitiendo pruebas unitarias más limpias.
     *
     * @param  array  $data  Datos validados necesarios para crear un equipo.
     * @return Equipo         Instancia del nuevo registro creado.
     */
    public function create($data)
    {
        return Equipo::create($data);
    }

    /**
     * Actualiza los datos de un equipo existente.
     *
     * El método recupera el equipo mediante `findOrFail`, aplica los cambios
     * mediante `fill()` y persiste la actualización llamando a `save()`.
     * Se retorna el modelo actualizado para mantener trazabilidad.
     *
     * @param  int    $id    Identificador del equipo.
     * @param  array  $data  Datos validados a actualizar.
     * @return Equipo         Equipo actualizado.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($id, $data)
    {  
        $equipo = Equipo::findOrFail($id);
        $equipo->fill($data);
        $equipo->save();

        return $equipo;
    }

    
    /**
     * Elimina un equipo del sistema.
     *
     * Dependiendo de la implementación del modelo Equipo, esta operación puede
     * corresponder a un borrado lógico (`softDelete`) o físico. El método retorna
     * el registro eliminado para fines de auditoría o visualización en el frontend.
     *
     * @param  int  $id  Identificador del equipo a eliminar.
     * @return Equipo     Registro eliminado.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return $equipo;
    }
}
