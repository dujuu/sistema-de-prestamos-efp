<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Services\UsuarioService;

/**
 * Controlador responsable de gestionar las operaciones CRUD relacionadas con usuarios.
 *
 * Este controlador actúa como intermediario entre las solicitudes HTTP y la lógica
 * de negocio encapsulada en UsuarioService. Se aplica el principio de responsabilidad
 * única (SRP), manteniendo el controlador delgado y delegando la lógica compleja al servicio.
 *
 * @package App\Http\Controllers
 */
class UsuarioController extends Controller
{
    /**
     * Obtiene el listado completo de usuarios del sistema.
     *
     * Este método sirve como punto de entrada para consultar todos los usuarios registrados.
     * Se delega la lógica al UsuarioService para mantener cohesión y separación de responsabilidades.
     *
     * @param  UsuarioService  $service  Servicio encargado de la gestión de usuarios.
     * @return \Illuminate\Http\JsonResponse   Respuesta JSON con el listado de usuarios.
     */
    public function index(UsuarioService $service)
    {
        try {
            $usuarios = $service->listarUsuarios();
            return response()->json($usuarios, 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Error al obtener los usuarios',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registra un nuevo usuario en el sistema.
     *
     * Este método recibe una solicitud validada mediante StoreUsuarioRequest,
     * delega la creación al UsuarioService y retorna una respuesta estructurada.
     *
     * @param  StoreUsuarioRequest  $request  Datos validados del nuevo usuario.
     * @param  UsuarioService       $service  Servicio responsable de la creación.
     * @return \Illuminate\Http\JsonResponse  Respuesta JSON con el usuario creado.
     */    
    public function store(StoreUsuarioRequest $request, UsuarioService $service)
    {
        try {
            $usuario = $service->crearUsuario($request->validated());

            return response()->json([
                'message' => 'Usuario creado correctamente',
                'data' => $usuario
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'error'   => 'Error al crear el usuario',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Muestra la información de un usuario específico.
     *
     * Este método permite obtener un usuario por su ID. Si el usuario no existe,
     * se captura la excepción y se retorna una respuesta adecuada.
     *
     * @param  int             $id       Identificador del usuario a consultar.
     * @param  UsuarioService  $service   Servicio encargado de la obtención.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con los datos del usuario.
     */  
    public function show($id, UsuarioService $service)
    {
        try {
            $usuario = $service->obtenerUsuario($id);
            return response()->json($usuario, 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Usuario no encontrado',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualiza los datos de un usuario específico.
     *
     * Este método recibe una solicitud validada mediante UpdateUsuarioRequest,
     * delega la actualización al UsuarioService y retorna un mensaje estandarizado
     * según el resultado de la operación.
     *
     * @param  UpdateUsuarioRequest $request   Solicitud validada con reglas de actualización.
     * @param  int                  $id        Identificador del usuario a actualizar.
     * @param  UsuarioService       $service   Servicio que gestiona la modificación.
     *
     * @return \Illuminate\Http\JsonResponse    Respuesta JSON con el usuario actualizado.
     */
    public function update(UpdateUsuarioRequest $request, $id, UsuarioService $service)
    {
        try {
            $data = $request->validated();
            $usuario = $service->actualizarUsuario($id, $data);

            return response()->json([
                'message' => 'Usuario actualizado correctamente',
                'data' => $usuario
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Error al actualizar el usuario',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un usuario del sistema.
     *
     * Este método solicita al UsuarioService la eliminación del usuario especificado.
     * En caso de error, retorna una respuesta controlada para mantener consistencia
     * en las respuestas de la API.
     *
     * @param  int             $id       Identificador del usuario a eliminar.
     * @param  UsuarioService  $service  Servicio encargado de la eliminación.
     * @return \Illuminate\Http\JsonResponse  Respuesta JSON confirmando la operación.
     */
    public function destroy($id, UsuarioService $service)
    {
        try {
            $service->eliminarUsuario($id);

            return response()->json([
                'message' => 'Usuario eliminado correctamente'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error'   => 'Error al eliminar el usuario',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
