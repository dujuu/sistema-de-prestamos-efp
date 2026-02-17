<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipoRequest extends FormRequest
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
            'nombre'    => 'required|string|max:255',
            'codigo' => 'required|string|unique:equipos,codigo',

            'categoria' => 'required|string|max:255',
            'estado'    => 'required|string|max:30',
        ];
    }
}
