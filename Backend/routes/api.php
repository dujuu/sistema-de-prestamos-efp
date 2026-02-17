<?php

use App\Http\Controllers\AsignaturaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController; 
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BloqueController;
use App\Http\Controllers\Prestamo\PrestamoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\mostrar\usuario;
use App\Http\Controllers\Prestamo\PrestamoAdminController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserSancionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EquipoRelacionadoController;
use App\Http\Controllers\TipoEquipoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Prestamo\DevolucionAdminController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\reportes\Dashboard\DashboardReportesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 1. RUTAS PÚBLICAS 
Route::post('/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset', [ResetPasswordController::class, 'reset']);
Route::get('/password/validate-token/{token}', [ResetPasswordController::class, 'validateToken']);

// Ruta para iniciar sesión
// URL: /api/login
Route::post('/login', [AuthController::class, 'login']);
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::post('/auth/google', [AuthController::class, 'googleLogin']);


// Ruta para registrar un nuevo usuario
// URL: /api/register
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta de prueba para verificar el token (ya la tenías)
    // URL: /api/user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/prestamos', [PrestamoController::class, 'store']);
    Route::get('/prestamos', [PrestamoController::class, 'index']);
    Route::get('/prestamos/{id}', [PrestamoController::class, 'show']);
    Route::delete('/prestamos/{id}', [PrestamoController::class, 'destroy']);



    // Ruta para cerrar sesión (requiere que el usuario esté autenticado para invalidar su token)
    // Método: POST
    // URL: /api/logout
    Route::post('/logout', [AuthController::class, 'logout']); 
    //mostrar equipos
    Route::get('/equipos', [EquipoController::class, 'index']);
    Route::get('/userr', [usuario::class, 'index']);

    Route::get('/usuarios',      [UsuarioController::class, 'index']);
    Route::post('/usuarios',     [UsuarioController::class, 'store']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);


    Route::get('/bloques', [BloqueController::class, 'index']);// muestra los bloques
    Route::get('/asignaturas', [AsignaturaController::class, 'index']);// mostramos las asignaturas
    //dashboard de admin
    // Prestamos
    Route::get('/prestamos', [PrestamoController::class, 'index']);
    Route::post('/prestamos', [PrestamoController::class, 'store']);
    // Route::post('/prestamos/solicitar', [PrestamoController::class, 'solicitarPrestamo']);
   
    //Route::get('/admin/dashboard', [AdminDashboardController::class, 'getDashboardData']);
});
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/prestamos/cambiar-estado', [PrestamoAdminController::class, 'cambiarEstado']);
    Route::get('/admin/prestamos/pendientes', [PrestamoAdminController::class, 'verTodosLosPrestamos']);

    Route::get('/admin/sanciones', [UserSancionController::class, 'listarSanciones']);
    Route::get('/admin/sanciones/activa', [UserSancionController::class, 'listarSancionesActivas']);
    Route::post('/admin/sanciones/asignar', [UserSancionController::class, 'asignarSancion']);
    Route::patch('/admin/sanciones/{id}/ampliar', [UserSancionController::class, 'ampliarSancion']);
    Route::patch('/admin/sanciones/{id}/quitar', [UserSancionController::class, 'quitarSancion']);
    Route::post('/admin/devolucion', [DevolucionAdminController::class, 'devolverEquipo']);
    
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('admin/prestamos/pendientes', [PrestamoAdminController::class, 'pendientes']);
    Route::get('admin/prestamos/historial', [PrestamoAdminController::class, 'historial']);

Route::post('admin/prestamos/aprobar/{id}', [PrestamoAdminController::class, 'cambiarEstado']);
Route::post('admin/prestamos/rechazar/{id}', [PrestamoAdminController::class, 'cambiarEstado']);
Route::post('admin/prestamos/{id}/devolver', [PrestamoAdminController::class, 'marcarDevuelto']);



});



//Rutas nuevas, provando

Route::get('/categoria', [CategoriaController::class, 'index']);
Route::post('/categoria', [CategoriaController::class, 'store']);
Route::get('/categoria/{id}', [CategoriaController::class, 'show']);
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy']);





Route::post('/equipos/relacion', [EquipoRelacionadoController::class, 'store']);
Route::delete('/equipos/relacion', [EquipoRelacionadoController::class, 'destroy']);
Route::get('/equipos/{id}/recomendaciones', [EquipoRelacionadoController::class, 'recomendaciones']);


Route::get('/tipoEquipo', [TipoEquipoController::class, 'index']);
Route::post('/tipoEquipo', [TipoEquipoController::class, 'store']);
Route::get('/tipoEquipo/{id}', [TipoEquipoController::class, 'show']);
Route::put('/tipoEquipo/{id}', [TipoEquipoController::class, 'update']);
Route::delete('/tipoEquipo/{id}', [TipoEquipoController::class, 'destroy']);
Route::get('/tipoEquipo/{id}/equipos-disponibles', [TipoEquipoController::class, 'equiposDisponibles']);

Route::get('/catalogo-equipos', [TipoEquipoController::class, 'catalogo']);


Route::post('/equipos/relacion', [EquipoRelacionadoController::class, 'store']);
Route::delete('/equipos/relacion', [EquipoRelacionadoController::class, 'destroy']);
Route::get('/equipos/{id}/recomendaciones', [EquipoRelacionadoController::class, 'recomendaciones']);

// ---------------------------------------------------------------
// Registro de ruta para la creación de equipos
// ---------------------------------------------------------------
Route::post('/equipos', [EquipoController::class, 'store']);
Route::get('/reportes/equipos-mas-solicitados', [ReportesController::class, 'equiposMasSolicitados']);
Route::get('/reportes/uso-interno-externo', [ReportesController::class, 'usoInternoExterno']);
Route::get('/reportes/sanciones-rechazos', [ReportesController::class, 'sancionesYRechazos']);
Route::get('/reportes/equipos-baja', [ReportesController::class, 'equiposDadoDeBaja']);


Route::prefix('reportes/dashboard')->group(function () {
    Route::get('/kpis', [DashboardReportesController::class, 'getKPIs']);
    Route::get('/solicitudes-dia', [DashboardReportesController::class, 'getSolicitudesPorDia']);
    Route::get('/uso-interno-externo', [DashboardReportesController::class, 'getUsoInternoExterno']);
    Route::get('/top-categorias', [DashboardReportesController::class, 'getTopCategorias']);
    Route::get('/sanciones-rechazos', [DashboardReportesController::class, 'getSancionesYRechazos']);
    Route::get('/top-alumnos', [DashboardReportesController::class, 'getTopAlumnos']);
});
