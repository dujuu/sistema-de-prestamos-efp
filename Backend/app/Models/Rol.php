<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
// Mapeo a la tabla 'rol'
    protected $table = 'rol';

    // Clave primaria
    protected $primaryKey = 'idRol';
    
    // Los campos que se pueden asignar masivamente.
    protected $fillable = [
        'Nombre', 
        'Descricion', 
    ];
    
    // ** RELACIÓN MUCHOS A MUCHOS CON USER **
    public function users()
    {
        // belongsToMany(Modelo_Relacionado, tabla_pivote, clave_local_en_pivote, clave_remota_en_pivote)
        return $this->belongsToMany(
            User::class,     
            'rol_user',      
            'idRol',         
            'idUser'         
        );
    }
}
