<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoEquipo extends Model
{
    use HasFactory;

    protected $table = 'prestamo_equipo';

    protected $fillable = [
        'idPrestamo',
        'idEquipo',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'idPrestamo', 'idPrestamo');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'idEquipo', 'id');
    }
}
