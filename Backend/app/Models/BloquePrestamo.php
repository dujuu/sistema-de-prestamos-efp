<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Modelo pivote que representa la asignación de bloques horarios a préstamos.
 *
 * Esta entidad cumple un rol fundamental dentro del sistema, ya que permite:
 *  - Asociar un préstamo a uno o varios bloques horarios.
 *  - Vincular una asignatura específica al préstamo cuando corresponde.
 *  - Mantener un registro estructurado de las reservas realizadas.
 *
 * A diferencia de los pivotes simples de Laravel, este modelo posee:
 *  - Su propia clave primaria (`idBloquePrestamo`).
 *  - Campos adicionales más allá de las llaves foráneas.
 *  - Relaciones explícitas con las entidades Bloque, Prestamo y Asignatura.
 *
 * Esto lo convierte en un pivote "rico" (rich pivot model), utilizado cuando la
 * tabla intermedia almacena información relevante para el dominio del sistema.
 *
 * @package App\Models
 */
class BloquePrestamo extends Model
{
    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'bloque_prestamos';
    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'idBloquePrestamo';
    /**
     * Indica que la tabla no gestiona timestamps automáticos.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos disponibles para asignación masiva.
     *
     * @var array
     */
    protected $fillable = [
        'idPrestamo',
        'idBloque',
        'idAsignatura'
    ];

    /**
     * Relación con el modelo Bloque.
     *
     * Representa el bloque horario vinculado al préstamo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bloque()
    {
        return $this->belongsTo(Bloque::class, 'idBloque');
    }

    /**
     * Relación con el modelo Asignatura.
     *
     * Permite asociar la reserva a un ramo específico cuando
     * sea requerido por las políticas de préstamo institucional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'idAsignatura');
    }

    /**
     * Relación con el modelo Prestamo.
     *
     * Identifica el préstamo al cual está asociado el bloque horario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'idPrestamo');
    }
}
