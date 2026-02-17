<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una categoría dentro del sistema de inventario.
 *
 * Las categorías permiten agrupar diferentes tipos de equipos en grupos lógicos,
 * facilitando la organización, búsqueda y filtrado dentro del flujo de préstamo.
 * Cada categoría puede contener múltiples tipos de equipos, lo que la convierte
 * en un elemento clave para estructurar el catálogo general.
 *
 * Ejemplos de categorías posibles:
 *  - Cámaras
 *  - Iluminación
 *  - Audio
 *  - Accesorios
 *
 * Este modelo mantiene una relación uno-a-muchos con `TipoEquipo`, lo que permite
 * obtener todos los modelos asociados a una categoría en particular.
 *
 * @package App\Models
 */
class Categoria extends Model
{
    use HasFactory;
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id';
        /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    /**
     * Relación uno a muchos con TipoEquipo.
     *
     * Una categoría puede contener múltiples tipos de equipos disponibles
     * dentro del inventario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function tipoEquipos()
    {
        return $this->hasMany(TipoEquipo::class, 'categoria_id');
    }


}
