<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo pivote que representa la relación entre asignaturas y docentes.
 *
 * Esta entidad corresponde a la tabla intermedia `asignatura_docente`, la cual
 * permite gestionar la vinculación de múltiples docentes a múltiples asignaturas.
 * No utiliza timestamps y funciona como tabla de relación explícita dentro del
 * sistema académico.
 *
 * @package App\Models
 */
class AsignaturaDocente extends Model
{
    /**
     * Nombre de la tabla correspondiente.
     *
     * @var string
     */
    protected $table = 'asignatura_docente';
    
    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = ['idAsignatura', 'idDocente'];
    /**
     * Indica que la tabla pivote no utiliza columnas de timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    
    
    /**
     * Relación con el modelo Asignatura.
     *
     * Representa la asignatura asociada a esta relación.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'idAsignatura');
    }

    /**
     * Relación con el modelo Docente.
     *
     * Representa el docente vinculado a la asignatura.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'idDocente');
    }
}
