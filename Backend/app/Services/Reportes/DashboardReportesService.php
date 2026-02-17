<?php

namespace App\Services\Reportes;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardReportesService
{
    /* ============================================================
       1) KPIs PRINCIPALES
    ============================================================ */
    public function getKPIs()
    {
        $mesActual = Carbon::now()->month;
        $mesAnterior = Carbon::now()->subMonth()->month;

        return [
            // Préstamos del mes
            'prestamosMes' => DB::table('prestamos')
                ->whereMonth('fecha_inicio', $mesActual)
                ->count(),

            // Préstamos del mes anterior
            'prestamosMesAnterior' => DB::table('prestamos')
                ->whereMonth('fecha_inicio', $mesAnterior)
                ->count(),

            // Equipos disponibles
            'equiposDisponibles' => DB::table('equipos')
                ->where('estado', 'DISPONIBLE')
                ->count(),

            // Usuarios activos (tu columna es estadoSancion / roles / etc)
            'usuariosActivos' => DB::table('users')
                ->where('estadoSancion', '0') // Ajusta si tienes otro estado
                ->count(),

            // Sanciones activas
            'sancionesActivas' => DB::table('sancions as s')
                ->join('user_sancion as us', 's.idSancion', '=', 'us.idSancion')
                ->where('s.estado', 'ACTIVA')
                ->count(),
        ];
    }


    /* ============================================================
       2) SOLICITUDES POR DÍA
    ============================================================ */
    public function getSolicitudesPorDia()
    {
        return DB::table('prestamos')
            ->selectRaw('DATE(fecha_inicio) as fecha, COUNT(*) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
    }


    /* ============================================================
       3) USO INTERNO / EXTERNO GLOBAL
    ============================================================ */
    public function getUsoInternoExterno()
    {
        return DB::table('prestamos')
            ->select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')
            ->get();
    }


    /* ============================================================
       4) TOP CATEGORÍAS MÁS SOLICITADAS
    ============================================================ */
    public function getTopCategorias()
    {
        return DB::table('prestamo_equipo as pe')
            ->join('prestamos as p', 'pe.idPrestamo', '=', 'p.idPrestamo')
            ->join('equipos as e', 'pe.idEquipo', '=', 'e.id')
            ->join('tipo_equipos as t', 'e.tipo_equipo_id', '=', 't.id')
            ->join('categorias as c', 't.categoria_id', '=', 'c.idCategoria')
            ->select('c.nombre as categoria', DB::raw('COUNT(*) as total_solicitudes'))
            ->groupBy('c.idCategoria', 'c.nombre')
            ->orderByDesc('total_solicitudes')
            ->take(5)
            ->get();
    }


    /* ============================================================
       5) SANCIONES Y RECHAZOS
    ============================================================ */
    public function getSancionesYRechazos()
    {
        return [
            'total_sanciones' => DB::table('sancions')
                ->where('estado', 'ACTIVA')
                ->count(),

            'total_rechazos' => DB::table('prestamos')
                ->where('estado', 'RECHAZADO')
                ->count()
        ];
    }


    /* ============================================================
       6) TOP ALUMNOS QUE MÁS PIDEN EQUIPOS
    ============================================================ */
    public function getTopAlumnos()
    {
        return DB::table('prestamos as p')
            ->join('users as u', 'p.idUser', '=', 'u.idUser')
            ->join('persona as per', 'u.idPersona', '=', 'per.idPersona')
            ->select(
                DB::raw("CONCAT(per.Nombre, ' ', per.Apellido1) AS nombre"),
                'u.Email as email',
                DB::raw("COUNT(*) as total_solicitudes")
            )
            ->groupBy('u.idUser', 'u.Email', 'per.Nombre', 'per.Apellido1')
            ->orderByDesc('total_solicitudes')
            ->take(10)
            ->get();
    }
}
