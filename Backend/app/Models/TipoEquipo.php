<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    use HasFactory;

    protected $table ='tipo_equipos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'categoria_id',
        'nombre',
        'imagen',
        'descripcion'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
        public function equipos()
    {
        return $this->hasMany(Equipo::class, 'tipo_equipo_id');
    }

    protected $casts = [
    'categoria_id' => 'integer',
];

}
