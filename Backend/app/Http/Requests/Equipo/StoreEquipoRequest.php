<?php

namespace App\Http\Requests\Equipo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request encargado de validar los datos para la creación de un nuevo equipo.
 *
 * Esta clase centraliza las reglas de validación, garantizando que únicamente datos
 * consistentes y seguros sean procesados por el controlador y posteriormente por el
 * servicio. Su uso permite mantener un controlador limpio, aplicar el principio de
 * responsabilidad única (SRP) y asegurar la integridad de la información antes de
 * interactuar con la base de datos.
 *
 * @package App\Http\Requests\Equipo
 */
class StoreEquipoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * En este caso se permite el acceso irrestricto, asumiendo que el control de
     * permisos está delegado a middleware o autenticación superior.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Reglas de validación aplicadas a la creación de un equipo.
     *
     * - tipo_equipo_id: Obligatorio, debe existir en la tabla tipo_equipos.
     * - codigo: Texto obligatorio, máximo 225 caracteres.
     * - estado: Estado inicial del equipo (disponible, prestado, etc.).
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipo_equipo_id' => 'required|exists:tipo_equipos,id',
            'codigo'         => 'required|string|max:225',
            'estado'         => 'required|string|max:50'
        ];
    }
}
