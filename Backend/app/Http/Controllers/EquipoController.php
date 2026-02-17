<?php

namespace App\Http\Controllers;

use App\Services\EquipoService;
use App\Http\Requests\Equipo\StoreEquipoRequest;
use App\Http\Requests\Equipo\UpdateEquipoRequest;

/**
 * Controlador responsable de gestionar las operaciones CRUD del módulo de Equipos.
 *
 * Este controlador se encarga de recibir solicitudes HTTP, delegar la lógica de negocio
 * a `EquipoService` y retornar respuestas JSON estandarizadas. La validación se realiza
 * mediante Form Requests especializados (`StoreEquipoRequest`, `UpdateEquipoRequest`),
 * garantizando consistencia y separación de responsabilidades.
 *
 * Principios aplicados:
 * - SRP (Single Responsibility Principle): el controlador solo coordina solicitudes.
 * - Arquitectura desacoplada: controlador liviano + servicio dedicado.
 * - Validación centralizada mediante Form Requests.
 *
 * Funcionalidades principales:
 *  - index():    Listar todos los equipos.
 *  - store():    Registrar un nuevo equipo.
 *  - show():     Consultar un equipo específico.
 *  - update():   Modificar datos de un equipo existente.
 *  - destroy():  Eliminar un equipo.
 *
 * @package App\Http\Controllers
 */
class EquipoController extends Controller
{
    /**
     * Retorna el listado completo de equipos disponibles en el sistema.
     *
     * Este método delega la obtención de los datos al `EquipoService`, manteniendo el
     * controlador libre de lógica de negocio. Se retorna una respuesta JSON estandarizada
     * con código HTTP 200.
     *
     * @param  EquipoService  $service  Servicio encargado de gestionar los equipos.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EquipoService $service)
    {
        return response()->json($service->getAll(), 200);
    }

    /**
     * Registra un nuevo equipo en la base de datos.
     *
     * El método recibe una solicitud validada mediante `StoreEquipoRequest`, lo que
     * garantiza que los datos requeridos estén completos y en el formato correcto.
     * Posteriormente, delega la creación del equipo al `EquipoService`.
     *
     * En caso de éxito, se retorna código HTTP 201 (Created).  
     * En caso de error, se captura la excepción y se retorna un mensaje controlado
     * evitando exponer información interna del sistema.
     *
     * @param  StoreEquipoRequest  $request  Datos validados para crear un equipo.
     * @param  EquipoService       $service  Servicio que contiene la lógica de registro.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEquipoRequest $request, EquipoService $service)
    {
        $data = $request->validated();

        try {
            $equipo = $service->create($data);

            return response()->json([
                'message' => 'Equipo creado correctamente.',
                'equipo'  => $equipo,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'error'   => 'Error al crear el equipo.',
                'message' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Obtiene un equipo específico mediante su identificador.
     *
     * En caso de que el equipo no exista, el servicio lanzará una excepción
     * `ModelNotFoundException`, la cual es manejada por Laravel para retornar
     * automáticamente un código HTTP 404.
     *
     * @param  int            $idEquipo  Identificador del equipo.
     * @param  EquipoService  $service   Servicio encargado de la consulta.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($idEquipo, EquipoService $service)
    {
        return response()->json($service->getById($idEquipo), 200);
    }

    /**
     * Actualiza los datos de un equipo registrado.
     *
     * `UpdateEquipoRequest` garantiza la integridad de los datos antes de la actualización.
     * La operación es ejecutada por el servicio correspondiente, mientras que el controlador
     * únicamente administra la solicitud y la respuesta.
     *
     * @param  UpdateEquipoRequest  $request   Datos validados para la actualización.
     * @param  int                  $idEquipo  Identificador del equipo.
     * @param  EquipoService        $service   Servicio encargado de la actualización.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEquipoRequest $request, $idEquipo, EquipoService $service)
    {
        $data = $request->validated();

        try{
            $equipo = $service->update($idEquipo, $data);

            return response()->json([
                'message' => 'Equipo actualizado correctamente.',
                'equipo'  => $equipo,
            ], 200);

        }catch(\Exception $e){

            return response()->json([
                'error'   => 'Error al actualizar el equipo.',
                'message' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Elimina un equipo del sistema de forma definitiva.
     *
     * Esta acción ejecuta un borrado físico del registro en la base de datos.
     * Cualquier excepción producida durante el proceso es gestionada para
     * retornar una respuesta controlada y evitar la exposición de información
     * sensible del sistema.
     *
     * @param  int            $idEquipo  Identificador del equipo a eliminar.
     * @param  EquipoService  $service   Servicio encargado de la eliminación.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($idEquipo, EquipoService $service)
    {
        try{
            $equipo = $service->delete($idEquipo);

            return response()->json([
                'message' => 'Equipo eliminado correctamente.',
                'equipo'  => $equipo,
            ], 200);

        }catch(\Exception $e){

            return response()->json([
                'error'   => 'Error al eliminar el equipo.',
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
