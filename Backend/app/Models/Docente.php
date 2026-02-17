<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa a un docente dentro del sistema académico.
 *
 * Un docente está asociado a una persona mediante la clave foránea `idPersona`,
 * lo que permite mantener separada la información personal de la información
 * administrativa y académica. Este enfoque promueve cohesión y claridad en la
 * arquitectura del modelo de datos.
 *
 * Además, un docente puede estar vinculado a múltiples asignaturas a través de
 * la tabla pivote `asignatura_docente`, permitiendo representar correctamente
 * la estructura académica donde un docente puede impartir varios ramos.
 *
 * @package App\Models
 */
class Docente extends Model
{
    /**
     * Tabla asociada en la base de datos.
     *
     * @var string
     */
    protected $table = 'docentes';

    /**
     * Clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'idDocente';
    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = ['codigo', 'descripcion', 'idPersona'];
    /**
     * Indica si el modelo debe manejar timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Relación uno a uno inversa con Persona.
     *
     * Cada docente corresponde a una persona registrada en el sistema.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idPersona');
    }

    /**
     * Relación muchos a muchos con asignaturas.
     *
     * Un docente puede impartir múltiples asignaturas, representadas mediante
     * la tabla pivote `asignatura_docente`. Esta relación permite consultar
     * fácilmente todas las asignaturas asignadas a un docente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_docente', 'idDocente', 'idAsignatura');
    }
}
