<?php

namespace App\Http\Requests\equipoRelacionado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRelacionadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tipo_relacion' => 'required|string|max:255',
        ];
    }
}
