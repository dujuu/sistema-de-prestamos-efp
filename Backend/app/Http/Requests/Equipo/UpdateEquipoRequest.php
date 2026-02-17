    <?php

    namespace App\Http\Requests\Equipo;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Form Request encargado de validar los datos enviados para actualizar un equipo existente.
     *
     * A diferencia del registro, en este caso los campos se validan utilizando `sometimes`,
     * permitiendo actualizaciones parciales sin requerir todos los atributos. Esto ofrece
     * flexibilidad para modificaciones específicas sin comprometer la integridad de los datos.
     *
     * @package App\Http\Requests\Equipo
    */
    class UpdateEquipoRequest extends FormRequest
    {

        /**
         * Determina si el usuario está autorizado para ejecutar esta actualización.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Reglas de validación aplicadas a actualizaciones de equipos.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'tipo_equipo_id' => 'sometimes|required|exists:tipo_equipos,id',
                'codigo'         => 'sometimes|required|string|max:50',
                'estado'         => 'sometimes|required|string|max:225'
            ];
        }
    }
