<?php

namespace App\Http\Requests\equipoRelacionado;

use Illuminate\Foundation\Http\FormRequest;

class StoreRelacionadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'equipo_id' => 'required|integer|exists:equipos,id',
            'relacionado_id' => 'required|integer|exists:equipos,id|different:equipo_id',
            'tipo_relacion' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'relacionado_id.different' => 'Un equipo no puede relacionarse consigo mismo.',
        ];
    }
}
