<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'nombre'    => 'sometimes|required|string|max:255',
            'codigo' => 'sometimes|required|string|unique:equipos,codigo,' . $id,

            'categoria' => 'sometimes|required|string|max:255',
            'estado'    => 'sometimes|required|string|max:30',
        ];
    }
}
