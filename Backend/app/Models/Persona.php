<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
protected $primaryKey = 'idPersona';
    protected $table = 'persona';
    
    protected $fillable = [
        'Nombre', 'apellido1', 'apellido2', 'Rut', 'Email'
    ];
    
    // Relación inversa UNO A UNO: Una persona tiene un usuario.
    public function user()
    {
        // hasOne(Modelo, clave_foranea_local, clave_primaria_local)
        return $this->hasOne(User::class, 'idPersona', 'idPersona');
    }
}
