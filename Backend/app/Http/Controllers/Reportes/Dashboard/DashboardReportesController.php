<?php

namespace App\Http\Controllers\Reportes\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Reportes\DashboardReportesService;

class DashboardReportesController extends Controller
{
    protected $service;

    public function __construct(DashboardReportesService $service)
    {
        $this->service = $service;
    }

    // === RUTAS USADAS POR ANGULAR ===

    public function getKPIs()
    {
        return response()->json($this->service->getKPIs());
    }

    public function getSolicitudesPorDia()
    {
        return response()->json($this->service->getSolicitudesPorDia());
    }

    public function getUsoInternoExterno()
    {
        return response()->json($this->service->getUsoInternoExterno());
    }

    public function getTopCategorias()
    {
        return response()->json($this->service->getTopCategorias());
    }

    public function getSancionesYRechazos()
    {
        return response()->json($this->service->getSancionesYRechazos());
    }

    public function getTopAlumnos()
    {
        return response()->json($this->service->getTopAlumnos());
    }
}
