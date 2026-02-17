<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un préstamo dentro del sistema de gestión de equipos.
 *
 * Un préstamo corresponde a una solicitud realizada por un usuario para obtener
 * uno o varios equipos durante un período específico. Este modelo es central en
 * el flujo operativo, ya que controla:
 *  - Usuario solicitante
 *  - Fechas de inicio y fin
 *  - Estado actual del préstamo
 *  - Equipos asociados
 *  - Bloques horarios reservados
 *  - Observaciones administrativas
 *
 * Su estructura permite mantener trazabilidad completa de cada préstamo,
 * integrándose con múltiples entidades del sistema, incluyendo usuarios,
 * equipos, bloques y observaciones.
 *
 * @package App\Models
 */
class Prestamo extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     *
     * @var string
     */
    protected $table = 'prestamos';
    /**
     * Clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'idPrestamo';

    /**
     * Indica que la clave primaria es autoincremental.
     *
     * @var bool
     */
    public $incrementing = true;
    /**
     * Tipo de datos de la clave primaria.
     *
     * @var string
     */
    protected $keyType = 'int';


    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'idUser',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'otra_motivo',
        'tipo',
        'observacion',
    ];

    /* ===================== Relaciones ===================== */

    /**
     * Relación con el usuario que realizó el préstamo.
     *
     * Cada préstamo pertenece a un único usuario, identificado mediante `idUser`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // asumiendo que users tiene PK idUser (como usas en FK)
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    /**
     * Relación muchos a muchos con equipos.
     *
     * Un préstamo puede incluir uno o varios equipos, administrados a través
     * de la tabla pivote `prestamo_equipo`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function equipos()
    {
        return $this->belongsToMany(
            Equipo::class,
            'prestamo_equipo',
            'idPrestamo', 
            'idEquipo'    
        );
    }

    /**
     * Relación uno a muchos con BloquePrestamo.
     *
     * Permite obtener todos los bloques horarios asociados a un préstamo,
     * representando las horas reservadas en la programación académica.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bloquePrestamo()
    {
        return $this->hasMany(BloquePrestamo::class, 'idPrestamo', 'idPrestamo');
    }
}
