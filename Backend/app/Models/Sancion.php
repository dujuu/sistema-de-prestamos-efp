<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sancion extends Model
{
    protected $table = 'sancions';
    protected $primaryKey = 'idSancion';
    protected $fillable = ['nivel', 'estado', 'fecha_inicio', 'fecha_fin'];
    public $timestamps = true;

    // 🔹 Relaciones
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sancion', 'idSancion', 'idUser');
    }
}
