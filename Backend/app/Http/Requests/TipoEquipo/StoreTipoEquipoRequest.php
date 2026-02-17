<?php

namespace App\Http\Requests\TipoEquipo;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoEquipoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categoria_id' => 'required|exists:categorias,id',

            'nombre'       => 'required|string|max:255|unique:tipo_equipos,nombre',

            'imagen'       => 'nullable|image|max:2048',

            'descripcion'  => 'nullable|string'
        ];
    }
}
