<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Categoria\StoreCategoriaRequest;
use App\Http\Requests\Categoria\UpdateCategoriaRequest;
use App\Services\CategoriaService;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriaService $service)
    {
        $a = $service->getAll();    
        
        return response()->json($a, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request, CategoriaService $service)
    {
        $data = $request->validated();
        try
        {
            $categoria = $service->create($data);
            return response()->json([
                'message'  => 'categoria creada correctamente',
                'categoria' => $categoria,
            ], 201);

        }catch(\Exception $e){
            return response()->json([
                'error'   => 'error al crear la cateogira',
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, CategoriaService $service)
    { 
        $data = $service->getById($id);
        return response()->json($data ,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, CategoriaService $service, $id)
    {
        $data = $request->validated();
        $categoria = $service->update($id, $data);
        return response()->json([
            'message' => 'categoria actualizada correctamente',
            'categoria' => $categoria,
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CategoriaService $service)
    {
        $resultado = $service->delete($id);

        if ($resultado['error']) {
            return response()->json($resultado, 409);
        }

        return response()->json($resultado, 200);
    }



}
