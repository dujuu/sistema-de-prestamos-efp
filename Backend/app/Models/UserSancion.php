<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSancion extends Model
{
    protected $table = 'user_sancion';
    protected $fillable = ['idUser', 'idSancion'];
    public $timestamps = false;

    // 🔹 Relaciones
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function sancion()
    {
        return $this->belongsTo(Sancion::class, 'idSancion');
    }
}
