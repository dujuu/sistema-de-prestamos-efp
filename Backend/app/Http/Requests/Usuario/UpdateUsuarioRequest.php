<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
/**
 * FormRequest encargado de validar los datos enviados para la actualización de un usuario.
 *
 * Esta clase centraliza todas las reglas de validación relacionadas con la modificación
 * de un usuario, garantizando que el controlador reciba únicamente información segura
 * y previamente filtrada. Su uso mejora la mantenibilidad, cohesión y claridad del código,
 * cumpliendo con buenas prácticas de Laravel y principios de arquitectura limpia.
 */
class UpdateUsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * En este caso se permite el acceso sin restricciones adicionales, ya que la
     * autorización se gestiona a nivel de rutas o middleware.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Define las reglas de validación para la actualización de un usuario.
     *
     * Cada campo es validado según su tipo, formato y restricciones de negocio.
     * - Los nombres y apellidos deben ser cadenas válidas.
     * - El correo debe cumplir el formato estándar de email.
     * - El rol debe existir en la tabla "rol".
     * - Campos como apellido2, teléfono y celular son opcionales (nullable).
     * 
     * La responsabilidad de este método es filtrar datos inválidos y asegurar que
     * la información cumpla con las reglas antes de llegar al controlador o servicio.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'     => 'required|string|max:255',
            'apellido1'  => 'required|string|max:255',
            'apellido2'  => 'nullable|string|max:255',
            'rut'        => 'required|string',
            'email'      => 'required|email',
            'telefono'   => 'nullable|string|max:20',
            'celular'    => 'nullable|string|max:20',
            'password'   => 'nullable|string|min:6',
            'rol'        => 'required|string|exists:rol,Nombre'
        ];
    }

}
