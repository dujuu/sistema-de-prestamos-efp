<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un equipo físico disponible para préstamo.
 *
 * Este modelo almacena la información esencial del equipo, incluyendo su
 * relación con el tipo de equipo y los equipos recomendados asociados para
 * sugerencias o compatibilidad.
 *
 * Atributos principales:
 * - tipo_equipo_id
 * - codigo
 * - estado
 *
 * Relaciones disponibles:
 * - tipo(): Relación con el modelo TipoEquipo.
 * - recomendados(): Equipos sugeridos como complementarios.
 * - recomendadoPor(): Equipos que sugieren este equipo como complemento.
 *
 * @package App\Models
 */

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_equipo_id',
        'codigo',
        'estado'
    ];

    /**
     * Relación: un equipo pertenece a un tipo de equipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoEquipo::class, 'tipo_equipo_id');
    }

    /**
     * Relación: equipos recomendados asociados a este equipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recomendados()
    {
        return $this->belongsToMany(
            Equipo::class,
            'equipos_relacionados',
            'equipo_id',
            'relacionado_id'
        )->withPivot('tipo_relacion')
         ->withTimestamps();
    }

    /**
     * Relación inversa: equipos que recomiendan a este equipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recomendadoPor()
    {
        return $this->belongsToMany(
            Equipo::class,
            'equipos_relacionados',
            'relacionado_id',
            'equipo_id'
        )->withPivot('tipo_relacion')
         ->withTimestamps();
    }
}
