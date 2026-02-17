<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipo\StoreTipoEquipoRequest as EquipoStoreTipoEquipoRequest;
use Illuminate\Http\Request;
use App\Services\TipoEquipoService;
use App\Http\Requests\TipoEquipo\UpdateTipoEquipoRequest;
use App\Http\Requests\TipoEquipo\StoreTipoEquipoRequest;
use App\Models\TipoEquipo;

class TipoEquipoController extends Controller
{
    public function index(TipoEquipoService $service)
    {
        $tequipo = $service->getAll();
        return response()->json($tequipo, 200);
    }
    public function store(StoreTipoEquipoRequest $request, TipoEquipoService $service)
    {
        $data = $request->validated();

        try {

            // =====================================================
            // GUARDAR IMAGEN (si viene)
            // =====================================================
            if ($request->hasFile('imagen')) {
                $ruta = $request->file('imagen')->store('tipo_equipos', 'public');
                $data['imagen'] = $ruta; // se guarda solo la ruta
            }

            $tipoEquipo = $service->create($data);

            return response()->json([
                'message'     => 'Tipo de equipo creado correctamente.',
                'tipoEquipo'  => $tipoEquipo,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'error'   => 'Error al crear el tipo de equipo.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id, TipoEquipoService $service)
    {
        $data = $service->getById($id);
        return response()->json($data,200);
    }
    public function update(UpdateTipoEquipoRequest $request, TipoEquipoService $service, $id)
    {
        $data = $request->validated();
        $tipoEquipo = $service->update($id, $data);

        return response()->json([
            'message' => 'tipo de equipo actualizado correctamente',
            'tipoEquipo' => $tipoEquipo,
        ], 200);
    }
    public function destroy($id, TipoEquipoService $service)
    {
        $resultado = $service->delete($id);

        if ($resultado['error']) {
            return response()->json($resultado, 409);
        }

        return response()->json($resultado, 200);
    }
    public function catalogo()
    {
        $tipos = TipoEquipo::select(
                'tipo_equipos.id',
                'tipo_equipos.nombre',
                'tipo_equipos.descripcion',
                'tipo_equipos.imagen',
                'categorias.nombre as categoria'
            )
            ->leftJoin('categorias', 'categorias.id', '=', 'tipo_equipos.categoria_id')
            ->withCount([
                'equipos as stock' => function ($query) {
                    $query->where('estado', 'disponible');
                }
            ])
            ->get();

        return response()->json($tipos, 200);
    }


    public function equiposDisponibles($id)
    {
        $equipos = \App\Models\Equipo::where('tipo_equipo_id', $id)
            ->where('estado', 'disponible')
            ->select('id', 'codigo', 'estado', 'tipo_equipo_id')
            ->get();

        return response()->json($equipos, 200);
    }


}
