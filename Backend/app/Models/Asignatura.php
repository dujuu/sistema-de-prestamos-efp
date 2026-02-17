<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Modelo que representa una asignatura dentro del sistema académico.
 *
 * Las asignaturas pueden estar asociadas a uno o varios docentes a través
 * de la tabla pivote `asignatura_docente`. Este modelo contiene únicamente
 * información básica (nombre), manteniendo una estructura simple y coherente
 * con su propósito dentro del dominio.
 *
 * @package App\Models
 */
class Asignatura extends Model
{
    /**
     * Nombre de la tabla correspondiente en la base de datos.
     *
     * @var string
     */
    protected $table = 'asignaturas';
    /**
     * Nombre de la clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'idAsignatura';
    /**
     * Atributos susceptibles de asignación masiva.
     *
     * @var array
     */
    protected $fillable = ['nombre'];
    
    /**
     * Controla el uso automático de timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

        /**
     * Relación muchos a muchos con docentes.
     *
     * Una asignatura puede tener múltiples docentes asignados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'asignatura_docente', 'idAsignatura', 'idDocente');
    }
}
