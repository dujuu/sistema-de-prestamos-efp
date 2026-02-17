<?php

namespace App\Http\Requests\TipoEquipo;

use Illuminate\Foundation\Http\FormRequest;

class  UpdateTipoEquipoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
                    'categoria_id' => 'sometimes|required|exists:categorias,id',

                    'nombre'       => 'sometimes|required|string|max:255|unique:tipo_equipos,nombre,' . $id,

                    'imagen'       => 'sometimes|nullable|string',

                    'descripcion'  => 'sometimes|nullable|string'
                ];
    }
}
