<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo pivote que representa relaciones entre equipos del inventario.
 *
 * Esta tabla permite establecer conexiones entre diferentes equipos para:
 *  - Recomendar accesorios compatibles
 *  - Definir dependencias entre equipos
 *  - Crear combinaciones o kits predefinidos
 *
 * A diferencia de un pivote tradicional, este modelo posee:
 *  - Atributo propio (`tipo_relacion`)
 *  - Modelo explícito para consultas avanzadas
 *  - Uso de Eloquent completo para lógica o validaciones futuras
 *
 * Ejemplos de `tipo_relacion`:
 *  - "accesorio"
 *  - "compatible"
 *  - "kit"
 *
 * Su uso permite mejorar la experiencia del usuario mostrando recomendaciones
 * contextuales según el equipo seleccionado.
 *
 * @package App\Models
 */
class EquipoRelacionado extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'equipos_relacionados';


    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'equipo_id',
        'relacionado_id',
        'tipo_relacion',
    ];

    /**
     * Relación con el modelo Equipo (equipo principal).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    /**
     * Relación con el modelo Equipo (equipo relacionado).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relacionado()
    {
        return $this->belongsTo(Equipo::class, 'relacionado_id');
    }
}
