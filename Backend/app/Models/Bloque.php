<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un bloque horario dentro del sistema de préstamos.
 *
 * Un bloque define un intervalo específico de tiempo compuesto por una hora
 * de inicio y una hora de término, permitiendo organizar horarios disponibles
 * para reservas, préstamos y administración académica.
 *
 * Este modelo se relaciona con los préstamos mediante una tabla pivote,
 * permitiendo que un préstamo pueda estar asociado a uno o varios bloques
 * dependiendo de la estructura operativa del sistema.
 *
 * @package App\Models
 */
class Bloque extends Model
{
    /**
     * Tabla asociada al modelo en la base de datos.
     *
     * @var string
     */
    protected $table = 'bloques';
    /**
     * Nombre de la clave primaria.
     *
     * @var string
     */
    protected $primaryKey = 'idBloque';
    
    /**
     * Indica que la tabla no utiliza columnas de timestamps.
     *
     * @var bool
     */
    public $timestamps = false;
     /**
     * Campos que pueden asignarse masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'hora_inicio',
        'hora_fin'
    ];

    /**
     * Relación muchos a muchos con la entidad Prestamo.
     *
     * Un bloque puede estar asociado a uno o varios préstamos mediante la tabla
     * pivote `bloquePrestamos`. Esto permite asignar bloques horarios a reservas,
     * manteniendo un control estructurado sobre los rangos disponibles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function prestamos()
    {
        return $this->belongsToMany(
            Prestamo::class,
            'bloquePrestamos',
            'idBloque',
            'idPrestamo'
        );
    }
}
