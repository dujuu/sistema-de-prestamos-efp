<?php

namespace App\Services;

use App\Models\Persona;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

/**
 * Servicio encargado de gestionar las operaciones de negocio relacionadas con los usuarios.
 *
 * Esta clase centraliza la lógica referente a:
 *  - Listado paginado de usuarios con información completa.
 *  - Obtención de usuarios con sus relaciones.
 *  - Registro de usuarios (Persona + User + Rol asociado).
 *  - Actualización integral de datos personales, credenciales y rol.
 *  - Eliminación controlada que asegura integridad relacional.
 *
 * Su objetivo principal es mantener un controlador delgado y delegar toda la lógica
 * compleja a este servicio, cumpliendo con el principio SRP (Single Responsibility Principle)
 * y una arquitectura limpia típica en sistemas empresariales.
 *
 * @package App\Services
 */

class UsuarioService
{

    /**
     * Obtiene un listado paginado de usuarios con su información personal y rol asociado.
     *
     * La consulta combina datos de:
     *  - Tabla `users`
     *  - Tabla `persona`
     *  - Tabla pivote `rol_user`
     *  - Tabla `rol`
     *
     * Entrega un conjunto de datos consistente, listo para ser consumido por el frontend.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listarUsuarios()
    {
        return User::select(
                'users.idUser as id',
                'persona.Nombre as nombre',
                'persona.apellido1',
                'persona.apellido2',
                'persona.Rut as rut',
                'users.Email as email',
                'persona.telefono',
                'persona.celular',
                'rol.Nombre as rol'
            )
            ->join('persona', 'persona.idPersona', '=', 'users.idPersona')
            ->leftJoin('rol_user', 'rol_user.idUser', '=', 'users.idUser')
            ->leftJoin('rol', 'rol.idRol', '=', 'rol_user.idRol')
            ->orderBy('persona.Nombre', 'asc')
            ->paginate(50);       
    }


    /**
     * Obtiene un usuario específico mediante su ID.
     *
     * Retorna datos unificados y consistentes de: User, Persona y Rol.
     * Si el usuario no existe, lanza una excepción `ModelNotFoundException`,
     * manejada posteriormente por el controlador.
     *
     * @param  int  $id   Identificador del usuario.
     * @return object     Información completa del usuario consultado.
     */
    public function obtenerUsuario($id)
    {
        return User::select(
                'users.idUser as id',
                'persona.Nombre as nombre',
                'persona.apellido1',
                'persona.apellido2',
                'persona.Rut as rut',
                'users.Email as email',
                'persona.telefono',
                'persona.celular',
                'rol.Nombre as rol'
            )
            ->join('persona', 'persona.idPersona', '=', 'users.idPersona')
            ->leftJoin('rol_user', 'rol_user.idUser', '=', 'users.idUser')
            ->leftJoin('rol', 'rol.idRol', '=', 'rol_user.idRol')
            ->where('users.idUser', $id)
            ->firstOrFail();
    }


    
    /**
     * Crea un nuevo usuario en el sistema.
     *
     * Este proceso incluye:
     *  - Crear registro en `persona`
     *  - Crear registro en `users` con contraseña hasheada
     *  - Asociar rol en `rol_user`
     *
     * La operación retorna un arreglo estructurado con las entidades creadas.
     *
     * @param  array  $data  Datos validados para el registro.
     * @return array         Información del usuario recién creado.
     */
    public function crearUsuario($data)
    {
        // Crear persona
        $persona = Persona::create([
            'Nombre'     => $data['nombre'],
            'apellido1'  => $data['apellido1'],
            'apellido2'  => $data['apellido2'] ?? null,
            'Rut'        => $data['rut'],
            'Email'      => $data['email'],
            'telefono'   => $data['telefono'] ?? null,
            'celular'    => $data['celular'] ?? null
        ]);

        // Crear usuario vinculado a la persona
        $usuario = User::create([
            'idPersona'  => $persona->idPersona,
            'Contrasena' => Hash::make($data['password']),
            'Email'      => $data['email'],
        ]);

        // Asignar rol
        $rol = Rol::where('Nombre', $data['rol'])->firstOrFail();

        
        $usuario->roles()->attach($rol->idRol);

        return [
            'persona' => $persona,
            'usuario' => $usuario,
            'rol'     => $rol->Nombre
        ];
    }

    /**
     * Actualiza los datos de un usuario, su persona asociada y su rol.
     *
     * Este método permite actualizar:
     *  - Datos personales (Nombre, apellidos, contacto).
     *  - Email histórico y actual.
     *  - Contraseña (si viene incluida).
     *  - Rol asignado, reemplazándolo mediante sync().
     *
     * Mantiene integridad relacional y utiliza validaciones previas garantizadas
     * por `UpdateUsuarioRequest`.
     *
     * @param  int    $id    Identificador del usuario.
     * @param  array  $data  Datos validados a actualizar.
     * @return array          Información actualizada del usuario.
     */
    public function actualizarUsuario($id, $data)
    {
        $usuario = User::findOrFail($id);
        $persona = Persona::findOrFail($usuario->idPersona);

    
        $persona->update([
            'Nombre'     => $data['nombre'],
            'apellido1'  => $data['apellido1'],
            'apellido2'  => $data['apellido2'] ?? null,
            'Rut'        => $data['rut'],
            'Email'      => $data['email'],   // ✔ actualizar duplicado
            'telefono'   => $data['telefono'] ?? null,
            'celular'    => $data['celular'] ?? null
        ]);

        // Actualizar datos del usuario
        $usuario->Email = $data['email'];

        if (!empty($data['password'])) {
            $usuario->Contrasena = Hash::make($data['password']);
        }

        $usuario->save();

          // Actualizar rol
        if (!empty($data['rol'])) {

            $nuevoRol = Rol::where('Nombre', $data['rol'])->firstOrFail();

            // borrar roles anteriores
            $usuario->roles()->sync([$nuevoRol->idRol]);
        }

        return [
            'persona' => $persona,
            'usuario' => $usuario,
            'rol'     => $nuevoRol->Nombre ?? 'sin cambios'
        ];
    }


    /**
     * Elimina un usuario del sistema.
     *
     * Este método ejecuta las siguientes acciones:
     *  - Quitar roles asociados en la tabla pivote.
     *  - Eliminar la entrada asociada en Persona.
     *  - Eliminar el registro del usuario.
     *
     * No implementa SoftDelete porque el sistema actualmente no lo utiliza,
     * pero puede adaptarse fácilmente en el futuro.
     *
     * @param  int  $id
     * @return void
     */
    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);

        // Eliminar roles
        $usuario->roles()->detach();

        // Eliminar persona
        Persona::find($usuario->idPersona)?->delete();

        // Eliminar usuario
        $usuario->delete();
    }
}
