<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una observación asociada a un préstamo.
 *
 * Las observaciones permiten registrar detalles relevantes del proceso
 * de préstamo, tales como comentarios administrativos, estados especiales,
 * advertencias, notas del docente o indicaciones del laboratorio.
 *
 * Cada observación pertenece a un préstamo específico y puede reflejar
 * distintos estados o situaciones detectadas durante la entrega o devolución
 * del equipo.
 *
 * Ejemplos de uso:
 *  - "Equipo devuelto con daños"
 *  - "Falta cable HDMI"
 *  - "Retraso en la entrega"
 *
 * @package App\Models
 */
class observacion extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'observaciones';
    
    
    /**
     * Clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'idObservacion';
    
    /**
     * Indica que el modelo no utiliza timestamps automáticos.
     *
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'idPrestamo',
        'descripcion',
        'estado',
    ];

    /**
     * Relación con el modelo Prestamo.
     *
     * Permite acceder al préstamo al cual pertenece la observación.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'idPrestamo');
    }
}
