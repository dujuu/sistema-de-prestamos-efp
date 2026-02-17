<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'     => 'required|string|max:255',
            'apellido1'  => 'required|string|max:255',
            'apellido2'  => 'nullable|string|max:255',
            'rut'        => 'required|string|unique:persona,Rut',
            'email'      => 'required|email|unique:users,Email',
            'telefono'   => 'nullable|string|max:20',
            'celular'    => 'nullable|string|max:20',
            'password'   => 'required|string|min:6',
            'rol'        => 'required|string|in:admin,alumno'
        ];
    }
}
